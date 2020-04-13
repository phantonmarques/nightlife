<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateOrUpdateMusicalRhythm;
use App\Models\Admin\MusicalRhythm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MusicalRhythmController extends Controller
{
    protected $paginate = 10;

    /**
     * RoleController constructor.
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
     * @param Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        $musicalRhythmSearch = $request->query('s');

        if (!empty($musicalRhythmSearch))
            $musicalRhythms = MusicalRhythm::where('name', 'like' , "%{$musicalRhythmSearch}%")->paginate($this->paginate);
        else
            $musicalRhythms = MusicalRhythm::paginate($this->paginate);

        return view('admin.musicalRhythm.index',
            compact('musicalRhythms',
                'musicalRhythmSearch',
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
            'route' => 'musicalRhythm.store',
            'method' => Request::METHOD_POST,
            'files' => false,
            'onsubmit' => 'return validateFormMusicalRhythm(this)'
        ];

        $musicalRhythm = new MusicalRhythm();

        return view('admin.musicalRhythm.form',
            compact('formOptions',
                'musicalRhythm',
                'userActive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateMusicalRhythm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateMusicalRhythm $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $musicalRhythmExists = MusicalRhythm::where('name', $data["name"])->count();

            if ($musicalRhythmExists > 0)
                return redirect()
                    ->route('musicalRhythm.create')
                    ->withInput()
                    ->with('error', 'Ritmo musical já cadastrado, favor informe outro nome!');

            $musicalRhythm = MusicalRhythm::create($data);

            if (!$musicalRhythm->exists)
                throw new \Exception('Não foi possível criar o ritmo musical!');

            DB::commit();

            return redirect()
                ->route('musicalRhythm.index')
                ->with('success', 'Ritmo musical criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('musicalRhythm.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\MusicalRhythm  $musicalRhythm
     * @return \Illuminate\Http\Response
     */
    public function show(MusicalRhythm $musicalRhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        return view('admin.musicalRhythm.show',
            compact('musicalRhythm',
                'userActive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\MusicalRhythm  $musicalRhythm
     * @return \Illuminate\Http\Response
     */
    public function edit(MusicalRhythm $musicalRhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $userActive = auth()->user()->name;

        /** Create form options */
        $formOptions = [
            'route' => ['musicalRhythm.update', $musicalRhythm],
            'method' => Request::METHOD_PUT,
            'onsubmit' => 'return validateFormMusicalRhythm(this)',
        ];

        return view('admin.musicalRhythm.form',
            compact('formOptions',
                'musicalRhythm',
                'userActive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateOrUpdateMusicalRhythm  $request
     * @param  \App\Models\Admin\MusicalRhythm  $musicalRhythm
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateMusicalRhythm $request, MusicalRhythm $musicalRhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $musicalRhythm->fill($data);

            if ($musicalRhythm->isDirty())
                if (!$musicalRhythm->save())
                    throw new \Exception('Não foi possível atualizar o ritmo musical');

            DB::commit();

            return redirect()
                ->route('musicalRhythm.index')
                ->with('success', 'Ritmo musical atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('musicalRhythm.edit', compact('musicalRhythm'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\MusicalRhythm  $musicalRhythm
     * @return \Illuminate\Http\Response
     */
    public function destroy(MusicalRhythm $musicalRhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        DB::beginTransaction();

        try {
            if ($musicalRhythm->delete()) :
                DB::commit();

                return redirect()
                    ->route('musicalRhythm.index')
                    ->with('success', 'Ritmo musical excluído com sucesso');
            else:
                DB::rollBack();

                return redirect()
                    ->route('musicalRhythm.index', compact('musicalRhythm'))
                    ->withInput()
                    ->with('error', 'Ocorreu um erro desconhecido ao excluir o ritmo musical, tente novamente.');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('musicalRhythm.index', compact('musicalRhythm'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
