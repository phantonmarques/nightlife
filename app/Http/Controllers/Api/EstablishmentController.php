<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Establishment;
use App\Models\Admin\EstablishmentPhones;
use App\Models\Site\City;

class EstablishmentController extends Controller
{
    protected $paginate = 10;

    /**
     * Function establishment get details and info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishmentDetails($id){
        $establishment = Establishment::find($id);

        if (isset($establishment->corporate_name)):
            $addresses = $establishment->establishment_address()->select('id', 'zip_code', 'street_name', 'building_number', 'neighborhood', 'city_id')->get();

            foreach ($addresses as &$address):
                $city = City::find($address["city_id"]);
                $phone = EstablishmentPhones::where([['establishment_address_id', $address["id"]], ['main', 1]])->select('phone', 'whatsapp')->first();

                $address["city"] = $city->name_visible;
                $address["state"] = $city->state->name_visible;
                $address["phone"] = $phone;
            endforeach;

            return response()->json([
                'status' => false,
                'data' => array(
                    "establishment" => $establishment->select('id', 'corporate_name', 'details')->get(),
                    "addressses" => $addresses,
                    'photos' => $establishment->establishments_photos()->get(),
                )
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }

}
