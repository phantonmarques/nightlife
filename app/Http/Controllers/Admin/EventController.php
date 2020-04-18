<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Event;
use App\Models\Admin\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    protected $paginate = 10;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        #SOMENTE AUTENTICADOS
        $this->middleware('auth');
        #SOMENTE COM A FUNÇÃO ATIVA [ADMIN]
        $this->middleware(['role:admin'], ['role:establishment']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prepareIndex()
    {
        if (! auth()->user()->can('manage-establishment') && ! auth()->user()->can('establishment-manager'))
            return abort(401);

        $establishments = Establishment::where('status', 1)->pluck('corporate_name', 'id');

        return view('admin.event.prepareIndex',
            compact('establishments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-establishment') && ! auth()->user()->can('establishment-manager'))
            return abort(401);

        $eventPrepare = $request->query('e');

        $eventSearch = $request->query('s');

        if (!empty(trim($eventPrepare)) && auth()->user()->can('manage-establishment'))
            session()->put('establishment', $eventPrepare);
        else if (auth()->user()->can('manage-establishment'))
            $eventPrepare = session()->get('establishment');
        else
            $eventPrepare = Establishment::find(auth()->user()->id);

        if (empty(trim($eventPrepare)) && auth()->user()->can('manage-establishment'))
            return redirect()
                ->route('establishment.prepareIndex')
                ->withInput()
                ->with('error', 'Selecione o estabelecimento novamente!');

        if (!empty($eventSearch))
            $events = Event::where([['name', 'like', "%{$eventSearch}%"]])->paginate($this->paginate);
        else
            $events = Event::with('establishment')
                        ->where('establishment_id', $eventPrepare)->paginate($this->paginate);


        return view('admin.event.index',
            compact( 'events',
                'eventSearch' ));

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
     * @param  \App\Models\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
