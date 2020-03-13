<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Establishment;


class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Establishment::create([
            'user_id'                => 1,
            'corporate_name'         => 'AUTHENTIC OUTLET',
            'state_registration'     => '1234567890000000',
            'type_license'           => 'f',
            'status'                 => true,
        ]);
    }
}
