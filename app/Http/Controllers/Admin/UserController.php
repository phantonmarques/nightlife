<?php

    namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    use App\Http\Requests\CreateOrUpdateUser;
    use App\Models\Site\User;
    use App\Models\Site\State;
    use App\Models\Admin\Role;

    use Illuminate\Support\Facades\DB;

    class UserController extends Controller
    {
        protected $paginate = 10;

        /**
         * UserController constructor.
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
         * @param \Illuminate\Http\Response
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            if (!auth()->user()->can('manage-users'))
                return abort(401);

            # Log Access Users
            $this->access('Index Usuário');

            $userSearch = $request->query('s');

            if (!empty($userSearch)):
                $users = User::whereLike(['name', 'email', 'cpf_cnpj', 'created_at'], $userSearch)
                    ->orWhereHas('city', function ($q) use ($userSearch) {
                        $q->where('name_visible', 'LIKE', "%{$userSearch}%");})
                    ->orWhereHas('city.state', function ($q) use ($userSearch) {
                        $q->where('name_visible', 'LIKE', "%{$userSearch}%");})
                    ->orWhereHas('roles', function ($q) use ($userSearch) {
                        $q->where('slug', 'LIKE', "%{$userSearch}%");})
                    ->paginate($this->paginate);

            else:
                $users = User::paginate($this->paginate);
            endif;

            return view('admin.user.index',
                compact('users',
                    'userSearch'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (!auth()->user()->can('manage-users'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => 'user.store',
                'method'    => Request::METHOD_POST,
                'files'     => false,
                'onsubmit'  => 'return validateFormUser(this)'
            ];

            $states = State::get()->pluck('name_visible', 'id');

            $roles = Role::get()->pluck('name', 'id');

            $typeUsers = $this->typeUsers();

            $user = new User();

            return view('admin.user.form',
                compact('formOptions',
                    'roles',
                    'states',
                    'typeUsers',
                    'user'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\CreateOrUpdateUser $request
         * @return \Illuminate\Http\Response
         */
        public function store(CreateOrUpdateUser $request)
        {
            if (! auth()->user()->can('manage-users'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Criar Usuário', $data);

            DB::beginTransaction();

            try {
                $data["password"] = bcrypt($data["password"]);

                $user = User::create($data);

                if (!$user->exists)
                    throw new \Exception('Não foi possível criar o usuário!');

                if (isset($data["user_role"])):
                    $role = Role::where('id', $data["user_role"])->with('permissions')->first();

                    $user->roles()->attach($role);

                    foreach ($role->permissions()->pluck('id') as $permission):
                        $user->permissions()->attach($permission);
                    endforeach;
                endif;

                DB::commit();

                return redirect()
                    ->route('user.index')
                    ->with('success', 'Usuário criado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('user.create')
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Display the specified resource.
         *
         * @param User $user
         * @return \Illuminate\Http\Response
         */
        public function show(User $user)
        {
            if (! auth()->user()->can('manage-users'))
                return abort(401);

            return view('admin.user.show',
                compact('user'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param User $user
         * @return \Illuminate\Http\Response
         */
        public function edit(User $user)
        {
            if (! auth()->user()->can('manage-users'))
                return abort(401);

            /** Create form options */
            $formOptions = [
                'route'     => ['user.update', $user],
                'method'    => Request::METHOD_PUT,
                'files'     => false,
                'onsubmit'  => 'return validateFormUser(this)',
            ];

            $states = State::get()->pluck('name_visible', 'id');

            $roles = Role::get()->pluck('name', 'id');

            $typeUsers = $this->typeUsers();

            return view('admin.user.form',
                compact('formOptions',
                    'roles',
                    'states',
                    'typeUsers',
                    'user'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\CreateOrUpdateUser $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(CreateOrUpdateUser $request, User $user)
        {
            if (! auth()->user()->can('manage-users'))
                return abort(401);

            $data = $request->validated();

            # Log Access Users
            $this->access('Atualização Usuário', $data);

            DB::beginTransaction();

            try {
                if (isset($data["password"]))
                    $data["password"] = bcrypt($data["password"]);

                $user->fill($data);

                if ($user->isDirty())
                    if (!$user->save())
                        throw new \Exception('Não foi possível atualizar o usuário');

                if (isset($data["user_role"])):
                    $role = Role::where('id', $data["user_role"])->with('permissions')->first();

                    $user->roles()->sync($role);
                    $user->permissions()->sync($role->permissions()->pluck('id'));
                else:
                    $user->roles()->detach();
                    $user->permissions()->detach();
                endif;

                DB::commit();

                return redirect()
                    ->route('user.index')
                    ->with('success', 'Usuário atualizado com sucesso');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('user.edit', compact('user'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param User $user
         * @return \Illuminate\Http\Response
         */
        public function destroy(User $user)
        {
            if (! auth()->user()->can('manage-users'))
                return abort(401);

            # Log Access Users
            $this->access('Exclusão Usuário', $user);

            DB::beginTransaction();

            try {
                $user->roles()->detach();
                $user->permissions()->detach();

                if ($user->delete()) :
                    DB::commit();

                    return redirect()
                        ->route('user.index')
                        ->with('success', 'Usuário excluído com sucesso');
                else:
                    throw new \Exception('Não foi possível excluir o usuário');
                endif;
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()
                    ->route('user.index', compact('user'))
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        /**
         * Get type users
         *
         * @return array
         */
        private function typeUsers()
        {
            return array('a' => 'Administrador',
                'e' => 'Estabelecimento',
                'f' => 'Funcionário',
                'ef' => 'Funcionário Estabelecimento',
                'u' => 'Usuário Comum');
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
