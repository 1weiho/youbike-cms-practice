<?php

namespace App\Http\Controllers;

use App\Models\Logger;
use Illuminate\Http\Request;

class LoggerController extends Controller
{

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Logger::class);

            $collection = $this->getNewsData($request);

            return response()->json($collection);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }
    }

    private function getNewsData(Request $request)
    {
        $query = Logger::query();
        $perPage = 10;

        if ($request->has('username')) {
            $username = $request->input('username');
            $query->where('user', 'like', '%' . $username . '%');
        }

        if ($request->has('route')) {
            $route = $request->input('route');
            $query->where('route', 'like', '%' . $route . '%');
        }

        if ($request->has('method')) {
            $method = $request->input('method');
            $query->where('method', '=', $method);
        }

        if ($request->has('datetimes')) {
            list($startDateTime, $endDateTime) = explode(" - ", $request->input('datetimes'));

            // 將日期時間轉換為Unix時間戳
            $startTimestamp = strtotime($startDateTime);
            $endTimestamp = strtotime($endDateTime);

            // 將 Unix 時間戳轉換為 MongoDB 支持的日期格式
            $startDateTime = new \MongoDB\BSON\UTCDateTime($startTimestamp * 1000);
            $endDateTime = new \MongoDB\BSON\UTCDateTime($endTimestamp * 1000);

            // 使用 $gte 和 $lte 操作符進行日期範圍查詢
            $query->where('created_at', '>=', $startDateTime)->where('created_at', '<=', $endDateTime);
        }


        if ($request->has('perPage')) {
            $perPage = $request->input('perPage');
        }

        // order by create time
        $query->orderBy('created_at', 'desc');

        $collection = $query->paginate($perPage);

        return $collection;
    }

    public function listPage()
    {
        try {
            $this->authorize('viewAny', Logger::class);
            return view('logger-list')->with('lang', json_encode(__('lang')));
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
    }
}
