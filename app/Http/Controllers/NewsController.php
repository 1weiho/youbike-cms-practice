<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    // list all news
    public function index(Request $request)
    {
        $query = News::query();
        $perPage = 10;

        if ($request->has('menuId')) {
            $menu = $request->input('menuId');
            $query->where('menu_id', '=', $menu);
        }

        if ($request->has('areaId')) {
            $area = $request->input('areaId');
            $query->where('area_id', '=', $area);
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('status', '=', $status);
        }

        if ($request->has('title')) {
            $title = $request->input('title');
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($request->has('perPage')) {
            $perPage = $request->input('perPage');
        }

        $collection = $query->paginate($perPage);

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

        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = '';
        }

        try {
            News::create([
                'area_id' => $area,
                'menu_id' => $menu,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'status' => $status,
                'title' => $title,
                'content' => $content,
                'cover' => $imageName
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
    public function modify(NewsRequest $request, $id)
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

        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = News::find($id)->cover;
        }

        try {
            News::where('_id', $id)->update([
                'area_id' => $area,
                'menu_id' => $menu,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'status' => $status,
                'title' => $title,
                'content' => $content,
                'cover' => $imageName
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
