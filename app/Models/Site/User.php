<?php

namespace App\Models\Site;

//use App\Models\Site\State;
use App\Models\Admin\Establishment;
//use App\Models\PainelAdmin\old;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password', 'cpf_cnpj', 'email_verified_at','login', 'city_id', 'state_id', 'type_user', 'ddd_main',
//        'phone_main','remember_token'
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token', 'id'
//    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * TODO: REGRAS PARA CRIAÇÃO DE USUÁRIO
     * @var array
     */
    public $rules = [
        'name'          => ['required', 'string', 'min:4','max:100'],
        'login'         => ['required', 'string', 'min:4', 'max:20', 'unique:user'],
        'email'         => ['required', 'string', 'email', 'max:100', 'unique:user'],
        'password'      => ['required', 'string', 'min:8', 'confirmed'],
        'cpf_cnpj'      => ['required', 'string', 'min:11', 'max:14', 'unique:user'],
        'city_id'       => ['required', 'numeric', 'digits_between:1,4'],
        'state_id'      => ['required', 'numeric', 'digits_between:1,4'],
        'contact_main'  => ['string', 'min:4', 'max:100'],
        'ddd_main'      => ['required', 'numeric', 'digits_between:2,3'],
        'phone_main'    => ['required', 'numeric', 'digits_between:7,9'],
        '_token'        => ['required'],
    ];

    /**
     * TODO: MENSAGENS DE ERROS CASO OS ATRIBUTOS PARA INSERÇÃO NO BANCO ESTEJAM INCORRETAS
     * @var array
     */
    public $messages = [
        'name.required'             => 'O campo nome é de preenchimento obrigatório!',
        'name.min'                  => 'O campo nome aceita no mínimo 4 caracteres',
        'name.max'                  => 'O campo nome aceita apenas 100 caracteres!',
        'login.required'            => 'O campo login é de preenchimento obrigatório!',
        'login.min'                 => 'O campo login deve conter no mínimo 4 caracteres!',
        'login.max'                 => 'O campo login deve conter no máximo 20 caracteres!',
        'login.unique'              => 'O login informado já existe, favor informe outro!',
        'email.required'            => 'O campo email é de preenchimento obrigatório!',
        'email.email'               => 'Informe um e-mail válido!',
        'email.max'                 => 'O campo e-mail aceita apenas 100 caracteres!',
        'email.unique'              => 'O e-mail informado já existe, favor informe outro!',
        'password.required'         => 'O campo senha é de preenchimento obrigatório!',
        'password.min'              => 'O campo senha deve conter no mínimo 8 caracteres!',
        'password.confirmed'        => 'O campo de confirmação de senha é necessário ser igual a senha!',
        'cpf_cnpj.required'         => 'O campo cpf/cnpj é de preenchimento obrigatório!',
        'cpf_cnpj.min'              => 'O campo cpf/cnpj está inválido, preencha corretamente e tente novamente!',
        'cpf_cnpj.max'              => 'O campo cpf/cnpj está inválido, preencha corretamente e tente novamente!',
        'cpf_cnpj.unique'           => 'O cpf/cnpj informado já está cadastrado, favor informe outro!',
        'city_id.required'          => 'Selecione uma cidade!',
        'city_id.numeric'           => 'Selecione uma opção válida!',
        'city_id.digits_between'    => 'Selecione uma opção válida!',
        'state_id.required'         => 'Selecione um estado!',
        'state_id.numeric'          => 'Selecione uma opção válida!',
        'state_id.digits_between'   => 'Selecione uma opção válida!',
        'contact_main.min'          => 'O campo contato deve conter no mínimo 4 caracteres!',
        'contact_main.max'          => 'O campo contato deve conter no máximo 100 caracteres!',
        'ddd_main.required'         => 'O campo DDD é de preenchimento obrigatório!',
        'ddd_main.numeric'          => 'O campo DDD deve conter somente números!',
        'ddd_main.digits_between'   => 'O campo DDD deve conter no mínimo 2 números e no máximo 3 números!',
        'phone_main.required'       => 'O campo telefone é de preenchimento obrigatório!',
        'phone_main.numeric'        => 'O campo telefone deve conter somente números!',
        'phone_main.digits_between' => 'O campo telefone deve conter no mínimo 7 números e no máximo 9 números!',
        '_token.required'           => 'Erro desconhecido, tente novamente, caso persistir contate o administrador do sistema!',
    ];

    /**
     * TODO: INSERÇÃO DO USUÁRIO [ESTABELECIMENTO]
     * @param $data
     * @return array
     */
    public function inserirEstabelecimento($data){
        $data["type_user"] = 'e';

        DB::beginTransaction();

        $this->name                 = $data['name'];
        $this->email                = $data['email'];
        $this->email_verified_at    = now();
        $this->login                = $data['login'];
        $this->password             = $data['password'];
        $this->cpf_cnpj             = $data['cpf_cnpj'];
        $this->city_id              = $data['city_id'];
        $this->state_id             = $data['state_id'];
        $this->contact_main         = $data['contact_main'];
        $this->ddd_main             = $data['ddd_main'];
        $this->phone_main           = $data['phone_main'];
        $this->type_user            = 'e';
        $this->setRememberToken($data['_token']);

        $insert = $this->save();

        if ($insert){
            DB::commit();

            return[
                'success'   => true,
                'message'   => 'Sucesso ao criar usuário estabelecimento!',
                'id'        => $this->id
             ];
        }else {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao criar usuário estabelecimento!'
            ];
        }

    }

    /**
     * TODO: FUNÇÃO PARA USUÁRIO BUSCAR O ID DO ESTADO SELECIONADO EM FORMULÁRIO
     * @param $stateSelect
     * @return mixed
     */
    public function buscarEstado($stateSelect){
        return State::where('state_cod', $stateSelect)->get();
    }

    public static function typeUsers($type){
        if ($type === 'a')
            return 'Administrador';
        elseif ($type === 'f')
            return 'Funcionário';
        elseif ($type === 'ef')
            return 'Funcionário Estabelecimento';
        elseif ($type === 'u')
            return 'Usuário';
    }

    public function establishments(){
        return $this->hasMany(Establishment::class, 'id', 'user_id');
    }


}
