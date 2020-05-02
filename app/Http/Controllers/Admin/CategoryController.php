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
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        # Log Access Users
        $this->access('Index Categoria');

        $categorySearch = $request->query('s');

        if (!empty($categorySearch))
            $categorys = Category::where('name', 'like' , "%{$categorySearch}%")->paginate($this->paginate);
        else
            $categorys = Category::paginate($this->paginate);

        return view('admin.category.index',
            compact('categorys',
                'categorySearch'));
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
            'route'     => 'category.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormCategory(this)'
        ];

        $category = new Category();

        return view('admin.category.form',
            compact('category',
                'formOptions'));
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

        # Log Access Users
        $this->access('Criar Categoria', $data);

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

            $created = $category->category_statistics()->create(['category_id' => $category->id]);

            if (!$created)
                throw new \Exception('Ocorreu algum erro desconhecido ao criar a categoria!');

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

        return view('admin.category.show',
            compact('category'));
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

        /** Create form options */
        $formOptions = [
            'route'     => ['category.update', $category],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormCategory(this)',
        ];

        return view('admin.category.form',
            compact('category',
                'formOptions'));
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

        # Log Access Users
        $this->access('Atualização Categoria', $data);

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

        # Log Access Users
        $this->access('Exclusão Categoria', $category);

        DB::beginTransaction();

        try {
            if(!$category->category_statistics()->delete())
                throw new \Exception('Ocorreu um erro desconhecido ao excluir a categoria, tente novamente.');

            if ($category->delete()) :
                DB::commit();

                return redirect()
                    ->route('category.index')
                    ->with('success', 'Categoria excluída com sucesso');
            else:
                throw new \Exception('Não foi possível excluir a categoria!');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('category.index', compact('category'))
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
