<?php

namespace App\Http\Controllers\Auth;

use App\Models\Site\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/site';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'login'     => ['required', 'string', 'min:6', 'max:20', 'unique:user'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'city'      => ['required', 'numeric', 'min:1', 'max:4'],
            'state'     => ['required', 'numeric', 'min:1', 'max:4'],
            'ddd_main'      => ['required', 'numeric', 'min:2', 'max:3'],
            'phone_main'   => ['required', 'numeric', 'min:7', 'max:9'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        dd('oibb - estou em registercontroller.php');
        return User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'city_id' => $data['city_id'],
            'state_id' => $data['state_id'],
            'contact_main' => $data['contact_main'],
            'ddd_main' => $data['ddd_main'],
            'phone_main' => $data['phone_main'],
            'type_user' => 'u',
            'remember_token' => $data['_token']
        ]);
    }
}
