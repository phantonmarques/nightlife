<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get permissions of role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
}
