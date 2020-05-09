<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Establishment;

class EstablishmentController extends Controller
{
    protected $paginate = 10;

    /**
     * Function establishment get details and info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishmentDetails($id){
        $establishment = Establishment::with('establishment_address.city.state')
                            ->with(['establishment_phones' => function ($q) {
                                $q->where('main',1);
                            }])->with('establishments_photos')
                            ->find($id);

        if (isset($establishment->corporate_name)):
            return response()->json([
                'status' => true,
                'data' => array(
                    "establishment" => $establishment,
                )
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }

}
