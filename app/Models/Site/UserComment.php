<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    /**
     * @var array $table
     */
    protected $table = [
        'user_comment'
    ];

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'comment',
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
