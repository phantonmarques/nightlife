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

    public function searchCitys($stateSelect, State $estado){
        $stateSelect = $estado->with('city')->where('state_cod', $stateSelect)->select('id', 'name', 'name_visible')->first();

        return $stateSelect->city->toJson();
    }
}
