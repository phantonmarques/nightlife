<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EstablishmentStatistics extends Model
{
    /**
     * @var string table
     */
    protected $fillable = ['establishment_id'];

    public function establishment(){
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
}
