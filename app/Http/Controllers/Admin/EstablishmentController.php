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

            $establishmentsDisabled = $request->query('d');

            $establishmentsSearch = $request->query('s');

            if (!empty(trim($establishmentsDisabled)) && !empty(trim($establishmentsSearch)))
                $establishments = $establishments->where([['status', 0],['corporate_name', 'like', "%{$establishmentsSearch}%"]])->paginate($this->paginate);
            else if (!empty(trim($establishmentsDisabled)))
                $establishments = $establishments->where('status', 0)->paginate($this->paginate);
            else if (!empty(trim($establishmentsSearch)))
                $establishments = $establishments->where([['status', 1],['corporate_name', 'like', "%{$establishmentsSearch}%"]])->paginate($this->paginate);
            else
                $establishments = $establishments->where('status', 1)->paginate($this->paginate);

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
                'route' => 'establishment.store',
                'method' => Request::METHOD_POST,
                'files' => false,
                'onsubmit' => 'return validateFormEstablishment(this)'
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

            DB::beginTransaction();

            try {
                $establishment = Establishment::create($data);

                if (!$establishment->exists)
                    throw new \Exception('Não foi possível criar o estabelecimento!');

                $created = $establishment->establishment_statistics()->create(['establishment_id' => $establishment->id]);

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
                'route' => ['establishment.update', $establishment],
                'method' => Request::METHOD_PUT,
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

            DB::beginTransaction();

            try {
                $establishment->status = 0;

                if (!$establishment->save())
                    throw new \Exception('Não foi possível atualizar o estabelecimento');

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
