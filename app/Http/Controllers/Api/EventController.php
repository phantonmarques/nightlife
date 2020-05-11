<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\EstablishmentAddress;
use App\Models\Site\UserRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Event;
use App\Models\Admin\Establishment;
use App\Models\Admin\Rhythm;
use Grimzy\LaravelMysqlSpatial\Types\Point;

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

    /**
     * Function get event info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function event($id){
        $event = Event::with('establishment:id,corporate_name,details')
                    ->with('establishment_address')->find($id);

        if (isset($event->name)):
            $phone = $event->establishment_address->establishments_phone()->where('main', 1)->select('phone', 'whatsapp')->first();

            $event->increment('views');

            return response()->json([
                'status' => true,
                'data' => array(
                    "event" => $event,
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
    public function eventsRecommended(Request $request)
    {
        # TODO: Search type location current or registred city in user.
        $addressFilter = EstablishmentAddress::distanceSphere( 'location', new Point(floatval($request->lat), floatval($request->long)), 50000)
            ->orWhere('city_id', (!empty(auth()->user()->city_id) ? auth()->user()->city_id : 0))
            ->select('city_id')->get();

        # init event
        $events = array();

        # TODO: Localization + Favorite
        if (!empty(auth()->user()->city_id) && (!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms))):
            $establishmentsFavorite = array();

            if (!empty(auth()->user()->user_settings->favorite_categorys)):
                $establishmentsCategory = Establishment::whereStatus(1)->whereHas('establishments_category', function ($q) {
                    $q->whereIn('category_id', auth()->user()->user_settings->favorite_categorys);})->select('id')->get()->toArray();

                    $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsCategory);

            endif;

            if (!empty(auth()->user()->user_settings->favorite_rhythms)):
                $establishmentsRhythm = Establishment::whereStatus(1)->whereHas('establishments_rhythm', function ($q) {
                    $q->whereIn('rhythm_id', auth()->user()->user_settings->favorite_rhythms);})->select('id')->get()->toArray();

                    $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsRhythm);
            endif;

            $events = Event::whereStatus(1)->whereHas('establishment_address', function ($q) use ($addressFilter) {
                $q->whereIn('city_id', $addressFilter);})->whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();

        endif;

        # TODO: Localization
        if (count($addressFilter) > 0 && count($events) === 0):
            $events = Event::whereStatus(1)->whereHas('establishment_address', function ($q) use ($addressFilter) {
                $q->whereIn('city_id', $addressFilter);})->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();

        endif;

        # TODO: Favorite
        if ((!empty(auth()->user()->user_settings->favorite_categorys) || !empty(auth()->user()->user_settings->favorite_rhythms)) && count($events) === 0):
            $establishmentsFavorite = array();

            if (!empty(auth()->user()->user_settings->favorite_categorys)):
                $establishmentsCategory = Establishment::whereStatus(1)->whereHas('establishments_category', function ($q) {
                    $q->whereIn('category_id', auth()->user()->user_settings->favorite_categorys);})->select('id')->get()->toArray();

                $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsCategory);

            endif;

            if (!empty(auth()->user()->user_settings->favorite_rhythms)):
                $establishmentsRhythm = Establishment::whereStatus(1)->whereHas('establishments_rhythm', function ($q) {
                    $q->whereIn('rhythm_id', auth()->user()->user_settings->favorite_rhythms);})->select('id')->get()->toArray();

                $establishmentsFavorite = array_merge($establishmentsFavorite, $establishmentsRhythm);
            endif;

            $events = Event::whereStatus(1)->whereIn('establishment_id', $establishmentsFavorite)->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();

        endif;

        # TODO: Top Views
        if (count($events) === 0):
            $events = Event::whereStatus(1)->orderBy('views', 'desc')->offset(0)->limit($this->paginate)->get();
        endif;

        foreach ($events as $key => $event) {
            $events[$key]->rating_establishment = UserRating::where('establishment_id', $events[$key]->establishment_id)->avg('rating');
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
            'categories' => $this->categorys(),
            'rhythms' => $this->rhythms()
        );

        if (!empty($filters))
            return response()->json([
                'status' => true,
                'data' => $filters
            ]);
        else
            return response()->json([
                'status' => false,
                'message' => "Não existe nenhum filtro relacionado a estabelecimentos!"
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
        $category = $rhythm = [];
        $type = $request->input('type', 'events'); //Busca o valor do type, caso não exista, seta como 'events'
        $distance = $request->input('distance', 999999);

        # FORMATAÇÃO DOS DADOS RECEBIDOS
        foreach ($request->all() as $key => $requestField):
            if (strpos($key, 'category') !== false)
                $category[] = preg_split("/(\[|\])/", $key)[1];
            else if (strpos($key, 'rhythm') !== false)
                $rhythm[] = preg_split("/(\[|\])/", $key)[1];

        endforeach;

        if (sizeof($category) === 0)
            $category = null;
//        else # COUNTERS CATEGORY
//            incrementViewCategory()

        if (sizeof($rhythm) === 0)
            $rhythm = null;
        //        else # COUNTERS RHYTHM
//            incrementViewRhythm()

        # FIM FORMATAÇÃO

        $addressFilter = EstablishmentAddress::distanceSphere( 'location', new Point(floatval($request->lat), floatval($request->long)), ($distance * 1000))
            ->orWhere('city_id', (!empty(auth()->user()->city_id) ? auth()->user()->city_id : 0))
            ->get();

        # TODO: Search type establishment
        if ($type === 'establishment'):
            if ($category && $rhythm): # Category and Rhythm Selected
                if (empty($request->search)):
                    $object = Establishment::whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                            $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })
                        ->whereHas('establishments_category', function ($q) use ($category) {
                            $q->whereIn('category_id', (!empty($category) ? $category : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Establishment::whereLike(['corporate_name'], $request->search)
                        ->whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                            $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })
                        ->whereHas('establishments_category', function ($q) use ($category) {
                            $q->whereIn('category_id', (!empty($category) ? $category : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            elseif ($category): # Category Selected
                if (empty($request->search)):
                    $object = Establishment::whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_category', function ($q) use ($category) {
                            $q->whereIn('category_id', (!empty($category) ? $category : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Establishment::whereLike(['corporate_name'], $request->search)
                        ->whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_category', function ($q) use ($category) {
                            $q->whereIn('category_id', (!empty($category) ? $category : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            elseif ($rhythm): # Rhythm Selected
                if (empty($request->search)):
                    $object = Establishment::whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                            $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Establishment::whereLike(['corporate_name'], $request->search)
                        ->whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                            $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            else: # Distance
                if (empty($request->search)):
                    $object = Establishment::whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Establishment::whereLike(['corporate_name'], $request->search)
                        ->whereStatus(1)->select('id', 'corporate_name')->with('establishment_address')
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            endif;

            foreach ($object as &$obj)
                $obj["rating_establishment"] = UserRating::where('establishment_id', $obj->id)->avg('rating');

        # TODO: Search type events
        elseif ($type === 'events'):
            if ($category && $rhythm): # Category and Rhythm Selected
                $establishment = Establishment::whereStatus(1)
                    ->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                        $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })
                    ->whereHas('establishments_category', function ($q) use ($category) {
                        $q->whereIn('category_id', (!empty($category) ? $category : array())); })->select('id')->get();

                if (empty($request->search)):
                    $object = Event::whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Event::whereLike(['name', 'date_event', 'description', 'start_time'], $request->search)
                        ->whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            elseif ($category): # Category Selected
                $establishment = Establishment::whereStatus(1)->whereHas('establishments_category', function ($q) use ($category) {
                    $q->whereIn('category_id', (!empty($category) ? $category : array())); })->select('id')->get();

                if (empty($request->search)):
                    $object = Event::whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Event::whereLike(['name', 'date_event', 'description', 'start_time'], $request->search)
                        ->whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                endif;

            elseif ($rhythm): # Rhythm Selected
                $establishment = Establishment::whereStatus(1)->whereHas('establishments_rhythm', function ($q) use ($rhythm) {
                    $q->whereIn('rhythm_id', (!empty($rhythm) ? $rhythm : array())); })->select('id')->get();

                if (empty($request->search)):
                    $object = Event::whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();
                else:
                    $object = Event::whereLike(['name', 'date_event', 'description', 'start_time'], $request->search)
                        ->whereStatus(1)->with('establishment_address')->whereIn('establishment_id', $establishment)
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();

                endif;
            else: # Distance
                if (empty($request->search)):
                    $object = Event::whereStatus(1)->with('establishment_address')
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();

                else:
                    $object = Event::whereLike(['name', 'date_event', 'description', 'start_time'], $request->search)->with('establishment_address')
                        ->whereHas('establishment_address', function ($q) use ($addressFilter) {
                            $q->whereIn('id', $addressFilter); })->get();

                endif;

            endif;

            foreach ($object as &$obj)
                $obj["rating_establishment"] = UserRating::where('establishment_id', $obj->establishment_id)->avg('rating');

        endif;

        if (count($object) > 0)
            return response()->json([
                'status' => true,
                'data' => $object
            ]);

        return response()->json([
            'status' => false,
            'data' => []
        ]);
    }
}
