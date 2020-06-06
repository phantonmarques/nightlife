<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class UserLiked extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_liked';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'establishment_id',
        'event_id',
        'user_id',
    ];

}
