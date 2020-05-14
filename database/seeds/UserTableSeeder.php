<?php

use Illuminate\Database\Seeder;
use App\Models\Site\User;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;


    class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # USUÁRIO MASTER ID = 1

        $admin = Role::where('slug','admin')->first();
        $manageCalled = Permission::where('slug','manage-called')->first();
        $manageEstablishment = Permission::where('slug','manage-establishment')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();
        $acessAdmin = Permission::where('slug','access-admin')->first();

        $user1 = new User();
        $user1->name = 'Daniel Marques';
        $user1->email = 'revolt_car@hotmail.com';
        $user1->password = bcrypt('123456');
        $user1->cpf_cnpj = '69915488041';
        $user1->city_id = 4175;
        $user1->type_user = 'a';
        $user1->email_verified_at = date('Y-m-d H:i:s');
        $user1->save();
        $user1->roles()->attach($admin);
        $user1->permissions()->attach($manageCalled);
        $user1->permissions()->attach($manageEstablishment);
        $user1->permissions()->attach($manageUsers);
        $user1->permissions()->attach($acessAdmin);

        # USUÁRIO ESTABELECIMENTO [PRIMO TABACARIA] - ID = 2

        $manager = Role::where('slug', 'establishment')->first();
        $establishmentManager = Permission::where('slug','establishment-manager')->first();

        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@primo.com.br';
        $user2->password = bcrypt('123456');
        $user2->cpf_cnpj = '01845655894';
        $user2->city_id = 4175;
        $user2->type_user = 'e';
        $user2->email_verified_at = date('Y-m-d H:i:s');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [VICTORIA VILLA] - ID = 3

        $user3 = new User();
        $user3->name = 'Raimundo Bernardo da Cruz';
        $user3->email = 'raimundo1990@victoriavilla.com.br';
        $user3->password = bcrypt('123456');
        $user3->cpf_cnpj = '76498518000320';
        $user3->city_id = 4004;
        $user3->type_user = 'e';
        $user3->email_verified_at = date('Y-m-d H:i:s');
        $user3->save();
        $user3->roles()->attach($manager);
        $user3->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [DANGHAI] - ID = 4

        $user4 = new User();
        $user4->name = 'Vitor Caleb Eduardo Lopes';
        $user4->email = 'victor_caleb10@danghai.com.br';
        $user4->password = bcrypt('123456');
        $user4->cpf_cnpj = '27953981000148';
        $user4->city_id = 4004;
        $user4->type_user = 'e';
        $user4->email_verified_at = date('Y-m-d H:i:s');
        $user4->save();
        $user4->roles()->attach($manager);
        $user4->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [PARK ART] - ID = 5

        $user5 = new User();
        $user5->name = 'Bruno Anthony Igor Carvalho';
        $user5->email = 'brunocarvalho@park.art.br';
        $user5->password = bcrypt('123456');
        $user5->cpf_cnpj = '56801652000180';
        $user5->city_id = 4004;
        $user5->type_user = 'e';
        $user5->email_verified_at = date('Y-m-d H:i:s');
        $user5->save();
        $user5->roles()->attach($manager);
        $user5->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [BLOOD ROCK] - ID = 6

        $user6 = new User();
        $user6->name = 'Marcelo José Diego Costa';
        $user6->email = 'marcelojose@bloodrock.com.br';
        $user6->password = bcrypt('123456');
        $user6->cpf_cnpj = '83457209000106';
        $user6->city_id = 4004;
        $user6->type_user = 'e';
        $user6->email_verified_at = date('Y-m-d H:i:s');
        $user6->save();
        $user6->roles()->attach($manager);
        $user6->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [TABACARIA MANDELA] - ID = 7

        $user7 = new User();
        $user7->name = 'Severino Osvaldo Moura';
        $user7->email = 'severinomoura@mandela.com.br';
        $user7->password = bcrypt('123456');
        $user7->cpf_cnpj = '92457713000105';
        $user7->city_id = 4175;
        $user7->type_user = 'e';
        $user7->email_verified_at = date('Y-m-d H:i:s');
        $user7->save();
        $user7->roles()->attach($manager);
        $user7->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [MILLENIUM DISCO CLUB] - ID = 8

        $user8 = new User();
        $user8->name = 'Bryan Caio Aragão';
        $user8->email = 'bryan@milleniumdiscoclub.com.br';
        $user8->password = bcrypt('123456');
        $user8->cpf_cnpj = '93961842000190';
        $user8->city_id = 4175;
        $user8->type_user = 'e';
        $user8->email_verified_at = date('Y-m-d H:i:s');
        $user8->save();
        $user8->roles()->attach($manager);
        $user8->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [DOISZERODOIS] - ID = 9

        $user9 = new User();
        $user9->name = 'Ian Theo Caio Aragão';
        $user9->email = 'ian.caio@doiszerodois.com.br';
        $user9->password = bcrypt('123456');
        $user9->cpf_cnpj = '66369838000165';
        $user9->city_id = 4175;
        $user9->type_user = 'e';
        $user9->email_verified_at = date('Y-m-d H:i:s');
        $user9->save();
        $user9->roles()->attach($manager);
        $user9->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [RODEO BAR] - ID = 10

        $user10 = new User();
        $user10->name = 'Iago Kevin Novaes';
        $user10->email = 'iago@rodeobar.com.br';
        $user10->password = bcrypt('123456');
        $user10->cpf_cnpj = '37449671000144';
        $user10->city_id = 4004;
        $user10->type_user = 'e';
        $user10->email_verified_at = date('Y-m-d H:i:s');
        $user10->save();
        $user10->roles()->attach($manager);
        $user10->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [Havana Bar] - ID = 11

        $user11 = new User();
        $user11->name = 'Edson Lucca Figueiredo';
        $user11->email = 'edson@hotmail.com';
        $user11->password = bcrypt('123456');
        $user11->cpf_cnpj = '45097650000135';
        $user11->city_id = 4004;
        $user11->type_user = 'e';
        $user11->email_verified_at = date('Y-m-d H:i:s');
        $user11->save();
        $user11->roles()->attach($manager);
        $user11->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [Peppers] - ID = 12

        $user12 = new User();
        $user12->name = 'Tiago Levi Aparício';
        $user12->email = 'tiago@peppers.com';
        $user12->password = bcrypt('123456');
        $user12->cpf_cnpj = '98139792000184';
        $user12->city_id = 4004;
        $user12->type_user = 'e';
        $user12->email_verified_at = date('Y-m-d H:i:s');
        $user12->save();
        $user12->roles()->attach($manager);
        $user12->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [James Bar] - ID = 13

        $user13 = new User();
        $user13->name = 'Lúcia Alice Pinto';
        $user13->email = 'alice@jamesbar.com.br';
        $user13->password = bcrypt('123456');
        $user13->cpf_cnpj = '11059767000102';
        $user13->city_id = 4004;
        $user13->type_user = 'e';
        $user13->email_verified_at = date('Y-m-d H:i:s');
        $user13->save();
        $user13->roles()->attach($manager);
        $user13->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [Shed Bar] - ID = 14

        $user14 = new User();
        $user14->name = 'Osvaldo Manuel Anthony Assis';
        $user14->email = 'osvaldo@shedbar.com.br';
        $user14->password = bcrypt('123456');
        $user14->cpf_cnpj = '24485941000120';
        $user14->city_id = 4004;
        $user14->type_user = 'e';
        $user14->email_verified_at = date('Y-m-d H:i:s');
        $user14->save();
        $user14->roles()->attach($manager);
        $user14->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [ALEATÓRIO PARA SER ADICIONADO AO ESTABELECIMENTO] - ID = 15

        $user15 = new User();
        $user15->name = 'Emanuelly Sônia Moreira';
        $user15->email = 'emanuelly@hotmail.com';
        $user15->password = bcrypt('123456');
        $user15->cpf_cnpj = '77992317000186';
        $user15->city_id = 4004;
        $user15->type_user = 'e';
        $user15->email_verified_at = date('Y-m-d H:i:s');
        $user15->save();
        $user15->roles()->attach($manager);
        $user15->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [ALEATÓRIO PARA SER ADICIONADO AO ESTABELECIMENTO] - ID = 16

        $user16 = new User();
        $user16->name = 'Mariana Antônia Baptista';
        $user16->email = 'mariana@hotmail.com';
        $user16->password = bcrypt('123456');
        $user16->cpf_cnpj = '85035374000103';
        $user16->city_id = 4175;
        $user16->type_user = 'e';
        $user16->email_verified_at = date('Y-m-d H:i:s');
        $user16->save();
        $user16->roles()->attach($manager);
        $user16->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [ALEATÓRIO PARA SER ADICIONADO AO ESTABELECIMENTO] - ID = 17

        $user17 = new User();
        $user17->name = 'Rosângela Cristiane Regina Castro';
        $user17->email = 'cristiane@hotmail.com';
        $user17->password = bcrypt('123456');
        $user17->cpf_cnpj = '72359229000128';
        $user17->city_id = 4004;
        $user17->type_user = 'e';
        $user17->email_verified_at = date('Y-m-d H:i:s');
        $user17->save();
        $user17->roles()->attach($manager);
        $user17->permissions()->attach($establishmentManager);

        # USUÁRIO ESTABELECIMENTO [ALEATÓRIO PARA SER ADICIONADO AO ESTABELECIMENTO] - ID = 18

        $user18 = new User();
        $user18->name = 'Miguel Anthony Santos';
        $user18->email = 'miguel_anthony@hotmail.com';
        $user18->password = bcrypt('123456');
        $user18->cpf_cnpj = '02008809000195';
        $user18->city_id = 4175;
        $user18->type_user = 'e';
        $user18->email_verified_at = date('Y-m-d H:i:s');
        $user18->save();
        $user18->roles()->attach($manager);
        $user18->permissions()->attach($establishmentManager);

        # USUÁRIO FUNCIONARIO ESTABELECIMENTO [Shed Bar] - ID = 19

        $employee = Role::where('slug', 'establishment-employee')->first();
        $establishmentEmployee = Permission::where('slug','establishment-employee')->first();

        $user19 = new User();
        $user19->name = 'Lorena Antonella Alice Aparício';
        $user19->email = 'loh@shedbar.com.br';
        $user19->password = bcrypt('123456');
        $user19->cpf_cnpj = '02516587910';
        $user19->city_id = 4004;
        $user19->type_user = 'ef';
        $user19->establishment_connect = '13';
        $user19->email_verified_at = date('Y-m-d H:i:s');
        $user19->save();
        $user19->roles()->attach($employee);
        $user19->permissions()->attach($establishmentEmployee);

        # USUÁRIO COMUM SEM VERIFICAÇÃO - ID = 20

        $user20 = new User();
        $user20->name = 'Martin Morães';
        $user20->email = 'martinmoraes@unibrasil.com.br';
        $user20->password = bcrypt('123456');
        $user20->cpf_cnpj = '60407702954';
        $user20->city_id = 4004;
        $user20->type_user = 'u';
        $user20->save();
        $user20->user_settings()->create();

        # USUÁRIO COMUM SEM VERIFICAÇÃO - ID = 21

        $user21 = new User();
        $user21->name = 'Marcelo Fermann';
        $user21->email = 'mscfermann@gmail.com';
        $user21->password = bcrypt('123456');
        $user21->cpf_cnpj = '57913100990';
        $user21->city_id = 4004;
        $user21->type_user = 'u';
        $user21->save();
        $user21->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 22

        $user22 = new User();
        $user22->name = 'Teste Api';
        $user22->email = 'teste@nightlife.com.br';
        $user22->password = bcrypt('123456');
        $user22->cpf_cnpj = '51532155269';
        $user22->city_id = 4175;
        $user22->type_user = 'u';
        $user22->email_verified_at = date('Y-m-d H:i:s');
        $user22->save();
        $user22->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 23

        $user23 = new User();
        $user23->name = 'Alana Agatha Rodrigues';
        $user23->email = 'alana@hotmail.com';
        $user23->password = bcrypt('123456');
        $user23->cpf_cnpj = '50431277915';
        $user23->city_id = 4004;
        $user23->type_user = 'u';
        $user23->email_verified_at = date('Y-m-d H:i:s');
        $user23->save();
        $user23->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO E CIDADE ALEATORIA - ID = 24

        $user24 = new User();
        $user24->name = 'Renato André Bernardes';
        $user24->email = 'renato@hotmail.com';
        $user24->password = bcrypt('123456');
        $user24->cpf_cnpj = '95232741985';
        $user24->city_id = 3800;
        $user24->type_user = 'u';
        $user24->email_verified_at = date('Y-m-d H:i:s');
        $user24->save();
        $user24->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO E CIDADE ALEATORIA - ID = 25

        $user25 = new User();
        $user25->name = 'Nathan Diego Carlos Eduardo Nascimento';
        $user25->email = 'nathandiego@hotmail.com';
        $user25->password = bcrypt('123456');
        $user25->cpf_cnpj = '79299816905';
        $user25->city_id = 2500;
        $user25->type_user = 'u';
        $user25->email_verified_at = date('Y-m-d H:i:s');
        $user25->save();
        $user25->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 26

        $user26 = new User();
        $user26->name = 'Sophia Emily Lívia Gomes';
        $user26->email = 'sophia@hotmail.com';
        $user26->password = bcrypt('123456');
        $user26->cpf_cnpj = '05176493900';
        $user26->city_id = 4004;
        $user26->type_user = 'u';
        $user26->email_verified_at = date('Y-m-d H:i:s');
        $user26->save();
        $user26->user_settings()->create();

        # USUÁRIO COMUM COM VERIFICAÇÃO - ID = 27

        $user27 = new User();
        $user27->name = 'Raul Breno Fábio Brito';
        $user27->email = 'raul_breno@hotmail.com';
        $user27->password = bcrypt('123456');
        $user27->cpf_cnpj = '80897453930';
        $user27->city_id = 4175;
        $user27->type_user = 'u';
        $user27->email_verified_at = date('Y-m-d H:i:s');
        $user27->save();
        $user27->user_settings()->create();


    }
}
