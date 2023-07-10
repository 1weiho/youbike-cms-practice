<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\News;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    // 顯示所有 menu
    public function listAll()
    {
        $collection = Menu::all();
        return view('menu-list', ['menu' => $collection]);
    }

    // 列出所有 menu 的 json
    public function index()
    {
        $collection = Menu::all();
        return response()->json($collection);
    }

    // 建立新的 menu
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:menu,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);
        Menu::create(['name' => $request->input('name')]);
        return redirect('/menu');
    }

    // 使用 id 刪除對應 menu
    public function delete($id)
    {
        $news = News::where('menu', $id)->get();
        if (count($news) > 0) {
            return redirect('/menu')->with('error', '該選單被最新消息使用無法刪除');
        }
        Menu::destroy($id);
        return redirect('/menu');
    }

    // 顯示單一 menu
    public function listOne($id)
    {
        $collection = Menu::find($id);
        return view('menu-edit', ['menu' => $collection]);
    }

    // 使用 id 更新對應 menu
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'unique:menu,name'
        ], [
            'name.unique' => '此名稱已經存在。'
        ]);
        Menu::where('_id', $id)->update(['name' => $request->input('name')]);
        return redirect('/menu');
    }
}
