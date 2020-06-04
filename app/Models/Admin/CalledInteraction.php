<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CalledInteraction extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'called_interaction';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'description',
        'situation',
        'date_service',
        'time_service',
        'visible',
        'called_id',
        'establishment_id',
        'user_id',
    ];

}
