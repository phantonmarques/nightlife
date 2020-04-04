<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Administrador';
        $manager->slug = 'admin';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Estabelecimento';
        $developer->slug = 'establishment';
        $developer->save();
    }
}
