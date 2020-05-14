<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdatePermission;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $paginate = 10;

    /**
     * PermissionController constructor.
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

        # Log Access Users
        $this->access('Index Permissão');

        $permissionSearch = $request->query('s');

        if (!empty($permissionSearch))
            $permissions = Permission::whereLike(['name', 'slug', 'created_at', 'updated_at'], $permissionSearch)->paginate($this->paginate);
        else
            $permissions = Permission::paginate($this->paginate);

        return view('admin.permission.index',
            compact('permissions',
                'permissionSearch'));
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
            'route'     => 'permission.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormPermission(this)'
        ];

        $permission = new Permission();

        return view('admin.permission.form',
            compact('formOptions',
                'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdatePermission  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdatePermission $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Criar Permissão', $data);

        DB::beginTransaction();

        try {
            $permissionExists = Permission::where('slug', $data["slug"])->orWhere('name', $data["name"])->count();

            if ($permissionExists > 0)
                return redirect()
                    ->route('permission.create')
                    ->withInput()
                    ->with('error', 'Permissão já cadastrada, favor informe outro nome!');

            $permission = Permission::create($data);

            if (!$permission->exists)
                throw new \Exception('Não foi possível criar a permissão!');

            DB::commit();

            return redirect()
                ->route('permission.index')
                ->with('success', 'Permissão criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('permission.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        return view('admin.permission.show',
            compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => ['permission.update', $permission],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormPermission(this)'
        ];

        return view('admin.permission.form',
            compact('formOptions',
                'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdatePermission  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdatePermission $request, Permission $permission)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização Permissão', $data);

        DB::beginTransaction();

        try {
            $permission->fill($data);

            if ($permission->isDirty())
                if (!$permission->save())
                    throw new \Exception('Não foi possível atualizar a permissão');

            DB::commit();

            return redirect()
                ->route('permission.index')
                ->with('success', 'Permissão atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('permission.edit', compact('permission'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        # Log Access Users
        $this->access('Exclusão Permissão', $permission);

        DB::beginTransaction();

        try {
            if ($permission->delete()):
                DB::commit();

                return redirect()
                    ->route('permission.index')
                    ->with('success', 'Permissão excluído com sucesso');
            else:
                throw new \Exception('Não foi possível excluir a permissão');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('permission.index', compact('permission'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     * @return string
     */
    public function massDestroy(Request $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        Permission::whereIn('id', request('ids'))->delete();

        return response()->noContent();
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
