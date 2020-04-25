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
        $admin = Role::where('slug','admin')->first();
        $manageCalled = Permission::where('slug','manage-called')->first();
        $manageEstablishment = Permission::where('slug','manage-establishment')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();
        $acessAdmin = Permission::where('slug','access-admin')->first();

        $user1 = new User();
        $user1->name = 'Daniel Marques';
        $user1->email = 'revolt_car@hotmail.com';
        $user1->password = bcrypt('123456');
        $user1->cpf_cnpj = '04738156055';
        $user1->city_id = 1;
        $user1->type_user = 'a';
        $user1->email_verified_at = date('Y-m-d H:i:s');
        $user1->save();
        $user1->roles()->attach($admin);
        $user1->permissions()->attach($manageCalled);
        $user1->permissions()->attach($manageEstablishment);
        $user1->permissions()->attach($manageUsers);
        $user1->permissions()->attach($acessAdmin);

        #

        $manager = Role::where('slug', 'establishment')->first();
        $establishmentManager = Permission::where('slug','establishment-manager')->first();

        #

        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->cpf_cnpj = '01845655894';
        $user2->city_id = 10;
        $user2->type_user = 'e';
        $user2->email_verified_at = date('Y-m-d H:i:s');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($establishmentManager);

        #

        $user3 = new User();
        $user3->name = 'Teste 1';
        $user3->email = 'teste@nightlife.com.br';
        $user3->password = bcrypt('123456');
        $user3->cpf_cnpj = '06215255418';
        $user3->city_id = 78;
        $user3->type_user = 'e';
        $user3->email_verified_at = date('Y-m-d H:i:s');
        $user3->save();
        $user3->roles()->attach($manager);
        $user3->permissions()->attach($establishmentManager);

        #

        $user4 = new User();
        $user4->name = 'Teste Api';
        $user4->email = 'testeapi@hotmail.com';
        $user4->password = bcrypt('123456');
        $user4->cpf_cnpj = '51532155268';
        $user4->city_id = 600;
        $user4->type_user = 'u';
        $user4->email_verified_at = date('Y-m-d H:i:s');
        $user4->save();
        $user4->user_settings()->create(['user_id' => $user4->id]);

        #

        $user5 = new User();
        $user5->name = 'Teste Api - Sem verificacao';
        $user5->email = 'testeapi2@hotmail.com';
        $user5->password = bcrypt('123456');
        $user5->cpf_cnpj = '51532155269';
        $user5->city_id = 1050;
        $user5->type_user = 'u';
        $user5->save();
        $user5->user_settings()->create(['user_id' => $user5->id]);

    }
}
