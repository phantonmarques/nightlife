<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'event';

    /**
     * @var string $fillable
     */
    protected $fillable = [
        'name',
        'date_event',
        'price',
        'cover_path',
        'description',
        'status',
        'establishment_id',
        'establishment_address_id'
    ];

    /**
     * Get the establishment record associated with the event.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class,'establishment_id');
    }

    /**
     * Get the establishment address record associated with the event.
     */
    public function establishment_address()
    {
        return $this->belongsTo(EstablishmentAddress::class,'establishment_address_id');
    }
}
