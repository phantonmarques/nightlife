<?php

use Illuminate\Database\Seeder;
use App\Models\Site\User;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;


    class UserSeeder extends Seeder
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

        $user1 = new User();
        $user1->name = 'Daniel Marques';
        $user1->email = 'revolt_car@hotmail.com';
        $user1->password = bcrypt('123456');
        $user1->cpf_cnpj = '04738156055';
        $user1->city_id = 1;
        $user1->state_id = 1;
        $user1->type_user = 'a';
        $user1->email_verified_at = date('Y-m-d H:i:s');
        $user1->save();
        $user1->roles()->attach($admin);
        $user1->permissions()->attach($manageCalled);
        $user1->permissions()->attach($manageEstablishment);
        $user1->permissions()->attach($manageUsers);


        $manager = Role::where('slug', 'establishment')->first();
        $establishmentManager = Permission::where('slug','establishment-manager')->first();


        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->cpf_cnpj = '01845655894';
        $user2->city_id = 1;
        $user2->state_id = 1;
        $user2->type_user = 'e';
        $user2->email_verified_at = date('Y-m-d H:i:s');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($establishmentManager);


        $manager = Role::where('slug', 'establishment')->first();
        $establishmentManager = Permission::where('slug','establishment-manager')->first();


        $user3 = new User();
        $user3->name = 'Teste 1';
        $user3->email = 'teste@nightlife.com.br';
        $user3->password = bcrypt('123456');
        $user3->cpf_cnpj = '06215255418';
        $user3->city_id = 1;
        $user3->state_id = 1;
        $user3->type_user = 'e';
        $user3->email_verified_at = date('Y-m-d H:i:s');
        $user3->save();
        $user3->roles()->attach($manager);
        $user3->permissions()->attach($establishmentManager);
    }
}
