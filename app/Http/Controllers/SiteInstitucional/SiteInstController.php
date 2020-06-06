<?php

namespace App\Http\Controllers\SiteInstitucional;

use App\Models\Site\User;
use App\Http\Controllers\Controller;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function confirmEmail($token)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user):
            $user->email_verified_at = date('Y-m-d H:i:s');
            $token = Str::random(90);
            $user->remember_token = $token;

            $object = new \stdClass();
            $object->name = $user->name;
            $object->link = 'http://localhost:3000/login';

            if ($user->save())
                return view('auth.confirmed-mail', compact('object'));

            $object->msg = 'Opss, ocorreu algum erro ao confirmar seu cadastro, foi enviado um novo e-mail de confirmação';

            $email = 'revolt_car@hotmail.com'; // $user->email;
            $objectMail = new \stdClass();
            $objectMail->name = $user->name;
            $objectMail->login = $user->email;
            $objectMail->token = $user->remember_token;
            $mail = new \stdClass();
            $mail->subject = 'Confirme seu e-mail para acessar ao Nightlife';
            $mail->template = 'auth.confirm-mail';
            $mail->replyTo = 'da3780024@gmail.com';//'fabianocm1995@hotmail.com';
            $mail->object = $objectMail;

            Mail::to($email)->send(new Email($mail));

        else:
            $object = new \stdClass();

            $object->msg = 'Opss, ocorreu algum erro ao confirmar seu cadastro, entre no link abaixo tente acessar sua conta';
            $object->link = 'http://localhost:3000/login';

        endif;


        return view('auth.error-mail', compact('object'));
    }
}
