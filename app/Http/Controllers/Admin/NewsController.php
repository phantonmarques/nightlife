<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use App\Http\Requests\CreateOrUpdateNews;

class NewsController extends Controller
{
    protected $paginate = 10;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        #ONLY AUTH
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        # Log Access Users
        $this->access('Index News');

        $newsSearch = $request->query('s');

        if (!empty($newsSearch))
            $news = News::whereLike(['title', 'important', 'created_at', 'updated_at'], $newsSearch)->paginate($this->paginate);
        else
            $news = News::paginate($this->paginate);

        return view('admin.news.index', compact('news', 'newsSearch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => 'news.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormNews(this)'
        ];

        $news = new News();

        return view('admin.news.form', compact('formOptions','news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateNews $request)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Criar News', $data);

        DB::beginTransaction();

        try {
            $news = News::where('title', $data["title"])->count();

            if ($news > 0)
                return redirect()
                    ->route('news.create')
                    ->withInput()
                    ->with('error', 'Notícia já cadastrada, favor informe outro nome!');

            $data["user_id"] = auth()->user()->id;

            $news = News::create($data);

            if (!$news->exists)
                throw new \Exception('Não foi possível criar a função!');

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Notícia criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('news.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => ['news.update', $news],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormNews(this)',
        ];

        return view('admin.news.form', compact('formOptions','news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateNews $request, News $news)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização News', $data);

        DB::beginTransaction();

        try {
            if (!isset($data["important"]))
                $data["important"] = 0;

            $news->fill($data);

            if ($news->isDirty())
                if (!$news->save())
                    throw new \Exception('Não foi possível atualizar a notícia');

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Notícia atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('news.edit', compact('news'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        # Log Access Users
        $this->access('Exclusão Notícia', $news);

        DB::beginTransaction();

        try {
            if (!$news->delete())
                throw new \Exception('Não foi possível excluir a notícia');

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Notícia excluída com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('news.index', compact('news'))
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
