<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\City;
use App\Models\Site\State;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateProfilePicture;
use App\Http\Requests\UpdateEstablishmentSettings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

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

    /**
     * Display view dashboard establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function dashboard()
    {
        #Total de visualização dos ritmos musicais
        $rhythmtotal = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 300, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A', '#DAA520'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A', '#DAA520'],
                'data' => ['1','2','3', '4', '5', '6'],
            ]
        ])
        ->options([]);

        #Visualização anual dos ritmos musicais
        $rhythmyearly = app()->chartjs
        ->name('rhythmyearly')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
                [
                    "label" => "Até o momento",
                    'backgroundColor' => "rgba(131,111,255, 0.8)",
                    'borderColor' => "rgba(131,111,255, 0.9)",
                    "pointBorderColor" => "rgba(131,111,255, 0.9)",
                    "pointBackgroundColor" => "rgba(131,111,255, 0.9)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55],
                ],
            ])
        ->options([]);

        #Visualização do mês dos ritmos musicais
        $rhythmmonth = app()->chartjs
        ->name('rhythmmonth')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'data' => [65, 59, 80, 81, 56, 55],
            ],

        ])
        ->options([]);

        #Visualização da semana dos ritmos musicais
        $rhythmweek = app()->chartjs
        ->name('rhythmweek')
        ->type('doughnut')
        ->size(['width' => 300, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'data' => [65, 59, 80, 81, 56, 55],
            ],

        ])
        ->options([]);

        #Visualizações total do estabelecimento
        $establishmenttotal = app()->chartjs
        ->name('EstabTotal')
        ->type('pie')
        ->size(['width' => 200, 'height' => 150])
        ->labels(['Semana', 'Mês', 'Ano', 'Total'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB', '#4682B4', '#2E8B57'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#2E8B57'],
                'data' => ['40', '100', '200', '500'],
            ]
        ])
        ->options([]);


        #Visualizações total do estabelecimento
        $establishmentstotal = app()->chartjs
            ->name('establishmentstotal')
            ->type('doughnut')
            ->size(['width' => 200, 'height' => 150])
            ->labels(['Semana', 'Mês', 'Ano', 'Total'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#4682B4', '#2E8B57'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#2E8B57'],
                    'data' => ['40', '100', '200', '500'],
                ]
            ])
            ->options([]);

        #Total de visualização das categorias
        $categorytotal = app()->chartjs
        ->name('categorytotal')
        ->type('pie')
        ->size(['width' => 300, 'height' => 200])
        ->labels(['Bar', 'Balada', ' Tabacaria', ' Pub', 'Karaokê'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A'],
                'data' => ['1','2','3', '4', '5'],
            ]
        ])
        ->options([]);

        #Visualização anual das categorias
        $categoryyearly = app()->chartjs
        ->name('categoryyearly')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Bar', 'Balada', ' Tabacaria', ' Pub', 'Karaokê'])
        ->datasets([
                [
                    "label" => "Até o momento",
                    'backgroundColor' => "rgba(131,111,255, 0.8)",
                    'borderColor' => "rgba(131,111,255, 0.9)",
                    "pointBorderColor" => "rgba(131,111,255, 0.9)",
                    "pointBackgroundColor" => "rgba(131,111,255, 0.9)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56],
                ],
            ])
        ->options([]);

        #Visualização do mês das categorias
        $categorymonth = app()->chartjs
        ->name('categorymonth')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Bar', 'Balada', ' Tabacaria', ' Pub', 'Karaokê'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347'],
                'data' => [65, 59, 80, 81, 56],
            ],

        ])
        ->options([]);

        #Visualização da semana das categorias
        $categoryweek = app()->chartjs
        ->name('categoryweek')
        ->type('doughnut')
        ->size(['width' => 300, 'height' => 200])
        ->labels(['Bar', 'Balada', ' Tabacaria', ' Pub', 'Karaokê'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347'],
                'data' => [65, 59, 80, 81, 56],
            ],

        ])
        ->options([]);

        #Total de visualização dos ritmos musicais de determinada cidade
        $rhythmtotalcustom = app()->chartjs
        ->name('rhythmtotalcustom')
        ->type('pie')
        ->size(['width' => 300, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A', '#DAA520'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '	#4682B4', '#008B8B', '#A52A2A', '#DAA520'],
                'data' => ['1','2','3', '4', '5', '6'],
            ]
        ])
        ->options([]);

        #Visualização anual dos ritmos musicais de determinada cidade
        $rhythmyearlycustom = app()->chartjs
        ->name('rhythmyearlycustom')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
                [
                    "label" => "Até o momento",
                    'backgroundColor' => "rgba(131,111,255, 0.8)",
                    'borderColor' => "rgba(131,111,255, 0.9)",
                    "pointBorderColor" => "rgba(131,111,255, 0.9)",
                    "pointBackgroundColor" => "rgba(131,111,255, 0.9)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55],
                ],
            ])
        ->options([]);

        #Visualização do mês dos ritmos musicais de determinada cidade
        $rhythmmonthcustom = app()->chartjs
        ->name('rhythmmonthcustom')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'data' => [65, 59, 80, 81, 56, 55],
            ],

        ])
        ->options([]);

        #Visualização da semana dos ritmos musicais de determinada cidade
        $rhythmweekcustom = app()->chartjs
        ->name('rhythmweekcustom')
        ->type('doughnut')
        ->size(['width' => 300, 'height' => 200])
        ->labels([' Rock', ' Pop', ' Sertanejo', ' Funk', ' Pagode', 'Rap'])
        ->datasets([
            [
                "label" => "Maio",
                'backgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'hoverBackgroundColor' => ['#6495ED', '#A52A2A', '#2E8B57', '#A0522D', '#FF6347', '#BC8F8F'],
                'data' => [65, 59, 80, 81, 56, 55],
            ],

        ])
        ->options([]);

        return view('admin.establishmentSettings.dashboard',
            compact('rhythmtotal',
                'rhythmmonth',
                'rhythmyearly',
                'rhythmweek',
                'establishmenttotal',
                'categorytotal',
                'categorymonth',
                'categoryyearly',
                'categoryweek',
                'rhythmweekcustom',
                'rhythmmonthcustom',
                'rhythmtotalcustom',
                'rhythmyearlycustom',
                'establishmentstotal'
            )
        );
    }

    /**
     * Display view details account establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function details()
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        return view('admin.establishmentSettings.details', compact('establishment'));
    }

    /**
     * Display pictures establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function changePictures()
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        return view('admin.establishmentSettings.pictures', compact('establishment'));
    }

    /**
     * Display pictures profile
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
     * Display reports establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function reports()
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        return view('admin.establishmentSettings.reports', compact('establishment'));
    }

    /**
     * Function reset password user
     * @param UpdatePassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(UpdatePassword $request)
    {
        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização senha Usuário', $data);

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
     * Remove Pictures DropzoneJS - Establishments Photos
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function removePicture()
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        $path = request('path');

        # Log Access Users
        $this->access('Excluir Fotos Estabelecimentos', $path);

        DB::beginTransaction();

        try {
            foreach ($establishment->establishments_photos()->get() as $photo):
                if ($photo->img_path === $path):
                    if (!Storage::delete("public/" . $photo->img_path))
                        throw new \Exception('Não foi possível atualizar as fotos do estabelecimento!');

                    if (!$photo->delete())
                        throw new \Exception('Não foi possível atualizar as fotos do estabelecimento!');

                endif;
            endforeach;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Foto do estabelecimento excluída com sucesso!',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
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

    /**
     * Display settings establishment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function settings()
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        return view('admin.establishmentSettings.settings', compact('establishment'));
    }

    /**
     * Function store and Update Pictures Establishment
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updatePictures(Request $request)
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        $establishment = Establishment::find($id);

        if ($request->hasFile('file')):

            DB::beginTransaction();

            try {
                if ($establishment->establishments_photos()->max('created_at') > date('Y-m-d H:i:s', strtotime('-5 minutes'))):
                    foreach ($establishment->establishments_photos()->get() as $photo):
                        if (!Storage::delete("public/" . $photo->img_path))
                            throw new \Exception('Não foi possível atualizar as fotos do estabelecimento!');

                        if (!$photo->delete())
                            throw new \Exception('Não foi possível atualizar as fotos do estabelecimento!');

                    endforeach;

                endif;

                $quantityPictures = $establishment->establishments_photos()->count();

                if ($quantityPictures === 10)
                    throw new \Exception('Não foi possível armazenar a foto do estabelecimento, máximo 10 fotos!');

                if (!($path = $request->file->store('establishment', 'public')))
                    throw new \Exception('Não foi possível armazenar a foto do estabelecimento!');

                if (!$establishment->establishments_photos()->create(['img_path' => $path, 'sequence' => ($quantityPictures+1)]))
                    throw new \Exception('Ocorreu um erro ao inserir a foto do estabelecimento!');

                # Log Access Users
                $this->access('Criar Fotos Estabelecimentos', $path);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Foto do estabelecimento inserida com sucesso!',
                    'path' => $path,
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

        endif;

        return response()->json([
            'success' => false,
            'message' => 'Erro desconhecido!'
        ], 400);
    }

    /**
     * Store and update picture profile painel admin
     * @param UpdateProfilePicture $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfilePicture(UpdateProfilePicture $request)
    {
        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização Foto Perfil', $data);

        DB::beginTransaction();

        try {
            if (!empty(auth()->user()->profile_picture_path))
                if (!Storage::delete("public/" . auth()->user()->profile_picture_path))
                    throw new \Exception('Não foi possível atualizar a foto do perfil!');

            if (!($path = $data['profile_picture_path']->store('settings', 'public')))
                throw new \Exception('Não foi possível armazenar a foto do perfil!');

            $user = auth()->user();
            $user->profile_picture_path = $path;

            if (!$user->update())
                throw new \Exception('Ocorreu um erro ao atualizar a foto do perfil!');

            $picture = Image::make(public_path('storage/' . $user->profile_picture_path));

            if (!$picture->resize(720, 720)->encode('png', 100)->save())
                throw new \Exception('Ocorreu um erro ao atualizar a foto do perfil!');

            DB::commit();

            return redirect()
                ->route('settings.changePicture')
                ->with('success', 'Foto do perfil atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('settings.changePicture')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Function update details establishment
     * @param UpdateEstablishmentSettings $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(UpdateEstablishmentSettings $request)
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments()->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');


        $data = $request->validated();

        # Log Access Users
        $this->access('Atualização Detalhes Estabelecimento', $data);

        DB::beginTransaction();

        try {
            $establishment = Establishment::find($id);

            $establishment->details = $data['description'];

            if (!$establishment->update())
                throw new \Exception('Ocorreu um erro ao atualizar os detalhes do estabelecimento!');

            DB::commit();

            return redirect()
                ->route('admin.settings')
                ->with('success', 'Detalhes do estabelecimento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.settings')
                ->withInput()
                ->with('error', $e->getMessage());
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
}
