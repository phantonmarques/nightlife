<?php

namespace App\Http\Controllers\ControlAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\User;
use App\Models\Site\State;
use App\Models\PainelAdmin\old;


class AdminController extends Controller
{
    private $totalPage = 10;


    public function __construct()
    {
        #SOMENTE AUTENTICADOS
        $this->middleware('auth');
        #DEPOIS CRIAR FUNÇÃO PARA VALIDAR APENAS AUTENTICADOS DO SISTEMA COM PERMISSÃO DE ADMIN
    }

    /**
     * TODO: FUNÇÃO PARA REDIRECIONAR A PAGINA INICIAL
     * @return mixed
     */
    public function index(){
        $userActive = auth()->user()->name;
        return view('paineladmin.home.home', compact('userActive'));
    }

    /**
     * TODO: FUNÇÃO PARA REDIRECIONAR PARA VIEW FORMULÁRIO DE CADASTRO DE ESTABELECIMENTO
     * @param State $estado
     * @return mixed
     */
    public function criarEstabelecimento(State $estado){
        $estados = $estado->all();
        $usuario = auth()->user()->name;
        return view('paineladmin.admin.establishment.criar-estabelecimento', compact('usuario', 'estados'));
    }

    /**
     * TODO: FUNÇÃO UTILIZADA PARA CADASTRO DO ESTABELECIMENTO, PERMITIDO APENAS PARA MANAGERS
     * @param Request $request
     * @param User $user
     * @param Estabelecimento $estabelecimento
     * @return mixed
     */
    public function inserirEstabelecimento(Request $request, User $user, old $estabelecimento){
        # INSERÇÃO DE USUÁRIO - ESTABELECIMENTO (PRINCIPAL)
        $ddd_main = $this->dddTelefone($request->telefone_f);
        $phone_main = str_replace("(".$ddd_main.")", "", $request->telefone_f);
        $phone_main = trim(str_replace("-","",$phone_main));

        $user_insert = array(
            'name'                  => isset($request->nomeFantasiaEstab) ? $request->nomeFantasiaEstab : '',
            'email'                 => isset($request->emailEstab) ? $request->emailEstab : '',
            'login'                 => isset($request->loginEstab) ? $request->loginEstab : '',
            'password'              => isset($request->senhaEstab) ? $request->senhaEstab : '',
            'password_confirmation' => isset($request->confirmSenha) ? $request->confirmSenha : '',
            'cpf_cnpj'              => isset($request->cnpjEstab) ? $request->cnpjEstab : '',
            'city_id'               => isset($request->cidadeEstab) ? intval($request->cidadeEstab) : '',
            'state_id'              => isset(($user->buscarEstado($request->estadoEstab)[0])->id) ? intval(($user->buscarEstado($request->estadoEstab)[0])->id) : '',
            'contact_main'          => isset($request->contatoTelefone_f) ? $request->contatoTelefone_f : '',
            'ddd_main'              => isset($ddd_main) ? $ddd_main : 0,
            'phone_main'            => isset($phone_main) ? $phone_main : 0,
            '_token'                => isset($request->_token) ? $request->_token : 0
        );

        $validate_user = validator($user_insert,$user->rules,$user->messages);

        if($validate_user->fails())
            return redirect()->back()->withErrors($validate_user)->withInput();

        $insert_1 = $user->inserirEstabelecimento($user_insert);

        if ($insert_1["success"]){
            # INSERÇÃO DE ESTABELECIMENTO - DADOS

            $ddd_1 = $this->dddTelefone($request->telefone_c1);
            $phone_1 = str_replace("(".$ddd_1.")", "", $request->telefone_c1);
            $phone_1 = trim(str_replace("-","",$phone_1));
            $ddd_2 = $this->dddTelefone($request->telefone_c2);
            $phone_2 = str_replace("(".$ddd_2.")", "", $request->telefone_c2);
            $phone_2 = trim(str_replace("-","",$phone_2));

            $estab_insert = array(
                "user_id"               => isset($insert_1['id']) ? $insert_1['id'] : 0,
                "corporate_name"        => isset($request->razaoSocialEstab) ? $request->razaoSocialEstab : '',
                "state_registration"    => isset($request->inscrEstadualEstab) ? $request->inscrEstadualEstab : '',
                "contact_1"             => isset($request->contatoTelefone_c1) ? $request->contatoTelefone_c1 : '',
                "ddd_1"                 => isset($ddd_1) ? $ddd_1 : '',
                "phone_1"               => isset($phone_1) ? $phone_1 : '',
                "contact_2"             => isset($request->contatoTelefone_c2) ? $request->contatoTelefone_c2 : '',
                "ddd_2"                 => isset($ddd_2) ? $ddd_2 : '',
                "phone_2"               => isset($phone_2) ? $phone_2 : '',
                "zip_code"              => isset($request->cepEstab) ? $request->cepEstab : '',
                "address"               => isset($request->enderecoEstab) ? $request->enderecoEstab : '',
                "number_address"        => isset($request->numeroEstab) ? $request->numeroEstab : '',
                "complement_address"    => isset($request->complementoEstab) ? $request->complementoEstab : '',
                "neighborhood_address"  => isset($request->bairroEstab) ? $request->bairroEstab : '',
                "type_license"          => $request->tipoContaEstab === 'basica' ? 'b' : 'f'
            );

            $validate_estab = validator($estab_insert,$estabelecimento->rules,$estabelecimento->messages);

            if($validate_estab->fails())
                return redirect()->back()->withErrors($validate_estab)->withInput();

            $insert_2 = $estabelecimento->inserirEstabelecimento($estab_insert);

            if ($insert_2['success'])
                return $this->listaEstabelecimento($insert_1['id'], $insert_2['id']);

            dd('deu ruim');
            return redirect()->back()->with('error', $insert_2['message']);
        }

        dd('deu ruim2');
        return redirect()->back()->with('error', $insert_1['message']);
    }

    public function listarEstabelecimentos(Estabelecimento $estab){
        $usuario = auth()->user()->name;
        $estabelecimentos = $estab->with(['userEstab'])->get();//$estab->userEstab()->paginate($this->totalPage);

        dd($estabelecimentos);

        return view('paineladmin.admin.establishment.lista-estabelecimento', compact('estabelecimentos', 'usuario'));
    }


    private function listaEstabelecimento($idUser, $idEstab){
        $estab = old::find($idUser);
        $userEstab = User::find($idEstab);
        $usuario = auth()->user()->name;
        $mensagem = 'Estabelecimento Cadastrado com Sucesso!';

        echo json_encode($estab->name);
        dd('tst');

        return view('paineladmin.admin.establishment.lista-estabelecimento', compact('userEstab','estab', 'usuario','mensagem'));
    }

    /**
     * TODO: FUNÇÃO UTILIZADA PARA REALIZAR REGEX NO TELEFONE PARA CAPTURAR O DDD RECEBIDO PELO FORMULÁRIO
     * @param $telefone
     * @return mixed
     */
    private function dddTelefone($telefone){
        #ddd - regex
        preg_match('/(\d+)/', $telefone, $matches, PREG_OFFSET_CAPTURE, 0);
        return $matches[0][0];
    }
}
