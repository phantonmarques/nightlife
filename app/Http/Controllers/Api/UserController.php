<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateOrUpdateUser;
use App\Http\Requests\Api\CreateUserComment;
use App\Http\Requests\Api\CreateUserRating;
use App\Models\Site\UserRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Login user common
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
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
            } else if (empty($user->email_verified_at)) {
                // enviar novo link de confirmação
                return response()->json([
                    'message' => 'Cadastro não confirmado, favor acesse o link de confirmação enviado no e-mail cadastrado!',
                    'status' => false
                ]);
            } else {
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
     * Register user common
     * @param CreateOrUpdateUser $request
     * @return \Illuminate\Http\JsonResponse
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

            $token = Str::random(90);
            $user->remember_token = $token;
            $user->update();

            $created = $user->user_settings()->create();

            if (!$created)
                throw new \Exception('Ocorreu um erro desconhecido ao criar a conta, tente novamente!');

            //CRIAR FLUXO PARA ENVIO DE LINK DE CONFIRMAÇÃO PELO E-MAIL

            DB::commit();

            return response()->json([
                'message' => 'Conta criada com sucesso',
                'status' => true,
                'token' => $token
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
     * Register rating common user
     * @param CreateOrUpdateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeComment(CreateUserComment $request)
    {
        $data = $request->validated();

        dd($created = auth()->user()->user_comment()->create($data));

        DB::beginTransaction();

        try {
            $created = auth()->user()->user_comment()->create($data);

            if (!$created)
                throw new \Exception('Erro ao criar o comentário, por favor tente novamente!');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Comentário enviada com sucesso!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Não foi possível criar o comentário!',
                'errors' => $e->getMessage()
            ]);
        }
    }


    /**
     * Register rating common user
     * @param CreateOrUpdateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRating(CreateUserRating $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $created = auth()->user()->user_rating()->create($data);

            if (!$created)
                throw new \Exception('Erro ao criar a avaliação, por favor tente novamente!');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Avaliação enviada com sucesso!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Não foi possível criar a avaliação!',
                'errors' => $e->getMessage()
            ]);
        }
    }


    /**
     * Update user common
     * @param Request $request
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove user common
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        //
    }
}
