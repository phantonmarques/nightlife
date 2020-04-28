<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Establishment;
use App\Models\Admin\EstablishmentAddress;

class EstablishmentAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $establishment = Establishment::where('corporate_name', 'AUTHENTIC OUTLET')->first();
        $address = new EstablishmentAddress();

        $address->zip_code = '83326150';
        $address->street_name = 'Rua Francisco Eugênio Gomes Pereira';
        $address->building_number = '245';
        $address->complement = 'Casa';
        $address->neighborhood = 'Atuba';
        $address->establishment_id = $establishment->id;
        $address->city_id = 4175;
        $address->save();
        $address->establishments_phone()->create([
            'name' => 'Daniel Marques',
            'phone' => '(41)998451-8821',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address->establishment_id,
            'establishment_address_id' => $address->id
        ]);
    }
}
