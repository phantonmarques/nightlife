<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Establishment;
use App\Models\Admin\EstablishmentAddress;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Ixudra\Curl\Facades\Curl;


class EstablishmentAddressTableSeeder extends Seeder
{
    protected $keyMaps = '5r2Oz1paGAA_xfzWLlIcjpQq4DZPwMD4iPV5_mTP9m8';
    protected $urlMaps = 'https://geocode.search.hereapi.com/v1/geocode';


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
        # --------------- REQUEST LOCATION -------------------
        $response = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => urlencode('Rua Francisco Eugênio Gomes Pereira 245 Atuba')))
            ->returnResponseObject()
            ->get();

        $response = json_decode($response->content);
        # ----------------------------------------------------
        $address->location = new Point($response->items[0]->position->lat, $response->items[0]->position->lng);
        $address->save();
        $address->establishments_phone()->create([
            'name' => 'Daniel Marques',
            'phone' => '(41)998451-8821',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address->establishment_id,
        ]);
    }
}
