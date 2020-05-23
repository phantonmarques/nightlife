<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Establishment;
use App\Models\Admin\EstablishmentStatistics;

class EstablishmentController extends Controller
{
    protected $paginate = 10;

    /**
     * Function establishment get info
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function establishment($id)
    {
        $establishment = Establishment::whereStatus(1)->with('establishment_address.city.state')
            ->with(['establishment_phones' => function ($q) {
                $q->where('main',1);
            }])->with(['establishments_photos', 'events'])->with(['ratings' => function ($q) {
                $q->limit(5);
            }])->with(['comments' => function ($q) {
                $q->limit(5);
            }])->find($id);

        $this->incrementViewEstablishment($establishment->id);

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
    public function establishmentDetails($id)
    {
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
    public function establishmentRatings($id)
    {
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
    public function establishmentComments($id)
    {
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

    /**
     * Function increments views users
     * @param $establishment
     */
    private function incrementViewEstablishment($establishment)
    {
        $statistics = EstablishmentStatistics::where('establishment_id', $establishment);
        $statistics->increment('total_views_week');
        $statistics->increment('total_views_month');
        $statistics->increment('total_views_year');
        $statistics->increment('total_views_created');
    }
}
