<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Requests\CreateOrUpdateEvent;
    use App\Models\Admin\EstablishmentAddress;
    use App\Models\Admin\Event;
    use App\Models\Admin\Establishment;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

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
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
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
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            $eventPrepare = $request->query('e');

            $eventSearch = $request->query('s');

            if (!empty(trim($eventPrepare)) && auth()->user()->can('manage-establishment'))
                session()->put('establishment', $eventPrepare);
            else if (auth()->user()->can('manage-establishment'))
                $eventPrepare = session()->get('establishment');
            else
                $eventPrepare = auth()->user()->establishments()->id;

            if (empty(trim($eventPrepare)) && auth()->user()->can('manage-establishment'))
                return redirect()
                    ->route('establishment.prepareIndex')
                    ->withInput()
                    ->with('error', 'Selecione o estabelecimento novamente!');

            if (!empty($eventSearch))
                $events = Event::where([['name', 'like', "%{$eventSearch}%"], ['status', 1]])->paginate($this->paginate);
            else
                $events = Event::with('establishment')
                    ->where([['establishment_id', $eventPrepare], ['status', 1]])->paginate($this->paginate);


            return view('admin.event.index',
                compact('events',
                    'eventSearch'));

        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route' => 'event.store',
                'method' => Request::METHOD_POST,
                'files' => true,
                'onsubmit' => 'return validateFormEvent(this)'
            ];

            if (auth()->user()->establishments()->count() > 0)
                $establishment_id = auth()->user()->establishments()->id;
            else
                $establishment_id = session()->get('establishment');

            $addresses = EstablishmentAddress::where('establishment_id', $establishment_id)->get();

            $event = new Event();

            return view('admin.event.form',
                compact('formOptions',
                    'addresses',
                    'event'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\CreateOrUpdateEvent $request
         * @return \Illuminate\Http\Response
         */
        public function store(CreateOrUpdateEvent $request)
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            $data = $request->validated();

            DB::beginTransaction();

            try {
                if (array_key_exists('cover_path', $data)):
                    if ($data['cover_path'] instanceof UploadedFile):
                        if (!($path = $data['cover_path']->storePublicly('event')))
                            throw new \Exception('Não foi possível armazenar a foto do evento!');

                        $data["cover_path"] = $path;
                    endif;
                endif;

                if (auth()->user()->establishments()->count() > 0)
                    $data["establishment_id"] = auth()->user()->establishments()->id;
                else
                    $data["establishment_id"] = session()->get('establishment');

                $event = Event::create($data);

                if (!$event->exists)
                    throw new \Exception('Não foi possível criar o evento!');

                DB::commit();

                return redirect()
                    ->route('event.index')
                    ->with('success', 'Evento criado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('event.create')
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Admin\Event $event
         * @return \Illuminate\Http\Response
         */
        public function show(Event $event)
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            return view('admin.event.show',
                compact('event'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Admin\Event $event
         * @return \Illuminate\Http\Response
         */
        public function edit(Event $event)
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route' => ['event.update', $event],
                'method' => Request::METHOD_PUT,
                'files' => true,
                'onsubmit' => 'return validateFormEvent(this)',
            ];


            if (auth()->user()->establishments()->count() > 0)
                $establishment_id = auth()->user()->establishments()->id;
            else
                $establishment_id = session()->get('establishment');

            $addresses = EstablishmentAddress::where('establishment_id', $establishment_id)->get();

            return view('admin.event.form',
                compact('formOptions',
                    'addresses',
                    'event'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\CreateOrUpdateEvent $request
         * @param \App\Models\Admin\Event $event
         * @return \Illuminate\Http\Response
         */
        public function update(CreateOrUpdateEvent $request, Event $event)
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            $data = $request->validated();

            DB::beginTransaction();

            try {
                if (array_key_exists('cover_path', $data)):
                    if (!Storage::delete($event->cover_path))
                        throw new \Exception('Não foi possível atualizar a foto do evento!');

                    if ($data['cover_path'] instanceof UploadedFile):
                        if (!($path = $data['cover_path']->storePublicly('event')))
                            throw new \Exception('Não foi possível armazenar a foto do evento!');

                        $data["cover_path"] = $path;
                    endif;
                endif;

                if (auth()->user()->establishments()->count() > 0)
                    $data["establishment_id"] = auth()->user()->establishments()->id;
                else
                    $data["establishment_id"] = session()->get('establishment');

                $event->fill($data);

                if ($event->isDirty())
                    if (!$event->save())
                        throw new \Exception('Não foi possível atualizar o evento');

                DB::commit();

                return redirect()
                    ->route('event.index')
                    ->with('success', 'Evento atualizado com sucesso');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('event.edit', compact('event'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }}

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Admin\Event $event
         * @return \Illuminate\Http\Response
         */
        public function destroy(Event $event)
        {
            if (!auth()->user()->can('manage-establishment') && !auth()->user()->can('establishment-manager'))
                return abort(401);

            DB::beginTransaction();

            try {
                $event->status = 0;

                if (!$event->save())
                    throw new \Exception('Não foi possível atualizar o evento');

                DB::commit();

                return redirect()
                    ->route('event.index')
                    ->with('success', 'Evento excluído com sucesso');
            }catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('event.index', compact('event'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }
    }
