<?php

namespace App\Http\Controllers\SiteInstitucional;

use App\Models\Site\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\City;


class SiteInstController extends Controller
{
    public function index(){
        return view('siteinstitucional.home.home');
    }

    public function searchCitys($stateSelect){
        return City::where('state_id', $stateSelect)->select( 'id', 'name', 'name_visible')->get()->toJson();
    }

    public function searchState($state){
        return State::where('state_cod', $state)->select('id')->first()->toJson();
    }
}
