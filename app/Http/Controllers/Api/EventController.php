<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Event;
use App\Models\Admin\Establishment;
use App\Models\Admin\Rhythm;

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


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventsRecommended()
    {
        $events = array();
        # TODO: (Localization + Favorite) or (Localization)
        # Search events for city and (category or rhythm)
        if (!empty(auth()->user()->city_id) && (!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms))):
            $establishmentsFavorite = array();

            if (!empty(auth()->user()->user_settings->favorite_categorys)):
                $establishmentsCategory = Establishment::whereHas('establishments_category', function ($q) {
                    $q->whereIn('category_id', auth()->user()->user_settings->favorite_categorys);})->select('id')->get()->toArray();

                    $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsCategory);

            endif;

            if (!empty(auth()->user()->user_settings->favorite_rhythms)):
                $establishmentsRhythm = Establishment::whereHas('establishments_rhythm', function ($q) {
                    $q->whereIn('rhythm_id', auth()->user()->user_settings->favorite_rhythms);})->select('id')->get()->toArray();

                    $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsRhythm);
            endif;

            $events = Event::whereHas('establishment_address', function ($q) {
                $q->where('city_id', auth()->user()->city_id);})->whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->get();
        endif;

        # TODO: Localization
        if (!empty(auth()->user()->city_id) && count($events) === 0):
            $events = Event::whereHas('establishment_address', function ($q) {
                $q->where('city_id', auth()->user()->city_id);})->orderBy('views')->get();
        endif;

        # TODO: Favorite
        if ((!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms)) && count($events) === 0):
            $establishmentsFavorite = array();

            if (!empty(auth()->user()->user_settings->favorite_categorys)):
                $establishmentsCategory = Establishment::whereHas('establishments_category', function ($q) {
                    $q->whereIn('category_id', auth()->user()->user_settings->favorite_categorys);})->select('id')->get()->toArray();

                $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsCategory);

            endif;

            if (!empty(auth()->user()->user_settings->favorite_rhythms)):
                $establishmentsRhythm = Establishment::whereHas('establishments_rhythm', function ($q) {
                    $q->whereIn('rhythm_id', auth()->user()->user_settings->favorite_rhythms);})->select('id')->get()->toArray();

                $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsRhythm);
            endif;

            $events = Event::whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->get();
        endif;

        # TODO: Top Views
        if (count($events) === 0):
            $events = Event::orderBy('views')->get();
        endif;

        return response()->json([
            'status' => true,
            'return' => $events
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventsFilter(){
        $filters = array(
            'category' => $this->categorys(),
            'rhythm' => $this->rhythms()
        );

        if (!$filters)
            return response()->json([
                'status' => true,
                'return' => $filters
            ]);
        else
            return response()->json([
                'status' => false,
                'return' => "Não existe nenhum filtro relacionado a estabelecimentos!"
            ]);

    }

    /**
     * @return Category exists in establishment
     */
    private function categorys(){
        return Category::whereHas('category_establishments')->select('id', 'name')->get();
    }

    /**
     * @return Rhythm exists in establishment
     */
    private function rhythms(){
        return Rhythm::whereHas('rhythm_establishments')->select('id', 'name')->get();
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
