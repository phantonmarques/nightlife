<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\EstablishmentAddress;
use App\Models\Admin\Establishment;
use App\Models\Site\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstablishmentAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prepareIndex()
    {
        $userActive = auth()->user()->name;

        return view('admin.establishmentAddress.prepareIndex', compact('userActive'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
