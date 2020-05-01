<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use App\Models\Site\User;
use App\Models\Admin\Establishment;

class UserAccess extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'user_access';

    /**
     * @var array $fillable
     */
    protected $fillable = ['user_id', 'class', 'establishment_connect', 'description', 'content', 'data_access'];

    /**
     * @var array $casts
     */
    protected $casts = [
        'content' => 'array',
    ];

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Get user of access log
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get establishment of access log
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_connect');
    }

}
