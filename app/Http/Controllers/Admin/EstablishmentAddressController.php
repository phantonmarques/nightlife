<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\EstablishmentAddress;
use App\Models\Admin\Establishment;
use App\Http\Requests\CreateOrUpdateEstablishmentAddress;
use Illuminate\Support\Facades\DB;
use App\Models\Site\User;
use App\Models\Site\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstablishmentAddressController extends Controller
{
    protected $paginate = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prepareIndex()
    {
        $userActive = auth()->user()->name;

        //VERIFICAÇÃO DE USUÁRIO MASTER

        $establishments = Establishment::where('status', 1)->pluck('corporate_name', 'id');

        return view('admin.establishmentAddress.prepareIndex', compact('userActive','establishments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EstablishmentAddress $establishmentAddress)
    {
        $userActive = auth()->user()->name;

        $establishmentPrepare = $request->query('e');

        if (!empty(trim($establishmentPrepare)))
            session()->put('establishment', $establishmentPrepare);
        else
            $establishmentPrepare = session()->get('establishment');


        if (empty(trim($establishmentPrepare)))
            return redirect()
                ->route('establishment.prepareIndex')
                ->withInput()
                ->with('error', 'Selecione o estabelecimento novamente!');

        $establishmentsAdress = $establishmentAddress->with('establishments_phone')->where('establishment_id', $establishmentPrepare)->paginate($this->paginate);

        $establishment = Establishment::where("id", $establishmentPrepare)->select('corporate_name')->first()->corporate_name;

        return view('admin.establishmentAddress.index', compact( 'userActive', 'establishmentsAdress', 'establishment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userActive = auth()->user()->name;

        /** Create form options */
        $formOptions = [
            'route' => 'establishmentAddress.store',
            'method' => Request::METHOD_POST,
            'onsubmit' => 'return validateFormEstablishmentAddress(this)'
        ];

        /** @var array States array for select */
        $states = State::pluck('name_visible', 'state_cod')->toArray();

        $establishmentAddress = new EstablishmentAddress();

        return view('admin.establishmentAddress.form', compact('userActive', 'establishmentAddress', 'states', 'formOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateEstablishmentAddress $request)
    {
        $data = $request->validated();

        dd($data);

        DB::beginTransaction();

        try {
            if (!is_int($data["state_id"]))
                $data["state_id"] = State::where('state_cod', $data["state_id"])->select('id')->first()->id;

            if (!isset($data["establishment_id"]))
                $data["establishment_id"] = session()->get('establishment');

            $establishmentAddress = EstablishmentAddress::create($data);

            if (!$establishmentAddress->exists) {
                throw new \Exception('Não foi possível criar o estabelecimento!');
            }

//            foreach ($data["name"] as $key => $contact){
//                echo($contact." - ". $data["phone"][$key] . " - " . $request->whatsapp_"<br>");
//            }

            DB::rollBack();
            die('oibb');
//            $table->unsignedInteger('establishment_address_id');
//            $table->unsignedInteger('establishment_id');
//            $table->string('name');
//            $table->string('phone_number');
//            $table->string('whatsapp')->nullable();

            DB::commit();

            return redirect()
                ->route('establishment.index')
                ->with('success', 'Estabelecimento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            die($e->getMessage());


            return redirect()
                ->route('establishment.create')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(EstablishmentAddress $establishmentAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstablishmentAddress $establishmentAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\EstablishmentAddress  $establishmentAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstablishmentAddress $establishmentAddress)
    {
        //
    }
}
