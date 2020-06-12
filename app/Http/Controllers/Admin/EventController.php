<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Requests\CreateOrUpdateEvent;
    use App\Models\Admin\Establishment;
    use App\Models\Admin\EstablishmentAddress;
    use App\Models\Admin\Event;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
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
            #ONLY AUTH
            $this->middleware('auth');
            #ONLY WITH ROLE ACTIVE [ADMIN]
            $this->middleware('role:admin|establishment|establishment-employee');
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            $eventSearch = $request->query('s');

            if (!empty(auth()->user()->establishment_connect))
                $eventPrepare = auth()->user()->establishment_connect;
            elseif (auth()->user()->establishments()->count() > 0)
                $eventPrepare = auth()->user()->establishments->id;

            if (empty($eventPrepare) && auth()->user()->can('manage-called'))
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

            # Log Access Users
            $this->access('Index Evento');

            if (!empty($eventSearch))
                $events = Event::whereStatus(1)->where('name', 'like', "%{$eventSearch}%")->paginate($this->paginate);
            else
                $events = Event::whereStatus(1)->where('establishment_id', $eventPrepare)->paginate($this->paginate);

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
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => 'event.store',
                'method'    => Request::METHOD_POST,
                'files'     => true,
                'onsubmit'  => 'return validateFormEvent(this)'
            ];

            if (auth()->user()->establishments()->count() > 0):
                $establishment_id = auth()->user()->establishments->id;

                $verifyPlanLimited = Event::whereStatus(1)->where('establishment_id', $establishment_id)->count();

                if ($verifyPlanLimited > 2 && auth()->user()->establishments->type_license === 'b'):
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'Limite de criação de eventos excedido, mude o plano ou aguarde finalizar os eventos agendados atualmente!');
                endif;

            else:
                $establishment_id = auth()->user()->establishment_connect;
            endif;

            if (empty($establishment_id) && auth()->user()->can('manage-called'))
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

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
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Criar Evento', $data);

            DB::beginTransaction();

            try {
                if (array_key_exists('cover_path', $data)):
                    if (!($path = $data['cover_path']->store('event', 'public')))
                        throw new \Exception('Não foi possível armazenar a foto do evento!');

                    $data["cover_path"] = $path;
                endif;

                if (auth()->user()->establishments()->count() > 0)
                    $data["establishment_id"] = auth()->user()->establishments->id;
                else
                    $data["establishment_id"] = auth()->user()->establishment_connect;

                if (empty($data["establishment_id"]) && auth()->user()->can('manage-called'))
                    throw new \Exception('Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

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
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
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
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => ['event.update', $event],
                'method'    => Request::METHOD_PUT,
                'files'     => true,
                'onsubmit'  => 'return validateFormEvent(this)',
            ];

            if (auth()->user()->establishments()->count() > 0)
                $establishment_id = auth()->user()->establishments->id;
            else
                $establishment_id = auth()->user()->establishment_connect;

            if (empty($establishment_id) && auth()->user()->can('manage-called'))
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');
            elseif ($event->establishment_id !== $establishment_id)
                return abort(401);

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
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Atualizar Evento', $data);

            DB::beginTransaction();

            try {
                if (array_key_exists('cover_path', $data)):
                    if (!Storage::delete($event->cover_path))
                        throw new \Exception('Não foi possível atualizar a foto do evento!');

                    if (!($path = $data['cover_path']->store('event', 'public')))
                        throw new \Exception('Não foi possível armazenar a foto do evento!');

                    $data["cover_path"] = $path;
                endif;

                if (auth()->user()->establishments()->count() > 0)
                    $data["establishment_id"] = auth()->user()->establishments->id;
                else
                    $data["establishment_id"] = auth()->user()->establishment_connect;

                if (empty($data["establishment_id"]) && auth()->user()->can('manage-called'))
                    throw new \Exception('Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

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
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Admin\Event $event
         * @return \Illuminate\Http\Response
         */
        public function destroy(Event $event)
        {
            if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-employee'))
                return abort(401);

            # Log Access Users
            $this->access('Exclusão Evento', $event);

            DB::beginTransaction();

            try {
                $event->status = 0;

                if (!Storage::delete($event->cover_path))
                    throw new \Exception('Não foi possível excluir a foto do evento!');

                if (!$event->save())
                    throw new \Exception('Não foi possível excluir o evento');

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

        /**
         * Create Access Log User
         */
        private function access($description, $content = NULL, $class = __CLASS__)
        {
            auth()->user()->user_access()->create([
                'class' => $class,
                'establishment_connect' => !empty(auth()->user()->establishment_connect) ? auth()->user()->establishment_connect : NULL,
                'description' => $description,
                'content' => $content,
                'data_access' => date('YmdHis')
            ]);
        }
    }
