<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Requests\CreateOrUpdateEstablishment;
    use App\Models\Admin\Establishment;
    use App\Models\Site\User;
    use App\Models\Site\City;
    use App\Models\Site\State;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
//    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\DB;
//    use Illuminate\Http\UploadedFile;
//    use Illuminate\Pagination\Paginator;


    class EstablishmentController extends Controller
    {
        protected $paginate = 10;

        public function __construct()
        {
            #SOMENTE AUTENTICADOS
            $this->middleware('auth');
            #DEPOIS CRIAR FUNÇÃO PARA VALIDAR APENAS AUTENTICADOS DO SISTEMA COM PERMISSÃO DE ADMIN
        }


        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request, Establishment $establishments)
        {
            $userActive = auth()->user()->name;

            $establishmentsDisabled = $request->query('d');

            $establishmentsSearch = $request->query('s');

            if (!empty(trim($establishmentsDisabled)) && !empty(trim($establishmentsSearch)))
                $establishments = $establishments->with('users')->where('status', 0)->where('corporate_name', 'like', "%{$establishmentsSearch}%")->paginate($this->paginate);
            else if (!empty(trim($establishmentsDisabled)))
                $establishments = $establishments->with('users')->where('status', 0)->paginate($this->paginate);
            else if (!empty(trim($establishmentsSearch)))
                $establishments = $establishments->with('users')->where('status', 1)->where('corporate_name', 'like', "%{$establishmentsSearch}%")->paginate($this->paginate);
            else
                $establishments = $establishments->with('users')->where('status', 1)->paginate($this->paginate);

            return view('admin.establishment.index', compact('establishments', 'userActive', 'establishmentsSearch'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create(Request $request)
        {
            $userActive = auth()->user()->name;

            /** Create form options */
            $formOptions = [
                'route' => 'establishment.store',
                'method' => Request::METHOD_POST,
                'files' => false,
                'onsubmit' => 'return validateFormEstablishment(this)'
            ];

            $users = User::where('type_user', 'e')->whereNotIn('id', function ($q) {
                $q->select('user_id')->from('establishment');
            })->get();

            $establishment = new Establishment();

            return view('admin.establishment.form', compact('users', 'userActive', 'establishment', 'formOptions'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request  CreateOrUpdateEstablishment
         * @return \Illuminate\Http\Response
         */
        public function store(CreateOrUpdateEstablishment $request)
        {
            $data = $request->validated();

            DB::beginTransaction();

            try {
                $establishment = Establishment::create($data);

                if (!$establishment->exists) {
                    throw new \Exception('Não foi possível criar o estabelecimento!');
                }

                DB::commit();

                return redirect()
                    ->route('establishment.index')
                    ->with('success', 'Estabelecimento criado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('establishment.create')
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */
        public function show(Establishment $establishment)
        {
            $userActive = auth()->user()->name;

            /** @var  $userEstablishment - Relation Linked User */
            $userEstablishment = $establishment->users()->first();

            $typeUser = User::typeUsers($userEstablishment->type_user);

            /** @var  $cityUser - Relation Linked City User */
            $cityUser = City::find($userEstablishment->city_id, ['name_visible']);

            /** @var  $stateUser - Relation Linked State User */
            $stateUser = State::find($userEstablishment->state_id, ['name_visible']);

            return view('admin.establishment.show', compact(
                'establishment',
                'userEstablishment',
                'cityUser',
                'stateUser',
                'typeUser',
                'userActive'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */
        public function edit(Establishment $establishment)
        {
            $userActive = auth()->user()->name;

            /** Create form options */
            $formOptions = [
                'route' => ['establishment.update', $establishment],
                'method' => Request::METHOD_PUT,
            ];

            $userOld = User::select(['id', 'name', 'email', 'cpf_cnpj', 'login'])->where('id', $establishment->user_id)
                ->first();

            $users = User::where('type_user', 'e')->whereNotIn('id', function ($q) {
                $q->select('user_id')->from('establishment');
            })->get();

            return view('admin.establishment.form', compact('users', 'userOld', 'userActive', 'establishment', 'formOptions'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */

        public function update(CreateOrUpdateEstablishment $request, Establishment $establishment)
        {
            $data = $request->validated();

            DB::beginTransaction();

            try {
                $establishment->fill($data);

                if ($establishment->isDirty()) {
                    if (!$establishment->save()) {
                        throw new \Exception('Não foi possível atualizar o estabelecimento');
                    }
                }

                DB::commit();

                return redirect()
                    ->route('establishment.index')
                    ->with('success', 'Estabelecimento atualizado com sucesso');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('establishment.edit', compact('establishment'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */
        public function destroy(Establishment $establishment)
        {
            DB::beginTransaction();

            try {
                $establishment->status = 0;

                if (!$establishment->save())
                    throw new \Exception('Não foi possível atualizar o veículo');

                DB::commit();

                return redirect()
                    ->route('establishment.index')
                    ->with('success', 'Estabelecimento desativado com sucesso');
            }catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('establishment.index', compact('establishment'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }
    }
