<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\City;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class EstablishmentAddress extends Model
{
    use SpatialTrait;

    /**
     * @var string $table
     */
    protected $table = 'establishment_address';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'establishment_id',
        'zip_code',
        'street_name',
        'building_number',
        'complement',
        'location',
        'neighborhood',
        'city_id'
    ];

    /**
     * @var array $spatialFields
     */
    protected $spatialFields = [
        'location',
    ];
    /**
     * Get establishments of establishmentaddress.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id', 'id');
    }

    /**
     * Get phones of establishmentaddress.
     */
    public function establishments_phone()
    {
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
