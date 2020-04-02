<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\EstablishmentPhones;
use App\Models\Admin\Establishment;

class EstablishmentAddress extends Model
{
    protected $table = 'establishment_address';

    protected $fillable = [
        'establishment_id',
        'zip_code',
        'street_name',
        'building_number',
        'complement',
        'neighborhood',
        'state_id',
        'city_id'
    ];

    public function establishment(){
        return $this->hasMany(Establishment::class, 'id', 'establishment_id');
    }

    public function establishments_phone(){
        return $this->hasMany(EstablishmentPhones::class, 'establishment_address_id');
    }
}
