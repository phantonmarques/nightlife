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

    /** PROVISÓRIO
     */
    public function login()
    {
        return view('siteinstitucional.auth.login');
    }
}
