<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Requests\CreateOrUpdateEstablishment;
    use App\Models\Admin\Category;
    use App\Models\Admin\Establishment;
    use App\Models\Admin\Rhythm;
    use App\Models\Site\User;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;

    class EstablishmentController extends Controller
    {
        protected $paginate = 10;

        /**
         * EstablishmentController constructor.
         */
        public function __construct()
        {
            #ONLY AUTH
            $this->middleware('auth');
            #ONLY WITH ROLE ACTIVE [ADMIN]
            $this->middleware('role:admin');
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request, Establishment $establishments)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            # Log Access Users
            $this->access('Index Estabelecimentos');

            $establishmentsDisabled = $request->query('d');

            $establishmentsSearch = $request->query('s');

            if (!empty(trim($establishmentsDisabled)) && !empty(trim($establishmentsSearch)))
                $establishments = $establishments->whereStatus(0)->whereLike(['corporate_name', 'state_registration', 'type_license', 'created_at', 'updated_at'], $establishmentsSearch)
                    ->orWhereHas('users', function ($q) use ($establishmentsSearch) {
                        $q->where('cpf_cnpj', 'LIKE', "%{$establishmentsSearch}%")->orWhere('email', 'LIKE', "%{$establishmentsSearch}%");})
                    ->orWhereHas('category', function ($q) use ($establishmentsSearch) {
                        $q->where('name', 'LIKE', "%{$establishmentsSearch}%");})
                    ->orWhereHas('rhythm', function ($q) use ($establishmentsSearch) {
                        $q->where('name', 'LIKE', "%{$establishmentsSearch}%");})
                    ->paginate($this->paginate);
            else if (!empty(trim($establishmentsDisabled)))
                $establishments = $establishments->whereStatus(0)->paginate($this->paginate);
            else if (!empty(trim($establishmentsSearch)))
                $establishments = $establishments->whereStatus(1)->whereLike(['corporate_name', 'state_registration', 'type_license', 'created_at', 'updated_at'], $establishmentsSearch)
                    ->orWhereHas('users', function ($q) use ($establishmentsSearch) {
                        $q->where('cpf_cnpj', 'LIKE', "%{$establishmentsSearch}%")->orWhere('email', 'LIKE', "%{$establishmentsSearch}%");})
                    ->orWhereHas('establishments_category', function ($q) use ($establishmentsSearch) {
                        $q->where('name', 'LIKE', "%{$establishmentsSearch}%");})
                    ->orWhereHas('establishments_rhythm', function ($q) use ($establishmentsSearch) {
                        $q->where('name', 'LIKE', "%{$establishmentsSearch}%");})
                    ->paginate($this->paginate);
            else
                $establishments = $establishments->whereStatus(1)->paginate($this->paginate);

            return view('admin.establishment.index',
                compact('establishments',
                    'establishmentsSearch'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create(Request $request)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => 'establishment.store',
                'method'    => Request::METHOD_POST,
                'files'     => false,
                'onsubmit'  => 'return validateFormEstablishment(this)'
            ];

            $categorys = Category::get()->pluck('name', 'id');

            $users = User::where('type_user', 'e')->whereNotIn('id', function ($q) {
                $q->select('user_id')->from('establishment');
            })->get();

            $rhythms = Rhythm::get()->pluck('name', 'id');

            $establishment = new Establishment();

            return view('admin.establishment.form',
                compact('users',
                    'categorys',
                    'rhythms',
                    'establishment',
                    'formOptions'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request  CreateOrUpdateEstablishment
         * @return \Illuminate\Http\Response
         */
        public function store(CreateOrUpdateEstablishment $request)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Criar Estabelecimento', $data);

            DB::beginTransaction();

            try {
                $establishment = Establishment::create($data);

                if (!$establishment->exists)
                    throw new \Exception('Não foi possível criar o estabelecimento!');

                $created = $establishment->establishment_statistics()->create();

                if (!$created)
                    throw new \Exception('Não foi possível criar a estatistica do estabelecimento!');

                $establishment->establishments_category()->attach($data["category"]);

                foreach ($data["rhythm"] as $rhythm):
                    $establishment->establishments_rhythm()->attach($rhythm);
                endforeach;

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
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            return view('admin.establishment.show',
                compact('establishment'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */
        public function edit(Establishment $establishment)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => ['establishment.update', $establishment],
                'method'    => Request::METHOD_PUT,
                'files'     => false,
                'onsubmit'  => 'return validateFormEstablishment(this)'
            ];

            $categorys = Category::get()->pluck('name', 'id');

            $users = User::where('type_user', 'e')->whereNotIn('id', function ($q) {
                $q->select('user_id')->from('establishment');
            })->get();

            $rhythms = Rhythm::get()->pluck('name', 'id');

            return view('admin.establishment.form',
                compact('users',
                'categorys',
                'rhythms',
                'establishment',
                'formOptions'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Request\CreateOrUpdateEstablishment $request
         * @param \App\Models\Admin\Establishment $establishment
         * @return \Illuminate\Http\Response
         */

        public function update(CreateOrUpdateEstablishment $request, Establishment $establishment)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Atualização Estabelecimento', $data);

            DB::beginTransaction();

            try {
                $establishment->fill($data);

                if ($establishment->isDirty()):
                    if (!$establishment->save()):
                        throw new \Exception('Não foi possível atualizar o estabelecimento');
                    endif;
                endif;

                if (isset($data["category"]))
                    $establishment->establishments_category()->sync($data["category"]);
                else
                    $establishment->establishments_category()->detach();

                if (isset($data["rhythm"]))
                    $establishment->establishments_rhythm()->sync($data["rhythm"]);
                else
                    $establishment->establishments_rhythm()->detach();

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
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            # Log Access Users
            $this->access('Exclusão Estabelecimento', $establishment);

            DB::beginTransaction();

            try {
                $establishment->status = 0;

                if (!$establishment->save())
                    throw new \Exception('Não foi possível desativar o estabelecimento');

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

        /**
         * Delete all selected Establishment at once.
         *
         * @param Request $request
         * @return string
         */
        public function massDestroy(Request $request)
        {
            if (! auth()->user()->can('manage-establishment'))
                return abort(401);

            $establishments = Establishment::whereIn('id', request('ids'))->get();

            foreach ($establishments as $establishment):
                $establishment->status = 0; 

                if (!$establishment->save())
                    return response()->json([
                        'status' => false,
                        'message' => 'Erro ao desativar a(s) estabelecimento(s)!'
                    ]);

            endforeach;        
            
            return response()->json([
                'status' => true,
                'message' => 'Estabelecimento(s) desativado(s) com sucesso!'
            ]);
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
