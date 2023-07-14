<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolePermissionRequest;
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
            'role_name' => 'unique:role_permission|min:3|max:15',
        ], [
            'role_name.unique' => '角色名稱已存在',
            'role_name.min' => '角色名稱最少3個字',
            'role_name.max' => '角色名稱最多15個字',
        ]);

        $collection = RolePermission::find($id);
        $collection->update($request->all());

        return response()->json(['message' => 'Role permission updated successfully', 'status' => 200]);
    }

    public function destroy($id)
    {
        RolePermission::destroy($id);
        return response()->json(['message' => 'Role Permission deleted successfully', 'status' => 200]);
    }
}
