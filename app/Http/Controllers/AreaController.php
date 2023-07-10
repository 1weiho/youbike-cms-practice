<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\News;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    // 顯示所有 area
    public function listAll()
    {
        $collection = Area::all();
        return view('area-list', ['area' => $collection]);
    }

    // 列出所有 area 的 json
    public function index()
    {
        $collection = Area::all();
        return response()->json($collection);
    }

    // 建立新的 area
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:area,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);

        Area::create(['name' => $request->input('name')]);
        return redirect('/area');
    }

    // 使用 id 刪除對應 area
    public function delete($id)
    {
        $areas = News::where('area', $id)->get();
        if (count($areas) > 0) {
            return redirect('/area')->with('error', '該區域被最新消息使用無法刪除');
        }
        Area::destroy($id);
        return redirect('/area');
    }

    // 顯示單一 menu
    public function listOne($id)
    {
        $collection = Area::find($id);
        return view('area-edit', ['area' => $collection]);
    }

    // 使用 id 更新對應 area
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'unique:area,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);

        Area::where('_id', $id)->update(['name' => $request->input('name')]);
        return redirect('/area');
    }
}
