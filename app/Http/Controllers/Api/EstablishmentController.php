<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Establishment;

class EstablishmentController extends Controller
{
    protected $paginate = 10;

    /**
     * Function establishment get info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishment($id){
        $establishment = Establishment::whereStatus(1)->with('establishment_address.city.state')
            ->with(['establishment_phones' => function ($q) {
                $q->where('main',1);
            }])->with(['establishments_photos', 'events'])->with(['ratings' => function ($q) {
                $q->limit(5);
            }])->with(['comments' => function ($q) {
                $q->limit(5);
            }])->find($id);

        if (isset($establishment->corporate_name)):
            return response()->json([
                'status' => true,
                'data' => $establishment
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }

    /**
     * Function establishment get details and info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishmentDetails($id){
        $establishment = Establishment::whereStatus(1)->with('establishment_address.city.state')
                            ->with(['establishment_phones' => function ($q) {
                                $q->where('main',1);
                            }])->with('establishments_photos')
                            ->find($id);

        if (isset($establishment->corporate_name)):
            return response()->json([
                'status' => true,
                'data' => $establishment
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }

    /**
     * Function establishment get ratings
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishmentRatings($id){
        $establishment = Establishment::whereStatus(1)->with('ratings')->find($id);

        if (isset($establishment->corporate_name)):
            return response()->json([
                'status' => true,
                'data' => $establishment
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }

    /**
     * Function establishment get comments
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishmentComments($id){
        $establishment = Establishment::whereStatus(1)->with('comments')->find($id);

        if (isset($establishment->corporate_name)):
            return response()->json([
                'status' => true,
                'data' => $establishment
            ]);
        endif;

        return response()->json([
            'status' => false,
            'data' => "Estabelecimento não encontrado!"
        ]);
    }
}
