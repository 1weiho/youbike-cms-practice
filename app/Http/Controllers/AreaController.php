<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Area;
use App\Models\News;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    // 顯示所有 area
    public function listAll()
    {
        try {
            $this->authorize('viewAny', Area::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        $userId = auth()->user()->_id;
        $role_permission_id = Admin::where('_id', $userId)->first()->role_permission_id;
        $area_permission_id = RolePermission::where('_id', $role_permission_id)->first()->area_permission_id;
        $collection = Area::whereIn('_id', $area_permission_id)->get();
        return view('area-list', ['area' => $collection]);
    }

    // 列出所有 area 的 json
    public function index()
    {
        // 過濾使用者可以看到的區域
        $userId = auth()->user()->_id;
        $role_permission_id = Admin::where('_id', $userId)->first()->role_permission_id;
        $area_permission_id = RolePermission::where('_id', $role_permission_id)->first()->area_permission_id;
        $role_name = RolePermission::where('_id', $role_permission_id)->first()->role_name;
        if ($role_name == "系統管理者") {
            $collection = Area::all();
        } else {
            $collection = Area::whereIn('_id', $area_permission_id)->get();
        }
        return response()->json($collection);
    }

    // 建立新的 area
    public function create(Request $request)
    {
        try {
            $this->authorize('create', Area::class);
        } catch (\Throwable $th) {
            return redirect()->route('area.list')->with('error', __('lang.permissionDenied'));
        }
        $validated = $request->validate([
            'name' => 'unique:area,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);

        Area::create(['name' => $request->input('name')]);
        return redirect()->route('area.list');
    }

    // 使用 id 刪除對應 area
    public function delete($id)
    {
        try {
            $this->authorize('delete', Area::class);
        } catch (\Throwable $th) {
            return redirect()->route('area.list')->with('error', __('lang.permissionDenied'));
        }
        $newsCount = News::where('area_id', $id)->count();
        if ($newsCount > 0) {
            return redirect()->route('area.list')->with('error', '該區域被最新消息使用無法刪除');
        }
        Area::destroy($id);
        return redirect()->route('area.list');
    }

    // 顯示單一 menu
    public function listOne($id)
    {
        try {
            $this->authorize('viewAny', Area::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        $collection = Area::find($id);
        return view('area-edit', ['area' => $collection]);
    }

    // 使用 id 更新對應 area
    public function update(Request $request, $id)
    {
        try {
            $this->authorize('update', Area::class);
        } catch (\Throwable $th) {
            return redirect()->route('area.list')->with('error', __('lang.permissionDenied'));
        }
        $validated = $request->validate([
            'name' => 'unique:area,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);

        Area::where('_id', $id)->update(['name' => $request->input('name')]);
        return redirect()->route('area.list');
    }
}
