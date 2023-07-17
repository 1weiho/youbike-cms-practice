<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\RolePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['role_permission']['read'];
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, RolePermission $rolePermission)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['role_permission']['create'];
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['role_permission']['update'];
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['role_permission']['delete'];
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, RolePermission $rolePermission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, RolePermission $rolePermission)
    {
        //
    }
}
