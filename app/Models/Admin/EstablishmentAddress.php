<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\City;

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
        'city_id'
    ];

    /**
     * Get establishments of establishmentaddress.
     */
    public function establishment(){
        return $this->belongsTo(Establishment::class, 'establishment_id', 'id');
    }

    /**
     * Get phones of establishmentaddress.
     */
    public function establishments_phone(){
        return $this->hasMany(EstablishmentPhones::class, 'establishment_address_id');
    }

    /**
     * Get citys of establishmentaddress.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
