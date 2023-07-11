<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
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

        // add $collection[]->area and $collection[]->menu to $collection
        foreach ($collection as $key => $value) {
            $collection[$key]['area'] = $value->area();
            $collection[$key]['menu'] = $value->menu();
        }

        return response()->json($collection);
    }

    // add new news
    public function store(NewsRequest $request)
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
            News::create([
                'area_id' => $area,
                'menu_id' => $menu,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'status' => $status,
                'title' => $title,
                'content' => $content
            ]);
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
        $collection['area'] = $collection->area();
        $collection['menu'] = $collection->menu();
        return response()->json($collection);
    }

    // edit a news by id
    public function update(NewsRequest $request, $id)
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
            News::where('_id', $id)->update([
                'area_id' => $area,
                'menu_id' => $menu,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'status' => $status,
                'title' => $title,
                'content' => $content
            ]);
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
