<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Called;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Prophecy\Call\Call;

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
        $this->middleware(['role:admin'], ['role:establishment']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('manage-called') && !auth()->user()->can('establishment-manager'))
            return abort(401);

        $calledSearch = $request->query('s');

        if (!empty(auth()->user()->establishment_connect))
            $calledPrepare = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $calledPrepare = auth()->user()->establishments()->id;

        if (empty($calledPrepare) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        # Log Access Users
        $this->access('Index Chamados');

        if (!empty($calledSearch))
            $called = Called::whereStatus(1)->whereLike(['title', 'situation', 'data_service', 'time_service'], $calledSearch)->paginate($this->paginate);
        elseif (auth()->user()->can('access-admin'))
            $called = Called::paginate($this->paginate);
        elseif (auth()->user()->can('manage-called'))
            $called = Called::whereStatus(1)->paginate($this->paginate);
        else
            $called = Called::whereStatus(1)->where('establishment_request', $calledPrepare)->paginate($this->paginate);

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
