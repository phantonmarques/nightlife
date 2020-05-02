<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get roles of permissions
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
