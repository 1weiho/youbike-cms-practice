<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolePermissionRequest;
use App\Models\Admin;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    // show role permission list page
    public function listPage()
    {
        try {
            $this->authorize('viewAny', RolePermission::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('role-permission-list')->with('lang', json_encode(__('lang')));
    }

    // show role permission add page
    public function addPage()
    {
        try {
            $this->authorize('create', RolePermission::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('role-permission-add')->with('lang', json_encode(__('lang')));
    }

    // show role permission edit page
    public function editPage()
    {
        try {
            $this->authorize('update', RolePermission::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('role-permission-edit')->with('lang', json_encode(__('lang')));
    }

    public function index()
    {
        // 檢查使用者是否有權限查看
        try {
            $this->authorize('viewAny', RolePermission::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => '權限拒絕'], 403);
        }

        $canUpdate = $this->checkUpdatePermission();
        $canDelete = $this->checkDeletePermission();
        $collection = RolePermission::all();

        foreach ($collection as $key => $value) {
            $collection[$key]['area_permission'] = $value->area_permission();
            $collection[$key]['account'] = $value->account();
        }

        foreach ($collection as $key => $value) {
            unset($collection[$key]['area_permission_id']);
        }

        return response()->json([
            'data' => $collection,
            'canUpdate' => $canUpdate,
            'canDelete' => $canDelete,
        ]);
    }

    private function checkUpdatePermission()
    {
        try {
            $this->authorize('update', RolePermission::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function checkDeletePermission()
    {
        try {
            $this->authorize('delete', RolePermission::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function store(CreateRolePermissionRequest $request)
    {
        // 檢查使用者是否有權限新增
        try {
            $this->authorize('create', RolePermission::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => '權限拒絕'], 403);
        }

        RolePermission::create($request->all());
        return response()->json(['message' => 'Role permission created successfully', 'status' => 200]);
    }

    public function show($id)
    {
        // 檢查使用者是否有權限查看
        try {
            $this->authorize('viewAny', RolePermission::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => '權限拒絕'], 403);
        }

        $collection = RolePermission::find($id);

        return response()->json($collection);
    }

    public function update(Request $request, $id)
    {
        // 檢查使用者是否有權限更新
        try {
            $this->authorize('update', RolePermission::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => '權限拒絕'], 403);
        }

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
        // 檢查使用者是否有權限刪除
        try {
            $this->authorize('delete', RolePermission::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => '權限拒絕'], 403);
        }

        $adminCount = Admin::where('role_permission_id', $id)->count();
        if ($adminCount > 0) {
            return response()->json(['message' => __('lang.deleteFailByAdmin'), 'status' => 400], 400);
        }
        RolePermission::destroy($id);
        return response()->json(['message' => 'Role Permission deleted successfully', 'status' => 200]);
    }
}
