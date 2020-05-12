<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\EstablishmentAddress;
use App\Http\Requests\CreateOrUpdateEstablishmentAddress;
use App\Models\Admin\EstablishmentPhones;
use Illuminate\Support\Facades\DB;
use App\Models\Site\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class EstablishmentAddressController extends Controller
{
    protected $paginate = 10;
    protected $keyMaps = '5r2Oz1paGAA_xfzWLlIcjpQq4DZPwMD4iPV5_mTP9m8';
    protected $urlMaps = 'https://geocode.search.hereapi.com/v1/geocode';

    /**
     * EstablishmentAddressController constructor.
     */
    public function __construct()
    {
        #ONLY AUTH
        $this->middleware('auth');
        #ONLY WITH ROLE ACTIVE [ADMIN]
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Admin\EstablishmentAddress
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        $establishmentAddressSearch = $request->query('s');

        if (empty(auth()->user()->establishment_connect))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        # Log Access Users
        $this->access('Index Endereços Estabelecimento');

        if (!empty($establishmentAddressSearch))
            $establishmentsAddress = EstablishmentAddress::where([['establishment_id', auth()->user()->establishment_connect],
                                        ['street_name', 'like', "%{$establishmentAddressSearch}%"]])->paginate($this->paginate);
        else
            $establishmentsAddress =  EstablishmentAddress::with(['establishments_phone' => function($q){
                $q->where('main', 1);}])->where('establishment_id', auth()->user()->establishment_connect)->paginate($this->paginate);

        return view('admin.establishmentAddress.index',
            compact( 'establishmentsAddress',
                'establishmentAddressSearch' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => 'establishmentAddress.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormEstablishmentAddress(this)'
        ];

        /** @var array States array for select */
        $states = State::pluck('name_visible', 'id')->toArray();

        $establishmentAddress = new EstablishmentAddress();

        return view('admin.establishmentAddress.form',
            compact('establishmentAddress',
                'states',
                'formOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateEstablishmentAddress  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateEstablishmentAddress $request)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        if (empty(auth()->user()->establishment_connect))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $data = $request->validated();

        # Log Access Users
        $this->access('Criar Endereços Estabelecimento', $data);

        DB::beginTransaction();

        try {
            $establishmentAddressExists = EstablishmentAddress::where([['street_name', $data["street_name"]], ['building_number', $data["building_number"]]])->count();

            if ($establishmentAddressExists > 0)
                return redirect()
                    ->route('establishmentAddress.create')
                    ->withInput()
                    ->with('error', 'Endereço já cadastrado, favor informe outro!');

            if (!isset($data["establishment_id"]))
                $data["establishment_id"] = auth()->user()->establishment_connect;

            $latLong = $this->getLatLong($data["street_name"], $data["building_number"], $data["neighborhood"], $data["zip_code"]);

            if (!empty($latLong))
                $data["location"] = new Point($latLong->lat, $latLong->lng);

            $establishmentAddress = EstablishmentAddress::create($data);

            if (!$establishmentAddress->exists)
                throw new \Exception('Não foi possível criar o estabelecimento!');

            foreach ($data["contact"] as $key => $contact):
                $contact["establishment_address_id"] = $establishmentAddress->id;
                $contact["establishment_id"] = auth()->user()->establishment_connect;

                if ($key === 0)
                    $contact["main"] = 1;

                $establishmentPhones = EstablishmentPhones::create($contact);

                if (!$establishmentPhones->exists)
                    throw new \Exception('Não foi possível criar o contato!');

            endforeach;

            DB::commit();

            return redirect()
                ->route('establishmentAddress.index')
                ->with('success', 'Endereço do estabelecimento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();;

            return redirect()
                ->route('establishmentAddress.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function show(EstablishmentAddress $establishmentAddress)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        return view('admin.establishmentAddress.show', compact(
            'establishmentAddress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(EstablishmentAddress $establishmentAddress)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => ['establishmentAddress.update', $establishmentAddress],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormEstablishmentAddress(this)'
        ];

        /** @var array States array for select */
        $states = State::pluck('name_visible', 'id')->toArray();

        return view('admin.establishmentAddress.form',
            compact('establishmentAddress',
                'states',
                'formOptions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\CreateOrUpdateEstablishmentAddress  $request
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateEstablishmentAddress $request, EstablishmentAddress $establishmentAddress)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        if (empty(auth()->user()->establishment_connect))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização Endereços Estabelecimento', $data);

        DB::beginTransaction();

        try {
            if (!isset($data["establishment_id"]))
                $data["establishment_id"] = auth()->user()->establishment_connect;

            $latLong = $this->getLatLong($data["street_name"], $data["building_number"], $data["neighborhood"], $data["zip_code"]);

            if (!empty($latLong))
                $data["location"] = new Point($latLong->lat, $latLong->lng);

            $establishmentAddress->fill($data);

            if ($establishmentAddress->isDirty())
                if (!$establishmentAddress->save())
                    throw new \Exception('Não foi possível atualizar o estabelecimento');

            if (array_key_exists('contact', $data)):
               $establishmentAddress->establishments_phone()->delete();

                foreach ($data["contact"] as $key => $contact):
                    $contact["establishment_address_id"] = $establishmentAddress->id;
                    $contact["establishment_id"] = auth()->user()->establishment_connect;

                    if ($key === 0)
                        $contact["main"] = 1;

                    $establishmentPhones = EstablishmentPhones::create($contact);

                    if (!$establishmentPhones->exists)
                        throw new \Exception('Não foi possível atualizar o contato!');

                endforeach;
            endif;

            DB::commit();

            return redirect()
                ->route('establishmentAddress.index')
                ->with('success', 'Endereço do estabelecimento atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('establishmentAddress.edit', compact('establishmentAddress'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return false
     */
    public function destroy(EstablishmentAddress $establishmentAddress)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        # Log Access Users
        $this->access('Exclusão Endereços Estabelecimento', $establishmentAddress);

        DB::beginTransaction();

        try {
            /** @var Illuminate\Database\Eloquent\Relations\HasMany */
            $establishmentAddress->establishments_phone()->delete();

            if ($establishmentAddress->delete()):
                DB::commit();

                return redirect()
                    ->route('establishmentAddress.index')
                    ->with('success', 'Endereço do estabelecimento excluído com sucesso');
            else:
                throw new \Exception('Não foi possível excluir o endereço!');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('establishmentAddress.index', compact('establishmentAddress'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Get long and lat geolocation address
     */
    private function getLatLong($street_name, $building_number, $neighborhood, $zip_code)
    {
        $response = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => urlencode("{$street_name} {$building_number} {$neighborhood} {$zip_code}")))
            ->returnResponseObject()
            ->get();

        $response = json_decode($response->content);

        if (!empty($response->items[0]->position))
            return $response->items[0]->position;

        return false;
    }

    /**
     * Create Access Log User
     */
    private function access($description, $content = NULL, $class = __CLASS__)
    {
        auth()->user()->user_access()->create([
            'class' => $class,
            'establishment_connect' => !empty(auth()->user()->establishment_connect) ? auth()->user()->establishment_connect : NULL,
            'description' => $description,
            'content' => $content,
            'data_access' => date('YmdHis')
        ]);
    }
}
