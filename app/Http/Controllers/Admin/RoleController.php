<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateRole;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $roleSearch = $request->query('s');

        if (!empty($roleSearch))
            $roles = Role::with('permissions')->where('name', 'like' , "%{$roleSearch}%")->paginate($this->paginate);
        else
            $roles = Role::with('permissions')->paginate($this->paginate);

        return view('admin.role.index',
            compact('roles',
                'roleSearch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => 'role.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormRole(this)'
        ];

        $permissions = Permission::get()->pluck('name', 'id');

        $role = new Role();

        return view('admin.role.form',
            compact('formOptions',
                'permissions',
                'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrUpdateRole  $request
     * @return string
     */
    public function store(CreateOrUpdateRole $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $roleExists = Role::where('slug', $data["slug"])->orWhere('name', $data["name"])->count();

            if ($roleExists > 0)
                return redirect()
                    ->route('role.create')
                    ->withInput()
                    ->with('error', 'Função já cadastrada, favor informe outro nome!');

            $role = Role::create($data);

            if (!$role->exists)
                throw new \Exception('Não foi possível criar a função!');

            foreach ($data["permission"] as $permission):
                $role->permissions()->attach($permission);
            endforeach;

            DB::commit();

            return redirect()
                ->route('role.index')
                ->with('success', 'Função criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('role.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        return view('admin.role.show',
            compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return array
     */
    public function edit(Role $role)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => ['role.update', $role],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormRole(this)',
        ];

        $permissions = Permission::get()->pluck('name', 'id');

        return view('admin.role.form',
            compact('formOptions',
                'permissions',
                'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateOrUpdateRole  $request
     * @param  Role  $role
     * @return string
     */
    public function update(CreateOrUpdateRole $request, Role $role)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $role->fill($data);

            if ($role->isDirty())
                if (!$role->save())
                    throw new \Exception('Não foi possível atualizar a função');

            if (isset($data["permission"]))
                $role->permissions()->sync($data["permission"]);
            else
                $role->permissions()->detach();

            DB::commit();

            return redirect()
                ->route('role.index')
                ->with('success', 'Função atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('role.edit', compact('role'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return string
     */
    public function destroy(Role $role)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        DB::beginTransaction();

        try {
            $role->permissions()->detach();

            if ($role->delete()) :
                DB::commit();

                return redirect()
                    ->route('role.index')
                    ->with('success', 'Função excluída com sucesso');
            else:
                throw new \Exception('Não foi possível excluir a função');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('role.index', compact('role'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
