<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolePermissionRequest;
use App\Models\Admin;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $collection = RolePermission::all();
        foreach ($collection as $key => $value) {
            $collection[$key]['area_permission'] = $value->area_permission();
            $collection[$key]['account'] = $value->account();
        }

        foreach ($collection as $key => $value) {
            unset($collection[$key]['area_permission_id']);
        }

        return response()->json($collection);
    }

    public function store(CreateRolePermissionRequest $request)
    {
        RolePermission::create($request->all());
        return response()->json(['message' => 'Role permission created successfully', 'status' => 200]);
    }

    public function show($id)
    {
        $collection = RolePermission::find($id);

        return response()->json($collection);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'role_name' => 'min:3|max:15',
        ], [
            'role_name.min' => __('lang.role_name.min'),
            'role_name.max' => __('lang.role_name.max'),
        ]);

        $role_name = RolePermission::where('role_name', $request->role_name)->where('_id', '!=', $id)->first();
        if ($role_name) {
            return response()->json(['message' => 'Role name already exist', 'status' => 400]);
        }

        $collection = RolePermission::find($id);
        $collection->update($request->all());

        return response()->json(['message' => 'Role permission updated successfully', 'status' => 200]);
    }

    public function destroy($id)
    {
        $adminCount = Admin::where('role_permission_id', $id)->count();
        if ($adminCount > 0) {
            return response()->json(['message' => __('lang.deleteFailByAdmin'), 'status' => 400], 400);
        }
        RolePermission::destroy($id);
        return response()->json(['message' => 'Role Permission deleted successfully', 'status' => 200]);
    }
}
