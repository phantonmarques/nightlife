<?php

namespace App\Models\Site;

use App\Models\Admin\Establishment;
use App\Models\Admin\Event;
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

    /**
     * Get the user record associated with the user liked.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the establishment record associated with the user liked.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    /**
     * Get the establishment record associated with the user liked.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }


}
