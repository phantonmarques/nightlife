<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateOrUpdateCategory;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    protected $paginate = 10;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        #SOMENTE AUTENTICADOS
        $this->middleware('auth');
        #SOMENTE COM A FUNÇÃO ATIVA [ADMIN]
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        $categorySearch = $request->query('s');

        if (!empty($categorySearch))
            $categorys = Category::where('name', 'like' , "%{$categorySearch}%")->paginate($this->paginate);
        else
            $categorys = Category::paginate($this->paginate);

        return view('admin.category.index',
            compact('categorys',
                'categorySearch',
                'userActive'));
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

        $userActive = auth()->user()->name;

        /** Create form options */
        $formOptions = [
            'route' => 'category.store',
            'method' => Request::METHOD_POST,
            'files' => false,
            'onsubmit' => 'return validateFormCategory(this)'
        ];

        $category = new Category();

        return view('admin.category.form',
            compact('category',
                'formOptions',
                'userActive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateCategory  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateCategory $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $categoryExists = Category::where('name', $data["name"])->count();

            if ($categoryExists > 0)
                return redirect()
                    ->route('category.create')
                    ->withInput()
                    ->with('error', 'Categoria já cadastrada, favor informe outro nome!');

            $category = Category::create($data);

            if (!$category->exists)
                throw new \Exception('Não foi possível criar a categoria!');

            DB::commit();

            return redirect()
                ->route('category.index')
                ->with('success', 'Categoria criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('category.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        return view('admin.category.show',
            compact('category',
                'userActive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        /** Create form options */
        $formOptions = [
            'route' => ['category.update', $category],
            'method' => Request::METHOD_PUT,
            'onsubmit' => 'return validateFormCategory(this)',
        ];

        return view('admin.category.form',
            compact('category',
                'formOptions',
                'userActive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateCategory  $request
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateCategory $request, Category $category)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $category->fill($data);

            if ($category->isDirty())
                if (!$category->save())
                    throw new \Exception('Não foi possível atualizar a categoria');

            DB::commit();

            return redirect()
                ->route('category.index')
                ->with('success', 'Categoria atualizada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('category.edit', compact('category'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        DB::beginTransaction();

        try {
            if ($category->delete()) :
                DB::commit();

                return redirect()
                    ->route('category.index')
                    ->with('success', 'Categoria excluída com sucesso');
            else:
                DB::rollBack();

                return redirect()
                    ->route('category.index', compact('category'))
                    ->withInput()
                    ->with('error', 'Ocorreu um erro desconhecido ao excluir a categoria, tente novamente.');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('category.index', compact('category'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
