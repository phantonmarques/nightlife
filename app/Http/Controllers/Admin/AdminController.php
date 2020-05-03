<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\City;
use App\Models\Site\State;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateProfilePicture;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    /**
     * AdminController constructor.
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
    public function index()
    {
        return view('admin.home.index');
    }

    /**
     * Display view dashboard establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function dashboard()
    {
        return view('admin.establishmentSettings.dashboard');
    }

    /**
     * Display reset password user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function changeProfilePicture()
    {
        return view('admin.settings.picture');
    }

    /**
     * Display reset password user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function editPassword()
    {
        return view('admin.settings.password-reset');
    }

    /**
     * Function connect user in establishment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function establishmentConnect(Request $request)
    {
        if (! auth()->user()->can('manage-called'))
            return abort(401);

        $user = auth()->user();
        $user->establishment_connect = intval($request->establishment_connect);

        if (!$user->save())
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar o estabelecimento conectado!');

        if (intval($request->establishment_connect) === 0)
            return redirect()
                ->route('admin.page')
                ->withInput()
                ->with('success', 'Desconectado do estabelecimento com sucesso!');

        return redirect()
            ->back()
            ->withInput()
            ->with('success', 'Conectado ao estabelecimento com sucesso!');
    }

    /**
     * Function reset password user
     * @param UpdatePassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(UpdatePassword $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->password = bcrypt($data["password"]);

            if (!$user->update())
                throw new \Exception('Ocorreu um erro ao alterar a senha!');

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Senha atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('errors', $e->getMessage());
        }
    }

    /**
     * Function Search citys of certain state
     * @param $stateSelect
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCitys($stateSelect)
    {
        if (! auth()->user()->can('manage-users') && ! auth()->user()->can('manage-called'))
            return abort(401);

        return response()->json(City::where('state_id', $stateSelect)->select( 'id', 'name', 'name_visible')->get());
    }

    /**
     * Function Search state selected
     * @param $state
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchState($state)
    {
        if (! auth()->user()->can('manage-users') && ! auth()->user()->can('manage-called'))
            return abort(401);

        return response()->json(State::where('state_cod', $state)->select('id')->first());
    }


    public function updateProfilePicture(UpdateProfilePicture $request){
        $data = $request->validated();

        DB::beginTransaction();

        try {
            if (!empty(auth()->user()->profile_picture_path))
                if (!Storage::delete(auth()->user()->profile_picture_path))
                    throw new \Exception('Não foi possível atualizar a foto do perfil!');

            if ($data['profile_picture_path'] instanceof UploadedFile):
                if (!($path = $data['profile_picture_path']->storePublicly('settings')))
                    throw new \Exception('Não foi possível armazenar a foto do perfil!');

                $data["profile_picture_path"] = $path;
            endif;

            $user = auth()->user();
            $user->profile_picture_path = $data["profile_picture_path"];

            if (!$user->update())
                throw new \Exception('Ocorreu um erro ao atualizar a foto do perfil!');

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Foto do perfil atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('errors', $e->getMessage());
        }
    }

    /**
     * Function valid password recent
     * @param $password
     * @return json
     */
    public function validPasswordRecent($password){
        if (Hash::check($password, auth()->user()->password))
            return response()->json(['status' => true]);
        else
            return response()->json(['status' => false]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
