<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'favorite_categorys',
        'favorite_rhythms',
        'user_id'
    ];

    /**
     * @var array $casts
     */
    protected $casts = [
        'favorite_categorys' => 'array',
        'favorite_rhythms' => 'array'
    ];

    /**
     * @var array $hidden
     */
    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get user of user_settings (USER COMMON)
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
