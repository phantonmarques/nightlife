<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\EstablishmentAddress;

class EstablishmentPhones extends Model
{
    protected $table = 'establishments_phone';

    protected $fillable = [
        'establishment_address_id',
        'establishment_id',
        'name',
        'phone',
        'main',
        'whatsapp'
    ];

    public function establishment_address(){
        return $this->belongsTo(EstablishmentAddress::class, 'establishment_address_id');
    }
}