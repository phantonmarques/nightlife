<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Called;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCalled;
use Illuminate\Support\Facades\DB;

class CalledController extends Controller
{
    protected $paginate = 10;

    /**
     * CalledController constructor.
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

        $calledSearch = $request->query('s');

        if (!empty(auth()->user()->establishment_connect))
            $calledPrepare = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $calledPrepare = auth()->user()->establishments->id;

        # Log Access Users
        $this->access('Index Chamados');

        if (!empty($calledSearch))
            $called = Called::whereStatus(1)->whereLike(['title', 'situation', 'data_service', 'time_service'], $calledSearch)->paginate($this->paginate);
        elseif (auth()->user()->can('access-admin'))
            $called = Called::paginate($this->paginate);
        elseif (auth()->user()->can('manage-called'))
            $called = Called::whereStatus(1)->paginate($this->paginate);
        else
            $called = Called::where('establishment_id', $calledPrepare)->paginate($this->paginate);

        return view('admin.called.index',
            compact('called',
                'calledSearch'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('establishment-employee'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => 'called.store',
            'method'    => Request::METHOD_POST,
            'files'     => false,
            'onsubmit'  => 'return validateFormCalled(this)'
        ];

        $situations = [
          'waiting' => 'Aguardando Atendimento',
          'analyze' => 'Em análise',
          'development' => 'Em desenvolvimento',
          'closed' => 'Encerrado'
        ];

        $called = new Called();

        return view('admin.called.form',
            compact('called',
                'formOptions',
                    'situations'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateCalled $request)
    {
        if (!auth()->user()->can('establishment-employee'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Criar Chamado', $data);

        DB::beginTransaction();

        try {
            if (auth()->user()->establishments()->count() > 0)
                $data["establishment_id"] = auth()->user()->establishments->id;
            else
                $data["establishment_id"] = auth()->user()->establishment_connect;

            $data['user_id'] = auth()->user()->id;
            $data['situation'] = 'waiting';

            $called = Called::create($data);

            if (!$called->exists)
                throw new \Exception('Não foi possível criar o chamado!');

            $created = $called->called_interaction()->create($data);

            if (!$created)
                throw new \Exception('Não foi possível criar o chamado!');

            DB::commit();

            return redirect()
                ->route('called.index')
                ->with('success', 'Chamado criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('called.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function show(Called $called)
    {
        $situations = [
            'waiting'       => 'Aguardando Atendimento',
            'analyze'       => 'Em análise',
            'development'   => 'Em desenvolvimento',
            'closed'        => 'Encerrado'
        ];

        return view('admin.called.show',
            compact('called',
                'situations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function edit(Called $called)
    {
        if (!auth()->user()->can('establishment-employee') && !auth()->user()->can('manage-called'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route'     => ['called.update', $called],
            'method'    => Request::METHOD_PUT,
            'files'     => false,
            'onsubmit'  => 'return validateFormCalled(this)',
        ];

        $situations = [
            'waiting'       => 'Aguardando Atendimento',
            'analyze'       => 'Em análise',
            'development'   => 'Em desenvolvimento',
            'closed'        => 'Encerrado'
        ];

        return view('admin.called.form',
            compact('called',
                'formOptions',
                'situations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateCalled $request, Called $called)
    {
        if (!auth()->user()->can('establishment-employee') && !auth()->user()->can('manage-called'))
            return abort(401);

        $data = $request->validated();

        # Log Access Users
        $this->access('Criar Interação Chamado [' . $called->id . ']', $data);

        DB::beginTransaction();

        try {
            $data['establishment_id'] = $called->establishment_id;
            $data['user_id'] = auth()->user()->id;

            if (!isset($data['situation']))
                $data['situation'] = $called->called_interaction()->orderBy('id', 'DESC')->first()->situation;

            $created = $called->called_interaction()->create($data);

            if (!$created)
                throw new \Exception('Não foi possível interagir no chamado!');

            if ($data['situation'] === 'closed'):
                $called->status = false;

                if (!$called->save())
                    throw new \Exception('Não foi possível encerrar o chamado!');

            endif;

            DB::commit();

            return redirect()
                ->route('called.index')
                ->with('success', 'Interação realizada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('called.edit', compact('called'))
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
