<?php

namespace App\Models\PainelAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Site\User;

class Estabelecimento extends Model
{
    protected $table = 'establishment';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'corporate_name', 'state_registration', 'contact_1','ddd_1', 'phone_1', 'contact_2', 'ddd_2', 'phone_2',
        'zip_code','address', 'number_address', 'complement_address', 'neighborhood_address', 'type_license', 'status'
    ];

    /**
     * TODO: REGRAS PARA CRIAÇÃO DE ESTABELECIMENTO
     * @var array
     */
    public $rules = [
        'user_id'                   => ['required', 'numeric',  'unique:establishment'],
        'corporate_name'            => ['required', 'string', 'min:4', 'max:50'],
        'state_registration'        => ['required', 'string', 'min:5', 'max:22', 'unique:establishment'], // mudar max12
        'contact_1'                 => ['string', 'min:4', 'max:20'],
        'ddd_1'                     => ['numeric', 'digits_between:2,3'],
        'phone_1'                   => ['numeric', 'digits_between:7,9'],
        'contact_2'                 => ['string', 'min:4', 'max:20'],
        'ddd_2'                     => ['numeric', 'digits_between:2,3'],
        'phone_2'                   => ['numeric', 'digits_between:7,9'],
        'zip_code'                  => ['required', 'string', 'min:8', 'max:10'],
        'address'                   => ['required', 'string', 'min:3', 'max:70'],
        'number_address'            => ['required', 'numeric', 'digits_between:1,8'],
        'complement_address'        => ['string', 'min:4', 'max:100'],
        'neighborhood_address'      => ['required', 'string', 'min:4', 'max:100'],
    ];

    /**
     * TODO: MENSAGENS DE ERROS CASO OS ATRIBUTOS PARA INSERÇÃO NO BANCO ESTEJAM INCORRETAS
     * @var array
     */
    public $messages = [
        'user_id.required'              => 'Erro na criação do usuário estabelecimento!',
        'user_id.numeric'               => 'Erro na criação do usuário estabelecimento!',
        'user_id.unique'                => 'Erro na criação do usuário estabelecimento!',
        'corporate_name.required'       => 'O campo razão social é obrigatório!',
        'corporate_name.min'            => 'O campo razão social deve conter no mínimo 4 caracteres!',
        'corporate_name.max'            => 'O campo razão social deve conter no máximo 50 caracteres!',
        'state_registration.required'   => 'O campo inscrição estadual é obrigatório!',
        'state_registration.min'        => 'O campo inscrição estadual deve conter no mínimo 5 caracteres!',
        'state_registration.max'        => 'O campo  inscrição estadual deve conter no máximo 12 caracteres!',
        'state_registration.unique'     => 'A inscrição estadual informado já está cadastrada, favor informe outro!',
        'contact_1.min'                 => 'O contato 1 deve conter no mínimo 4 caracteres!',
        'contact_1.max'                 => 'O campo  contato 2 deve conter no máximo 20 caracteres!',
        'ddd_1.numeric'                 => 'Os campos de DDD devem conter somente números!',
        'ddd_1.digits_between'          => 'Os campos de DDD devem conter no mínimo 2 números e no máximo 3 números!',
        'phone_1.numeric'               => 'Os campos de telefone devem conter somente números!',
        'phone_1.digits_between'        => 'Os campos de telefone devem conter no mínimo 7 números e no máximo 9 números!',
        'contact_2.min'                 => 'O contato 1 deve conter no mínimo 4 caracteres!',
        'contact_2.max'                 => 'O campo  contato 2 deve conter no máximo 20 caracteres!',
        'ddd_2.numeric'                 => 'Os campos de DDD devem conter somente números!',
        'ddd_2.digits_between'          => 'Os campos de DDD devem conter no mínimo 2 números e no máximo 3 números!',
        'phone_2.numeric'               => 'Os campos de telefone devem conter somente números!',
        'phone_2.digits_between'        => 'Os campos de telefone devem conter no mínimo 7 números e no máximo 9 números!',
        'zip_code.required'             => 'O campo cep é de preenchimento obrigatório!',
        'zip_code.min'                  => 'O campo cep está inválido, preencha corretamente e tente novamente!',
        'zip_code.max'                  => 'O campo cep está inválido, preencha corretamente e tente novamente!',
        'address.required'              => 'O campo endereço é de preenchimento obrigatório!',
        'address.min'                   => 'O campo endereço deve conter no mínimo 3 caracteres!',
        'address.max'                   => 'O campo endereço deve conter no máximo 70 caracteres!',
        'number_address.required'       =>  'O campo número é de preenchimento obrigatório!',
        'number_address.numeric'        => 'O campo número aceita somente números, preencha corretamente e tente novamente!',
        'number_address.digits_between' => 'O número do local deve conter de 1 a 8 números!',
        'complement_address.min'        => 'O campo complemento deve conter no mínimo 4 caracteres!',
        'complement_address.max'        => 'O campo complemento deve conter no máximo 100 caracteres!',
        'neighborhood_address.required' => 'Selecione um bairro válido!',
        'neighborhood_address.min'      => 'Selecione um bairro válido!',
        'neighborhood_address.max'      => 'Selecione um bairro válido!',
    ];

    /**
     * TODO: INSERÇÃO DO ESTABELECIMENTO
     * @param $data
     * @return array
     */
    public function inserirEstabelecimento($data){

        DB::beginTransaction();

        $this->user_id                = $data['user_id'];
        $this->corporate_name         = $data['corporate_name'];
        $this->state_registration     = $data['state_registration'];
        $this->contact_1              = $data['contact_1'];
        $this->ddd_1                  = $data['ddd_1'];
        $this->phone_1                = $data['phone_1'];
        $this->contact_2              = $data['contact_2'];
        $this->ddd_2                  = $data['ddd_2'];
        $this->phone_2                = $data['phone_2'];
        $this->zip_code               = $data['zip_code'];
        $this->address                = $data['address'];
        $this->number_address         = $data['number_address'];
        $this->complement_address     = $data['complement_address'];
        $this->neighborhood_address   = $data['neighborhood_address'];
        $this->type_license           = $data['type_license'];
        $this->status                 = true;

        $insert = $this->save();

        if ($insert){
            DB::commit();

            return[
                'success'   => true,
                'message'   => 'Sucesso ao criar estabelecimento!',
                'id'        => $this->id
            ];
        }else {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Falha ao criar estabelecimento!'
            ];
        }
    }

    public function users(){
        return $this->belongsTo( 'User');
    }

}
