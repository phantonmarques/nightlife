<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\User;


class UserSettings extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'profile_path',
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
     * Get user of user_settings (USER COMMON)
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
