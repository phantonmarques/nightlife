<?php

namespace App\Models\Admin\Traits;

use App\Models\Admin\Role;
use App\Models\Admin\Permission;

trait HasRolesAndPermissions
{
    /**
     * Get roles of users
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * Get permissions of users
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    /**
     * Verify role users
     * @return boolean
     */
    public function hasRole($roles ) {
        if (is_array($roles)) :
            foreach ($roles as $role):
                if ($this->roles->contains('slug', $role))
                    return true;

            endforeach;

        else:
            if ($this->roles->contains('slug', $roles))
                return true;

        endif;

        return false;
    }

    /**
     * Verify permission users
     * @return boolean
     */
    public function hasPermission($permission)
    {
        if (is_object($permission))
            return (bool) $this->permissions->where('slug', $permission->slug)->count();
        else
            return (bool) $this->permissions->where('slug', $permission)->count();
    }


    /**
     * Verify permissions users
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Verify permissions contain for users
     * @return boolean
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all permissions exists
     * @return array
     */
    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    /**
     * Get permission selected
     * @return object
     */
    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * Delete permissions all permissions
     * @return object
     */
    public function deletePermissions(... $permissions )
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * Update all permissions
     * @return object
     */
    public function refreshPermissions(... $permissions )
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}