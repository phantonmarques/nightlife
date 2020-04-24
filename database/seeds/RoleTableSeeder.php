<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageCalled = Permission::where('slug','manage-called')->first();
        $manageEstablishment = Permission::where('slug','manage-establishment')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();
        $acessAdmin = Permission::where('slug','access-admin')->first();

        #

        $manager = new Role();
        $manager->name = 'Administrador';
        $manager->slug = 'admin';
        $manager->save();
        $manager->permissions()->attach($manageCalled);
        $manager->permissions()->attach($manageEstablishment);
        $manager->permissions()->attach($manageUsers);
        $manager->permissions()->attach($acessAdmin);

        #

        $manager = Role::where('slug', 'establishment')->first();
        $establishmentManager = Permission::where('slug','establishment-manager')->first();

        #

        $establishment = new Role();
        $establishment->name = 'Estabelecimento';
        $establishment->slug = 'establishment';
        $establishment->save();
        $establishment->permissions()->attach($manager);
        $establishment->permissions()->attach($establishmentManager);

        #

        $establishmentEmployee = Permission::where('slug','establishment-employee')->first();

        #

        $employee = new Role();
        $employee->name = 'Funcionário Estabelecimento';
        $employee->slug = 'establishment';
        $employee->save();

        $employee->permissions()->attach($establishmentEmployee);
    }
}
