<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Area;
use App\Models\RolePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreaPolicy
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
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['area']['read'];
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, Area $area)
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['area']['create'];
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['area']['update'];
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin)
    {
        return RolePermission::where('_id', $admin->role_permission_id)->first()->access_permission['area']['delete'];
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, Area $area)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, Area $area)
    {
        //
    }
}
