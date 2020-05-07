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
    protected $paginate = 10;

    /**
     * EventController constructor.
     */
    public function __construct()
    {
        #ONLY AUTH
//        $this->middleware('auth');
    }

    public function event($id){
        $event = Event::find($id);

        if (isset($event->name)):
            $establishment = $event->establishment->select('corporate_name', 'id')->first();

            $address = $event->establishment_address->select('zip_code', 'street_name', 'building_number', 'neighborhood')->first();

            $phone = $event->establishment_address->establishments_phone()->where('main', 1)->select('phone', 'whatsapp')->first();

            $event->increment('views');

            return response()->json([
                'status' => false,
                'data' => array(
                    "address" => $address,
                    "establishment" => $establishment,
                    "event" => $event->get(),
                    "phone" => $phone,
                )
            ]);

        endif;

        return response()->json([
            'status' => false,
            'data' => "Evento não encontrado!"
        ]);
    }


    /**
     * Functions get events recommended (Home page)
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventsRecommended()
    {
        $events = array();
        # TODO: Localization + Favorite
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
                $q->where('city_id', auth()->user()->city_id);})->whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();
        endif;

        # TODO: Localization
        if (!empty(auth()->user()->city_id) && count($events) === 0):
            $events = Event::whereHas('establishment_address', function ($q) {
                $q->where('city_id', auth()->user()->city_id);})->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();
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

            $events = Event::whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();
        endif;

        # TODO: Top Views
        if (count($events) === 0):
            $events = Event::orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();
        endif;

        foreach ($events as $key => $event) {
            $events[$key]->description = strip_tags($events[$key]->description);
        }

        return response()->json([
            'status' => true,
            'data' => $events
        ]);
    }

    /**
     * Functions get events filters available
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventsFilter(){
        $filters = array(
            'category' => $this->categorys(),
            'rhythm' => $this->rhythms()
        );

        if (!empty($filters))
            return response()->json([
                'status' => true,
                'data' => $filters
            ]);
        else
            return response()->json([
                'status' => false,
                'data' => "Não existe nenhum filtro relacionado a estabelecimentos!"
            ]);
    }

    /**
     * Function get category used in establishments
     * @return Category exists in establishment
     */
    private function categorys(){
        return Category::whereHas('category_establishments')->select('id', 'name')->get();
    }

    /**
     * Function get rhythm used in establishments
     * @return Rhythm exists in establishment
     */
    private function rhythms(){
        return Rhythm::whereHas('rhythm_establishments')->select('id', 'name')->get();
    }


    /**
     * Function get events search
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventsSearch(Request $request)
    {
        //SOMAR CONTADORES CATEGORIA, RITMOS
        # TODO: Search type establishment
        if ($request->type === 'establishment'):
            # Category Selected and Rhythm Selected
            if (!empty($request->category) && !empty($request->rhythm)):
                $establishments = Establishment::whereHas('establishments_rhythm', function ($q) {
                    $q->whereIn('rhythm_id', auth()->user()->user_settings->favorite_rhythms);})->get();
            elseif (!empty($request->category)):

            elseif (!empty($request->rhythm)):

            endif;

        # TODO: Search type events
        elseif ($request->type === 'events'):

        endif;

        return response()->json([
            'status' => false,
            'return' => "Pesquisa não encontrada!"
        ]);
    }
}
