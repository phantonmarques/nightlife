<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateOrUpdateRhythm;
use App\Models\Admin\Rhythm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RhythmController extends Controller
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

        $rhythmSearch = $request->query('s');

        if (!empty($rhythmSearch))
            $rhythms = Rhythm::where('name', 'like' , "%{$rhythmSearch}%")->paginate($this->paginate);
        else
            $rhythms = Rhythm::paginate($this->paginate);

        return view('admin.rhythm.index',
            compact('rhythms',
                'rhythmSearch'));
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
            'route' => 'rhythm.store',
            'method' => Request::METHOD_POST,
            'files' => false,
            'onsubmit' => 'return validateFormRhythm(this)'
        ];

        $rhythm = new Rhythm();

        return view('admin.rhythm.form',
            compact('formOptions',
                'rhythm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateRhythm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateRhythm $request)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $rhythmExists = Rhythm::where('name', $data["name"])->count();

            if ($rhythmExists > 0)
                return redirect()
                    ->route('rhythm.create')
                    ->withInput()
                    ->with('error', 'Ritmo musical já cadastrado, favor informe outro nome!');

            $rhythm = Rhythm::create($data);

            if (!$rhythm->exists)
                throw new \Exception('Não foi possível criar o ritmo musical!');

            DB::commit();

            return redirect()
                ->route('rhythm.index')
                ->with('success', 'Ritmo musical criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('rhythm.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Rhythm  $rhythm
     * @return \Illuminate\Http\Response
     */
    public function show(Rhythm $rhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        return view('admin.rhythm.show',
            compact('rhythm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Rhythm  $rhythm
     * @return \Illuminate\Http\Response
     */
    public function edit(Rhythm $rhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        /** Create form options */
        $formOptions = [
            'route' => ['rhythm.update', $rhythm],
            'method' => Request::METHOD_PUT,
            'onsubmit' => 'return validateFormRhythm(this)',
        ];

        return view('admin.rhythm.form',
            compact('formOptions',
                'rhythm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateOrUpdateRhythm  $request
     * @param  \App\Models\Admin\Rhythm  $rhythm
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateRhythm $request, Rhythm $rhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $rhythm->fill($data);

            if ($rhythm->isDirty())
                if (!$rhythm->save())
                    throw new \Exception('Não foi possível atualizar o ritmo musical');

            DB::commit();

            return redirect()
                ->route('rhythm.index')
                ->with('success', 'Ritmo musical atualizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('rhythm.edit', compact('rhythm'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Rhythm  $rhythm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rhythm $rhythm)
    {
        if (! auth()->user()->can('manage-users'))
            return abort(401);

        DB::beginTransaction();

        try {
            if ($rhythm->delete()) :
                DB::commit();

                return redirect()
                    ->route('rhythm.index')
                    ->with('success', 'Ritmo musical excluído com sucesso');
            else:
                DB::rollBack();

                return redirect()
                    ->route('rhythm.index', compact('rhythm'))
                    ->withInput()
                    ->with('error', 'Ocorreu um erro desconhecido ao excluir o ritmo musical, tente novamente.');
            endif;
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('rhythm.index', compact('rhythm'))
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
