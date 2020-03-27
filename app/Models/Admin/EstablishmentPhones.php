<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EstablishmentPhones extends Model
{
    protected $table = 'establishments_phone';

    protected $fillable = [
        'name',
        'phone',
        'main',
        'whatsapp'
    ];
}
