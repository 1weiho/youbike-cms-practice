<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Menu;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    // list all news
    public function index()
    {
        $collection = News::all();
        // query menu id to menu name
        foreach ($collection as $key => $value) {
            $menu = Menu::find($value['menu']);
            $collection[$key]['menu'] = $menu['name'];
        }
        // query area id to area name
        foreach ($collection as $key => $value) {
            $area = [];
            foreach ($value['area'] as $areaId) {
                $areaName = Area::find($areaId);
                array_push($area, $areaName['name']);
            }
            $collection[$key]['area'] = $area;
        }
        return response()->json($collection);
    }

    // add new news
    public function store(Request $request)
    {
        $areaString = $request->input('area');
        if ($areaString == '') {
            $area = [];
        } else {
            $area = explode(',', $areaString);
        }
        $menu = $request->input('menu');
        $start_at = $request->input('start_at');
        $end_at = $request->input('end_at');
        $status = $request->input('status');
        $title = $request->input('title');
        $content = $request->input('content');

        try {
            $validated = $request->validate([
                'area' => ['required'],
                'menu' => ['required'],
                'start_at' => ['required', 'date'],
                'end_at' => ['required', 'date', 'after:start_at'],
                'status' => ['required', 'numeric', Rule::in([0, 1])],
                'title' => ['required'],
                'content' => ['required'],
            ], [
                'area.required' => '請填入區域',
                'menu.required' => '請填入選單',
                'start_at.required' => '請填入開始時間',
                'start_at.date' => '開始時間必須是一個有效日期',
                'end_at.required' => '請填入結束時間',
                'end_at.date' => '結束時間必須是一個有效日期',
                'end_at.after' => '結束時間必須大於開始時間',
                'status.required' => '請填入狀態',
                'status.numeric' => '狀態必須是顯示或隱藏',
                'status.in' => '狀態必須是顯示或隱藏',
                'title.required' => '請填入標題',
                'content.required' => '請填入內容',
            ]);
            News::create(['area' => $area, 'menu' => $menu, 'start_at' => $start_at, 'end_at' => $end_at, 'status' => $status, 'title' => $title, 'content' => $content]);
            return response()->json(['status' => 'success', 'message' => 'News added successfully!']);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['status' => 'error', 'message' => $errors[0]], 422);
        }
    }

    // show a news by id
    public function show($id)
    {
        $collection = News::find($id);
        // query area id to area name save id and name
        $area = [];
        foreach ($collection['area'] as $areaId) {
            $areaName = Area::find($areaId);
            array_push($area, ['id' => $areaId, 'name' => $areaName['name']]);
        }
        $collection['area'] = $area;
        return response()->json($collection);
    }

    // edit a news by id
    public function update(Request $request, $id)
    {
        $areaString = $request->input('area');
        if ($areaString == '') {
            $area = [];
        } else {
            $area = explode(',', $areaString);
        }
        $menu = $request->input('menu');
        $start_at = $request->input('start_at');
        $end_at = $request->input('end_at');
        $status = $request->input('status');
        $title = $request->input('title');
        $content = $request->input('content');

        if (
            empty($area) ||
            empty($menu) ||
            empty($start_at) ||
            empty($end_at) ||
            ($status != 0 && $status != 1) ||
            empty($title) ||
            empty($content)
        ) {
            return response()->json(['status' => 'error', 'message' => '請填入所有欄位'], 422);
        }

        try {
            $validated = $request->validate([
                'start_at' => ['required', 'date'],
                'end_at' => ['required', 'date', 'after:start_at'],
            ], [
                'end_at.after' => '結束時間必須大於開始時間。',
            ]);
            News::where('_id', $id)->update(['area' => $area, 'menu' => $menu, 'start_at' => $start_at, 'end_at' => $end_at, 'status' => $status, 'title' => $title, 'content' => $content]);
            return response()->json(['status' => 'success', 'message' => 'News updated successfully!']);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['status' => 'error', 'message' => $errors[0]], 422);
        }
    }

    // delete a news by id
    public function destroy($id)
    {
        News::destroy($id);
        return response()->json(['status' => 'success', 'message' => 'News deleted successfully!']);
    }
}
