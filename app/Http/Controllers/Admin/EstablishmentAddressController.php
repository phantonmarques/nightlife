<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateOrUpdatePermission;
use App\Models\Admin\EstablishmentAddress;
use App\Models\Admin\Establishment;
use App\Http\Requests\CreateOrUpdateEstablishmentAddress;
use App\Models\Admin\EstablishmentPhones;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Site\User;
use App\Models\Site\State;
use App\Models\Site\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstablishmentAddressController extends Controller
{
    protected $paginate = 10;

    /**
     * EstablishmentAddressController constructor.
     */
    public function __construct()
    {
        #SOMENTE AUTENTICADOS
        $this->middleware('auth');
        #SOMENTE COM A FUNÇÃO ATIVA [ADMIN]
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prepareIndex()
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        $establishments = Establishment::where('status', 1)->pluck('corporate_name', 'id');

        return view('admin.establishmentAddress.prepareIndex',
            compact('establishments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Admin\EstablishmentAddress
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EstablishmentAddress $establishmentAddress)
    {
        if (! auth()->user()->can('manage-establishment'))
            return abort(401);

        $establishmentAddressPrepare = $request->query('e');

        $establishmentAddressSearch = $request->query('s');

        if (!empty(trim($establishmentAddressPrepare)))
            session()->put('establishment', $establishmentAddressPrepare);
        else
            $establishmentAddressPrepare = session()->get('establishment');

        if (empty(trim($establishmentAddressPrepare)))
            return redirect()
                ->route('establishment.prepareIndex')
                ->withInput()
                ->with('error', 'Selecione o estabelecimento novamente!');

        if (!empty($establishmentAddressSearch))
            $establishmentsAddress = $establishmentAddress->where([['establishment_id', $establishmentAddressPrepare],
                                        ['street_name', 'like', "%{$establishmentAddressSearch}%"]])->paginate($this->paginate);
        else
            $establishmentsAddress = $establishmentAddress->with(['establishments_phone' => function($q){
                $q->where('main', 1);}])->where('establishment_id', $establishmentAddressPrepare)->paginate($this->paginate);

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

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $establishmentAddressExists = EstablishmentAddress::where([['street_name', $data["street_name"]], ['building_number', $data["building_number"]]])->count();

            if ($establishmentAddressExists > 0)
                return redirect()
                    ->route('establishmentAddress.create')
                    ->withInput()
                    ->with('error', 'Endereço já cadastrado, favor informe outro!');

            if (!isset($data["establishment_id"]))
                $data["establishment_id"] = session()->get('establishment');

            $establishmentAddress = EstablishmentAddress::create($data);

            if (!$establishmentAddress->exists)
                throw new \Exception('Não foi possível criar o estabelecimento!');

            foreach ($data["contact"] as $key => $contact):
                $contact["establishment_address_id"] = $establishmentAddress->id;
                $contact["establishment_id"] = session()->get('establishment');

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

        $data = $request->validated();

        DB::beginTransaction();

        try {
            if (!isset($data["establishment_id"]))
                $data["establishment_id"] = session()->get('establishment');

            $establishmentAddress->fill($data);

            if ($establishmentAddress->isDirty())
                if (!$establishmentAddress->save())
                    throw new \Exception('Não foi possível atualizar o estabelecimento');

            if (array_key_exists('contact', $data)):
               $establishmentAddress->establishments_phone()->delete();

                foreach ($data["contact"] as $key => $contact):
                    $contact["establishment_address_id"] = $establishmentAddress->id;
                    $contact["establishment_id"] = session()->get('establishment');

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
                DB::rollBack();

                return redirect()
                    ->route('establishmentAddress.index', compact('establishmentAddress'))
                    ->withInput()
                    ->with('error', 'Ocorreu um erro desconhecido ao excluir o endereço, tente novamente.');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('establishmentAddress.index', compact('establishmentAddress'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
