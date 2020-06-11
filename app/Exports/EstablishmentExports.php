<?php

namespace App\Exports;

use App\Models\Admin\Establishment;
use App\Models\Site\UserRating;
use App\Models\Site\UserComment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EstablishmentExports implements FromView
{
    /**
     * @return array
     */
    public function view(): View
    {
        if (!empty(auth()->user()->establishment_connect))
            $id = auth()->user()->establishment_connect;
        elseif (auth()->user()->establishments()->count() > 0)
            $id = auth()->user()->establishments->id;

        if (empty($id) && auth()->user()->can('manage-called'))
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Conecte em algum estabelecimento para realizar alterações, em seguida tente novamente!');

        return view('admin.reports.excel', [
            'establishment' => Establishment::where('id', $id)->get(),
            'ratings' => UserRating::where('establishment_id', $id)->get(),
            'comments' => UserComment::where('establishment_id', $id)->get()
        ]);
    }
}
