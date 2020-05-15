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

        # TABACARIA PRIMO - ID = 1

        $tabacariaPrimo = Establishment::where('corporate_name', 'Tabacaria Primo')->first();

        $address = new EstablishmentAddress();

        $address->zip_code = '83326500';
        $address->street_name = 'Avenida Juriti';
        $address->building_number = '322';
        $address->complement = '';
        $address->neighborhood = 'Jardim Claudia';
        $address->establishment_id = $tabacariaPrimo->id;
        $address->city_id = 4175;
        # --------------- REQUEST LOCATION -------------------
        $response = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Avenida Juriti 322 Jardim Claudia 83326-500') ))
            ->returnResponseObject()
            ->get();

        $response = json_decode($response->content);

        foreach ($response->items as $location):
            if (strpos($location->title, $address->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search = true;
            endif;
        endforeach;

        if (!isset($search) && isset($response->items)):
            $lat = $response->items[0]->position->lat;
            $lng = $response->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response->items))
            $address->location = new Point($lat, $lng);
        $address->save();
        $address->establishments_phone()->create([
            'name' => 'Mike Thomas',
            'phone' => '(41)99740-1554',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address->establishment_id,
        ]);

        # VICTORIA VILLA - ID = 2

        $victoriaVilla = Establishment::where('corporate_name', 'Victoria Villa')->first();

        $address1 = new EstablishmentAddress();

        $address1->zip_code = '82810350';
        $address1->street_name = 'Avenida Victor Ferreira do Amaral';
        $address1->building_number = '2291';
        $address1->complement = '';
        $address1->neighborhood = 'Tarumã';
        $address1->establishment_id = $victoriaVilla->id;
        $address1->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response2 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Avenida Victor Ferreira do Amaral 2291 Tarumã 82810-350') ))
            ->returnResponseObject()
            ->get();

        $response2 = json_decode($response2->content);

        foreach ($response2->items as $location):
            if (strpos($location->title, $address1->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search2 = true;
            endif;
        endforeach;

        if (!isset($search2) && isset($response2->items)):
            $lat = $response2->items[0]->position->lat;
            $lng = $response2->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response2->items))
            $address1->location = new Point($lat, $lng);
        $address1->save();
        $address1->establishments_phone()->create([
            'name' => 'Raimundo Bernardo da Cruz',
            'phone' => '(41)3365-5050',
            'main' => 1,
            'whatsapp' => 0,
            'establishment_id' => $address1->establishment_id,
        ]);

        # Danghai Club - ID = 3

        $danghai = Establishment::where('corporate_name', 'Danghai Club')->first();

        $address2 = new EstablishmentAddress();

        $address2->zip_code = '80420000';
        $address2->street_name = 'Rua Comendador Araújo';
        $address2->building_number = '609';
        $address2->complement = '';
        $address2->neighborhood = 'Batel';
        $address2->establishment_id = $danghai->id;
        $address2->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response3 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Rua Comendador Araújo 609 Batel 80420-000') ))
            ->returnResponseObject()
            ->get();

        $response3 = json_decode($response3->content);

        foreach ($response3->items as $location):
            if (strpos($location->title, $address2->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search3 = true;
            endif;
        endforeach;

        if (!isset($search3) && isset($response3->items)):
            $lat = $response3->items[0]->position->lat;
            $lng = $response3->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response3->items))
            $address2->location = new Point($lat, $lng);
        $address2->save();
        $address2->establishments_phone()->create([
            'name' => 'Vitor Caleb Eduardo Lopes',
            'phone' => '(41)3015-9985',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address2->establishment_id,
        ]);

        # Park Art - ID = 4

        $parkArt = Establishment::where('corporate_name', 'Park Art')->first();

        $address3 = new EstablishmentAddress();

        $address3->zip_code = '83322210';
        $address3->street_name = 'Avenida Iraí';
        $address3->building_number = '1700';
        $address3->complement = '';
        $address3->neighborhood = 'Weissópolis';
        $address3->establishment_id = $parkArt->id;
        $address3->city_id = 4175;
        # --------------- REQUEST LOCATION -------------------
        $response4 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Avenida Iraí 1700 Weissópolis 83322-210') ))
            ->returnResponseObject()
            ->get();

        $response4 = json_decode($response4->content);

        foreach ($response4->items as $location):
            if (strpos($location->title, $address3->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search4 = true;
            endif;
        endforeach;

        if (!isset($search4) && isset($response4->items)):
            $lat = $response4->items[0]->position->lat;
            $lng = $response4->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response4->items))
            $address3->location = new Point($lat, $lng);
        $address3->save();
        $address3->establishments_phone()->create([
            'name' => 'Bruno Anthony Igor Carvalho',
            'phone' => '(41)2101-8375',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address3->establishment_id,
        ]);

        # Blood Rock - ID = 5

        $bloodRock = Establishment::where('corporate_name', 'Blood Rock')->first();

        $address4 = new EstablishmentAddress();

        $address4->zip_code = '80510040';
        $address4->street_name = 'Rua Presidente Carlos Cavalcanti';
        $address4->building_number = '1212';
        $address4->complement = '';
        $address4->neighborhood = 'São Francisco';
        $address4->establishment_id = $bloodRock->id;
        $address4->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response5 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Rua Presidente Carlos Cavalcanti 1212 São Francisco 80510-040') ))
            ->returnResponseObject()
            ->get();

        $response5 = json_decode($response5->content);

        foreach ($response5->items as $location):
            if (strpos($location->title, $address4->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search5 = true;
            endif;
        endforeach;

        if (!isset($search5) && isset($response5->items)):
            $lat = $response5->items[0]->position->lat;
            $lng = $response5->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response5->items))
            $address4->location = new Point($lat, $lng);
        $address4->save();
        $address4->establishments_phone()->create([
            'name' => 'Marcelo José Diego Costa',
            'phone' => '(41)3029-7273',
            'main' => 1,
            'whatsapp' => 0,
            'establishment_id' => $address4->establishment_id,
        ]);

        # Tabacaria Mandela - ID = 6

        $tabacariaMandela = Establishment::where('corporate_name', 'Tabacaria Mandela')->first();

        $address5 = new EstablishmentAddress();

        $address5->zip_code = '83325342';
        $address5->street_name = 'Avenida Jacarezinho';
        $address5->building_number = '1911';
        $address5->complement = '';
        $address5->neighborhood = 'Alto Tarumã';
        $address5->establishment_id = $tabacariaMandela->id;
        $address5->city_id = 4175;
        # --------------- REQUEST LOCATION -------------------
        $response6 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Avenida Jacarezinho 1911 Alto Tarumã 83325-342') ))
            ->returnResponseObject()
            ->get();

        $response6 = json_decode($response6->content);

        foreach ($response6->items as $location):
            if (strpos($location->title, $address5->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search6 = true;
            endif;
        endforeach;

        if (!isset($search6) && isset($response6->items)):
            $lat = $response6->items[0]->position->lat;
            $lng = $response6->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response6->items))
            $address5->location = new Point($lat, $lng);
        $address5->save();
        $address5->establishments_phone()->create([
            'name' => 'Severino Osvaldo Moura',
            'phone' => '(41)3557-7590',
            'main' => 1,
            'whatsapp' => 0,
            'establishment_id' => $address5->establishment_id,
        ]);

        # Millenium Disco Club - ID = 7

        $millenium = Establishment::where('corporate_name', 'Millenium Disco Club')->first();

        $address6 = new EstablishmentAddress();

        $address6->zip_code = '83323410';
        $address6->street_name = 'Rod. Dep. João Lepoldo Jacomel';
        $address6->building_number = '12329';
        $address6->complement = '';
        $address6->neighborhood = 'Centro';
        $address6->establishment_id = $millenium->id;
        $address6->city_id = 4175;
        # --------------- REQUEST LOCATION -------------------
        $response7 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Rod. Dep. João Lepoldo Jacomel 12329 Centro 83323-410') ))
            ->returnResponseObject()
            ->get();

        $response7 = json_decode($response7->content);

        foreach ($response7->items as $location):
            if (strpos($location->title, $address6->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search7 = true;
            endif;
        endforeach;

        if (!isset($search7) && isset($response7->items)):
            $lat = $response7->items[0]->position->lat;
            $lng = $response7->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response7->items))
            $address6->location = new Point($lat, $lng);
        $address6->save();
        $address6->establishments_phone()->create([
            'name' => 'Bryan Caio Aragão',
            'phone' => '(41)99267-6637',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address6->establishment_id,
        ]);

        # Doiszerodois - ID = 8

        $doisZeroDois = Establishment::where('corporate_name', 'Doiszerodois')->first();

        $address7 = new EstablishmentAddress();

        $address7->zip_code = '83323410';
        $address7->street_name = 'Rod. Dep. João Lepoldo Jacomel';
        $address7->building_number = '12290';
        $address7->complement = '';
        $address7->neighborhood = 'Centro';
        $address7->establishment_id = $doisZeroDois->id;
        $address7->city_id = 4175;
        # --------------- REQUEST LOCATION -------------------
        $response8 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Rod. Dep. João Lepoldo Jacomel 12290 Centro 83323-410') ))
            ->returnResponseObject()
            ->get();

        $response8 = json_decode($response8->content);

        foreach ($response8->items as $location):
            if (strpos($location->title, $address7->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search8 = true;
            endif;
        endforeach;

        if (!isset($search8) && isset($response8->items)):
            $lat = $response8->items[0]->position->lat;
            $lng = $response8->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response8->items))
            $address7->location = new Point($lat, $lng);
        $address7->save();
        $address7->establishments_phone()->create([
            'name' => 'Ian Theo Caio Aragão',
            'phone' => '(41)99794-4827',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address7->establishment_id,
        ]);

        # Rodeo Country Bar - ID = 9

        $rodeo = Establishment::where('corporate_name', 'Rodeo Country Bar')->first();

        $address8 = new EstablishmentAddress();

        $address8->zip_code = '82590300';
        $address8->street_name = 'Av Linha verde';
        $address8->building_number = '4100';
        $address8->complement = '';
        $address8->neighborhood = 'Bacacheri';
        $address8->establishment_id = $rodeo->id;
        $address8->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response9 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Av Linha verde 4100 Bacacheri') ))
            ->returnResponseObject()
            ->get();

        $response9 = json_decode($response9->content);

        foreach ($response9->items as $location):
            if (strpos($location->title, $address8->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search9 = true;
            endif;
        endforeach;

        if (!isset($search9) && isset($response9->items)):
            $lat = $response9->items[0]->position->lat;
            $lng = $response9->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response9->items))
            $address8->location = new Point($lat, $lng);
        $address8->save();
        $address8->establishments_phone()->create([
            'name' => 'Iago Kevin Novaes',
            'phone' => '(41)3352-1500',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address8->establishment_id,
        ]);

        # Havana Bar - ID = 10

        $havanaBar = Establishment::where('corporate_name', 'Havana Bar')->first();

        $address9 = new EstablishmentAddress();

        $address9->zip_code = '80215901';
        $address9->street_name = 'R. Imac. Conceição';
        $address9->building_number = '1206';
        $address9->complement = '';
        $address9->neighborhood = 'Prado Velho';
        $address9->establishment_id = $havanaBar->id;
        $address9->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response10 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('R. Imac. Conceição 1206 Prado Velho 80215-901') ))
            ->returnResponseObject()
            ->get();

        $response10 = json_decode($response10->content);

        foreach ($response10->items as $location):
            if (strpos($location->title, $address9->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search10 = true;
            endif;
        endforeach;

        if (!isset($search10) && isset($response10->items)):
            $lat = $response10->items[0]->position->lat;
            $lng = $response10->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response10->items))
            $address9->location = new Point($lat, $lng);
        $address9->save();
        $address9->establishments_phone()->create([
            'name' => 'Edson Lucca Figueiredo',
            'phone' => '(41)3079-3187',
            'main' => 1,
            'whatsapp' => 0,
            'establishment_id' => $address9->establishment_id,
        ]);

        # Peppers - ID = 11

        $peppers = Establishment::where('corporate_name', 'Peppers')->first();

        $address10 = new EstablishmentAddress();

        $address10->zip_code = '80510040';
        $address10->street_name = 'Rua Presidente Carlos Cavalcanti';
        $address10->building_number = '1122';
        $address10->complement = '';
        $address10->neighborhood = 'São Francisco';
        $address10->establishment_id = $peppers->id;
        $address10->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response11 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Rua Presidente Carlos Cavalcanti 1122 São Francisco 80510-040') ))
            ->returnResponseObject()
            ->get();

        $response11 = json_decode($response11->content);

        foreach ($response11->items as $location):
            if (strpos($location->title, $address10->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search11 = true;
            endif;
        endforeach;

        if (!isset($search11) && isset($response11->items)):
            $lat = $response11->items[0]->position->lat;
            $lng = $response11->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response11->items))
            $address10->location = new Point($lat, $lng);
        $address10->save();
        $address10->establishments_phone()->create([
            'name' => 'Tiago Levi Aparício',
            'phone' => '(41)99972-0776',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address10->establishment_id,
        ]);

        # James Bar - ID = 12

        $jamesBar = Establishment::where('corporate_name', 'James Bar')->first();

        $address11 = new EstablishmentAddress();

        $address11->zip_code = '80430180';
        $address11->street_name = 'Alameda Dr. Carlos de Carvalho';
        $address11->building_number = '680';
        $address11->complement = '';
        $address11->neighborhood = 'Centro';
        $address11->establishment_id = $jamesBar->id;
        $address11->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response12 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Alameda Dr. Carlos de Carvalho 680 Centro 80430-180') ))
            ->returnResponseObject()
            ->get();

        $response12 = json_decode($response12->content);

        foreach ($response12->items as $location):
            if (strpos($location->title, $address11->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search12 = true;
            endif;
        endforeach;

        if (!isset($search12) && isset($response12->items)):
            $lat = $response12->items[0]->position->lat;
            $lng = $response12->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response12->items))
            $address11->location = new Point($lat, $lng);
        $address11->save();
        $address11->establishments_phone()->create([
            'name' => 'Lúcia Alice Pinto',
            'phone' => '(41)3222-1426',
            'main' => 1,
            'whatsapp' => 0,
            'establishment_id' => $address11->establishment_id,
        ]);

        # Shed Bar - ID = 13

        $shedBar = Establishment::where('corporate_name', 'Shed Bar')->first();

        $address12 = new EstablishmentAddress();

        $address12->zip_code = '80440080';
        $address12->street_name = 'R. Bpo. Dom José';
        $address12->building_number = '2258';
        $address12->complement = '';
        $address12->neighborhood = 'Batel';
        $address12->establishment_id = $shedBar->id;
        $address12->city_id = 4004;
        # --------------- REQUEST LOCATION -------------------
        $response13 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('R. Bpo. Dom José 2258 Batel 80440-080') ))
            ->returnResponseObject()
            ->get();

        $response13 = json_decode($response13->content);

        foreach ($response13->items as $location):
            if (strpos($location->title, $address12->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search13 = true;
            endif;
        endforeach;

        if (!isset($search13) && isset($response13->items)):
            $lat = $response13->items[0]->position->lat;
            $lng = $response13->items[0]->position->lng;
        endif;
        sleep(5);
        # ----------------------------------------------------
        if (isset($response13->items))
            $address12->location = new Point($lat, $lng);
        $address12->save();
        $address12->establishments_phone()->create([
            'name' => 'Osvaldo Manuel Anthony Assis',
            'phone' => '(41)3022-7700',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address12->establishment_id,
        ]);

        # Shed Bar - ID = 14

        $address13 = new EstablishmentAddress();

        $address13->zip_code = '88330036';
        $address13->street_name = 'Av. Atlântica';
        $address13->building_number = '5650';
        $address13->complement = '';
        $address13->neighborhood = 'Centro';
        $address13->establishment_id = $shedBar->id;
        $address13->city_id = 4336;
        # --------------- REQUEST LOCATION -------------------
        $response14 = Curl::to($this->urlMaps)
            ->withData(array(
                'apiKey' => $this->keyMaps,
                'q' => ('Av. Atlântica 5650 Centro 88330-036') ))
            ->returnResponseObject()
            ->get();

        $response14 = json_decode($response14->content);

        foreach ($response14->items as $location):
            if (strpos($location->title, $address13->building_number)!==FALSE):
                $lat = $location->position->lat;
                $lng = $location->position->lng;
                $search14 = true;
            endif;
        endforeach;

        if (!isset($search14) && isset($response14->items)):
            $lat = $response14->items[0]->position->lat;
            $lng = $response14->items[0]->position->lng;
        endif;
        # ----------------------------------------------------
        if (isset($response14->items))
            $address13->location = new Point($lat, $lng);
        $address13->save();
        $address13->establishments_phone()->create([
            'name' => 'Vania Souza',
            'phone' => '(47)3264-2607',
            'main' => 1,
            'whatsapp' => 1,
            'establishment_id' => $address13->establishment_id,
        ]);



    }
}
