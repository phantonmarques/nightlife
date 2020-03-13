<?php

namespace App\Http\Controllers\SiteInstitucional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\State;


class SiteInstController extends Controller
{
    public function index(){
        return view('siteinstitucional.home.home');
    }

    public function buscarCidades($estadoEscolhido, State $estado){
        $estadoEscolhido = $estado->with('cidades')->where('state_cod', $estadoEscolhido)->get();
        $cidadesEncontradas = $estadoEscolhido[0]->cidades;
        return json_encode($cidadesEncontradas);
    }
}
