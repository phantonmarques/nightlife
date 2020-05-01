<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\City;
use App\Models\Site\State;

class AdminController extends Controller
{

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        #ONLY AUTH
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.index');
    }


    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function establishmentConnect(Request $request)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        $user = auth()->user();
        $user->establishment_connect = intval($request->establishment_connect);

        if (!$user->save())
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar o estabelecimento conectado!');

        if (intval($request->establishment_connect) === 0)
            return redirect()
                ->route('admin.page')
                ->withInput()
                ->with('success', 'Desconectado do estabelecimento com sucesso!');

        return redirect()
            ->back()
            ->withInput()
            ->with('success', 'Conectado ao estabelecimento com sucesso!');
    }

    /**
     * Function Search citys of certain state
     * @param $stateSelect
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCitys($stateSelect){
        if (! auth()->user()->can('manage-users') && ! auth()->user()->can('manage-called'))
            return abort(401);

        return response()->json(City::where('state_id', $stateSelect)->select( 'id', 'name', 'name_visible')->get());
    }

    /**
     * Function Search state selected
     * @param $state
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchState($state){
        if (! auth()->user()->can('manage-users') && ! auth()->user()->can('manage-called'))
            return abort(401);

        return response()->json(State::where('state_cod', $state)->select('id')->first());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
