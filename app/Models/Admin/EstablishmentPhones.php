<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\EstablishmentAddress;

class EstablishmentPhones extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'establishments_phones';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'establishment_address_id',
        'establishment_id',
        'name',
        'phone',
        'main',
        'whatsapp'
    ];

    /**
     * Get establishment address of phones establishment available
     */
    public function establishment_address()
    {
        return $this->belongsTo(EstablishmentAddress::class, 'establishment_address_id');
    }
}