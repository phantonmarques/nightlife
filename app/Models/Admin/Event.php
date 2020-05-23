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
        'start_time',
        'end_time',
        'status',
        'establishment_id',
        'establishment_address_id'
    ];

    /**
     * @var array $hidden
     */
    protected $hidden = [
        'establishment_address_id',
        'establishment_id',
        'views',
        'status',
        'created_at',
        'updated_at'
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
