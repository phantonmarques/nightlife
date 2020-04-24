<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessAdmin = new Permission();
        $accessAdmin->name = 'Acesso Administradores';
        $accessAdmin->slug = 'access-admin';
        $accessAdmin->save();

        $manageUser = new Permission();
        $manageUser->name = 'Gerenciar Usuários';
        $manageUser->slug = 'manage-users';
        $manageUser->save();

        $manageEstablishment = new Permission();
        $manageEstablishment->name = 'Gerenciar Estabelecimentos';
        $manageEstablishment->slug = 'manage-establishment';
        $manageEstablishment->save();

        $manageCalled = new Permission();
        $manageCalled->name = 'Gerenciar Chamados';
        $manageCalled->slug = 'manage-called';
        $manageCalled->save();

        $establishmentManager = new Permission();
        $establishmentManager->name = 'Gerente Estabelecimento';
        $establishmentManager->slug = 'establishment-manager';
        $establishmentManager->save();

        $establishmentEmployee = new Permission();
        $establishmentEmployee->name = 'Funcionário Estabelecimento';
        $establishmentEmployee->slug = 'establishment-employee';
        $establishmentEmployee->save();
    }
}
