<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Event;

class EventController extends Controller
{

    /**
     * EventController constructor.
     */
    public function __construct()
    {
        #ONLY AUTH
//        $this->middleware('auth');
    }


    public function eventsRecommended()
    {
        if (!empty(auth()->user()->city_id) && (!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms))):
            $events = Event::whereHas('establishment_address', function ($q) {
                $q->where('city_id', auth()->user()->city_id);})->orderBy('views')->get();
        elseif (!empty(auth()->user()->city_id)):
            $events = Event::whereHas('establishment_address', function ($q) {
                $q->where('city_id', auth()->user()->city_id);})->orderBy('views')->get();
        elseif (!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms)):
            echo 'if3';
        endif;

        if (count($events) === 0):
            $events = Event::orderBy('views')->get();
        endif;

        return response()->json([
            'status' => true,
            'return' => $events
        ]);
//
//        1: Localização + Gostos
//		2: Localização
//		3: Gostos
//		4: Mais vistos


//        dd(auth()->user()->city_id);
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
