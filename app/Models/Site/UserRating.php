<?php

namespace App\Models\Site;

use App\Models\Admin\Establishment;
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
        'author',
        'rating',
        'establishment_id',
        'user_id',
    ];

    /**
     * @var array $hidden
     */
    protected $hidden = [
        'user_id',
        'establishment_id',
        'updated_at',
    ];

    /**
     * Get user of user_settings (USER COMMON)
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get establishment
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
}
