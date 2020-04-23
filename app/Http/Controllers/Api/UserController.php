<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateOrUpdateUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(auth()->user());
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password) && !empty($user->email_verified_at)) {
                $token = Str::random(90);
                $user->remember_token = $token;
                $user->update();
                return response()->json([
                    'message' => 'Login efetuado com sucesso',
                    'status' => true,
                    'token' => $token,
                ]);
            } else if (empty($user->email_verified_at)){
                // enviar novo link de confirmação
                return response()->json([
                    'message' => 'Cadastro não confirmado, favor acesse o link de confirmação enviado no e-mail cadastrado!',
                    'status' => false
                ]);
            }else {
                return response()->json([
                    'message' => 'Senha inválida',
                    'status' => false
                ]);
            }

        } else {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => false
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CreateOrUpdateUser  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateUser $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data["password"] = bcrypt($data["password"]);

            //REMOVER DEPOIS
            $data["email_verified_at"] = date('Y-m-d H:i:s');

            $user = User::create($data);

            if (!$user->exists)
                throw new \Exception('Validação de conta falhou!');

            //CRIAR FLUXO PARA ENVIO DE LINK DE CONFIRMAÇÃO PELO E-MAIL

            DB::commit();

            return response()->json([
                'message' => 'Conta criada com sucesso',
                'status' => true,
                'success' => 'Acesse seu e-mail para confirmar o cadastro.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Não foi possível criar a conta!',
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
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
