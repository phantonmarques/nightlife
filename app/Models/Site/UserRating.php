<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'user_rating';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'rating',
        'establishment_id',
        'user_id',
    ];

    /**
     * Get user of user_settings (USER COMMON)
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
