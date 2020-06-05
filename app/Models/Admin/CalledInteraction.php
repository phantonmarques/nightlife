<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\User;

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

    /**
     * Get establishment of called
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    /**
     * Get user of interaction
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
