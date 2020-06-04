<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Called extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'called';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'establishment_id',
        'user_id',
        'subject',
        'status'
    ];

    /**
     * Get phones of establishmentaddress.
     */
    public function called_interaction()
    {
        return $this->hasMany(CalledInteraction::class, 'called_id');
    }

}
