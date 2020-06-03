<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateOrUpdateUser;
use App\Http\Requests\Api\CreateUserComment;
use App\Http\Requests\Api\CreateUserRating;
use App\Http\Requests\Api\UpdatePicture;
use App\Models\Site\UserComment;
use App\Models\Site\UserRating;
use App\Models\Site\State;
use App\Models\Site\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Zend\Diactoros\Response\JsonResponse;

class UserController extends Controller
{
    /**
     * Login user common
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->user)
            ->orWhere('cpf_cnpj', $request->user)->first();

        if ($user):
            if (Hash::check($request->password, $user->password) && !empty($user->email_verified_at)):
                $token = Str::random(90);
                $user->remember_token = $token;
                $user->update();
                return response()->json([
                    'message' => 'Login efetuado com sucesso',
                    'status' => true,
					'token' => $token,
					'type' => $user->type_user,
                ]);
            elseif (empty($user->email_verified_at)):
                // enviar novo link de confirmação
                return response()->json([
                    'message' => 'Cadastro não confirmado, favor acesse o link de confirmação enviado no e-mail cadastrado!',
                    'status' => false
                ]);
            else:
                return response()->json([
                    'message' => 'Senha inválida',
                    'status' => false
                ]);
            endif;

        else:
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status' => false
            ]);
        endif;
    }

    /**
     * Info common user
     * @param CreateOrUpdateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        $user = auth()->user();

        $user->recent_rating_establishments = UserRating::with('establishment')->whereHas('establishment', function ($q) {
            $q->whereStatus(1); })->where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();;

        $user->recent_comments_establishments = UserComment::with('establishment')->whereHas('establishment', function ($q) {
            $q->whereStatus(1); })->where('user_id', $user->id)->where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();;

        $user->user_settings;

        if (!empty($user->name))
            return response()->json([
                'status' => true,
                'data' => $user
            ]);

        return response()->json([
            'status' => false,
            'data' => 'Ocorreu erro ao buscar suas informações, por favor verifique a conexão e tente novamente'
        ]);
    }

    /**
     * Function Search citys of certain state
     * @param $stateSelect
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCitys($state)
    {
        $citys = City::where('state_id', $state)->pluck('id', 'name_visible');

        if (count($citys) > 0)
            return response()->json([
                'status' => true,
                'data' => City::where('state_id', $state)->pluck('id', 'name_visible')
            ]);

        return response()->json([
            'status' => false,
            'message' => 'Cidade não encontrada!'
        ]);
    }

    /**
     * Function Search state selected
     * @param $state
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchStates()
    {
        return response()->json([
            'status' => true,
            'data' => State::pluck('id', 'name_visible')
        ]);
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

        if (auth()->user()->user_comment()->where('establishment_id', $data['establishment_id'])->count() > 0)
            return response()->json([
                'status' => false,
                'message' => 'Não foi possível criar o comentário, é permitido apenas um comentário por estabelecimento!'
            ]);

        DB::beginTransaction();

        try {
            $data["author"] = auth()->user()->name;

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

        if (auth()->user()->user_rating()->where('establishment_id', $data['establishment_id'])->count() > 0)
            return response()->json([
                'status' => false,
                'message' => 'Não foi possível criar a avaliação, é permitido apenas uma avaliação por estabelecimento!'
            ]);

        DB::beginTransaction();

        try {
            $data["author"] = auth()->user()->name;

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
     * @return JsonResponse
     */
    public function update(CreateOrUpdateUser $request)
    {
				$data = $request->validated();
				
				$category = $rhythm = [];

        # FORMATAÇÃO DOS DADOS RECEBIDOS
        foreach ($request->all() as $key => $requestField):
            if (strpos($key, 'category') !== false)
                $category[] = preg_split("/(\[|\])/", $key)[1];
            else if (strpos($key, 'rhythm') !== false)
								$rhythm[] = preg_split("/(\[|\])/", $key)[1];
				endforeach;
								
				$data['favorite_rhythms'] = $rhythm;
				$data['favorite_categorys'] = $category;

        DB::beginTransaction();

        try {
            if (isset($data["password"]))
                $data["password"] = bcrypt($data["password"]);

            $user = auth()->user();

            $user->fill($data);

            if ($user->isDirty())
                if (!$user->save())
                    throw new \Exception('Não foi possível atualizar o usuário');

            $favorites = $user->user_settings;

            $favorites->fill($data);

            if ($favorites->isDirty())
                if (!$favorites->save())
                    throw new \Exception('Não foi possível atualizar o usuário');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Usuário atualizado com sucesso!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Não foi possível atualizar o usuário!',
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update/Insert image user common
     * @param UpdatePicture $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImg(UpdatePicture $request)
    {
		$data = $request->validated();

        DB::beginTransaction();

        try {
            if (!empty(auth()->user()->profile_picture_path))
                if (!Storage::disk('public')->delete(auth()->user()->profile_picture_path))
                    throw new \Exception('Não foi possível atualizar a foto do perfil!');

            $imageBase64 = explode(',', $data['image']);
            $format = '.' . str_replace(['data:image/', ';', 'base64'], ['', '', ''], $imageBase64[0]);
            $file = base64_decode($imageBase64[1]);
            $path = 'user/' . Str::random(40) . $format;

            if (!Storage::disk('public')->put($path, $file))
								throw new \Exception('Não foi possível armazenar a foto do perfil!');

            $user = auth()->user();
            $user->profile_picture_path = $path;

            if (!$user->update())
                throw new \Exception('Ocorreu um erro ao atualizar a foto do perfil!');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Foto inserida com sucesso!',
                'path' => $path
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Não foi possível inserir a foto!',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
