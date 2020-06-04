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
        $this->middleware('role:admin|establishment');
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



//
//            "subject" => "teste"
//  "status" => "1"
//  "description" => "<p>teste daniel chamado urgente</p>"
//  "date_service" => "2020-06-02"

            //            {{--                    $table->unsignedInteger('establishment_id');--}}
//            {{--                    $table->unsignedInteger('user_id');--}}
//            {{--                    $table->string('subject');--}}
//            {{--                    $table->boolean('status')->default(1);--}}
//
//            {{--                    $table->text('description');--}}
//            {{--                    $table->string('situation');--}}
//            {{--                    $table->date('date_service')->nullable();--}}
//            {{--                    $table->time('time_service')->nullable();--}}
//            {{--                    $table->unsignedInteger('called_id');--}}
//            {{--                    $table->unsignedInteger('establishment_id');--}}
//            {{--                    $table->unsignedInteger('user_id');--}}

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function edit(Called $called)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Called $called)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Called  $called
     * @return \Illuminate\Http\Response
     */
    public function destroy(Called $called)
    {
        //
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
