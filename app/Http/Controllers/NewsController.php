<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Rules\EndAtGreaterThanStartAtRule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    // list all news
    public function index()
    {
        $collection = News::all();
        return response()->json($collection);
    }

    // add new news
    public function store(Request $request)
    {
        $newsModel = new News();
        $areaString = $request->input('area');
        $area = explode(',', $areaString);
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
        return response()->json($collection);
    }

    // edit a news by id
    public function update(Request $request, $id)
    {
        $newsModel = new News();
        $areaString = $request->input('area');
        $area = explode(',', $areaString);
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
