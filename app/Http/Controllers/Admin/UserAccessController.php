<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\UserAccess;

class UserAccessController extends Controller
{
    protected $paginate = 20;

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
        if (! auth()->user()->can('access-admin'))
            return abort(401);

        $logsSearch = $request->query('s');

        if (!empty($logsSearch))
            $logs = UserAccess::where('name', 'like' , "%{$logsSearch}%")->paginate($this->paginate);
        else
            $logs = UserAccess::orderBy('id', 'DESC')->paginate($this->paginate);

        return view('admin.userAccess.index',
            compact('logs',
                'logsSearch'));
    }

    /**
     * Display the specified resource.
     *
     * @param  UserAccess  $userAccess
     * @return \Illuminate\Http\Response
     */
    public function show(UserAccess $log)
    {
        if (! auth()->user()->can('access-admin'))
            return abort(401);

        return view('admin.userAccess.show',
            compact('log'));
    }
}
