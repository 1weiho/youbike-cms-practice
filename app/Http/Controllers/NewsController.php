<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\Admin;
use App\Models\News;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    // show news list page
    public function listPage()
    {
        try {
            $this->authorize('viewAny', News::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('news-list')->with('lang', json_encode(__('lang')));
    }

    // show news add page
    public function addPage()
    {
        try {
            $this->authorize('create', News::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('news-add')->with('lang', json_encode(__('lang')));
    }

    // show news edit page
    public function editPage()
    {
        try {
            $this->authorize('update', News::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('news-edit')->with('lang', json_encode(__('lang')));
    }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', News::class);

            $canUpdate = $this->checkUpdatePermission();
            $canDelete = $this->checkDeletePermission();

            $collection = $this->getNewsData($request);

            return response()->json([
                'data' => $collection,
                'canUpdate' => $canUpdate,
                'canDelete' => $canDelete,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }
    }

    private function checkUpdatePermission()
    {
        try {
            $this->authorize('update', News::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function checkDeletePermission()
    {
        try {
            $this->authorize('delete', News::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function getNewsData(Request $request)
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

        // 過濾使用者可以看到的區域
        $userId = auth()->user()->_id;
        $role_permission_id = Admin::where('_id', $userId)->first()->role_permission_id;
        $area_permission_id = RolePermission::where('_id', $role_permission_id)->first()->area_permission_id;
        $query->whereIn('area_id', $area_permission_id);

        $collection = $query->paginate($perPage);

        // add $collection[]->area and $collection[]->menu to $collection
        foreach ($collection as $key => $value) {
            $collection[$key]['area'] = $value->area();
            $collection[$key]['menu'] = $value->menu();
        }

        return $collection;
    }

    // add new news
    public function store(NewsRequest $request)
    {
        // 檢查使用者是否有新增權限
        try {
            $this->authorize('create', News::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }
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
        // 檢查使用者是否有讀取權限
        try {
            $this->authorize('viewAny', News::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }
        $collection = News::find($id);
        $collection['area'] = $collection->area();
        $collection['menu'] = $collection->menu();
        return response()->json($collection);
    }

    // edit a news by id
    public function modify(NewsRequest $request, $id)
    {
        // 檢查使用者是否有更新權限
        try {
            $this->authorize('update', News::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

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
        // 檢查使用者是否有刪除權限
        try {
            $this->authorize('delete', News::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        News::destroy($id);
        return response()->json(['status' => 'success', 'message' => 'News deleted successfully!']);
    }
}
