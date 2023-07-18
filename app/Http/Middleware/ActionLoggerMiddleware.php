<?php

namespace App\Http\Middleware;

use App\Models\Logger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActionLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true); // 開始時間

        $response = $next($request);

        $endTime = microtime(true); // 結束時間
        $totalTime = $endTime - $startTime;

        // 移除 request 中的檔案
        $request->files->remove('image');

        $method = $request->method();
        $status = $response->status();
        $route = $request->route()->uri();
        $apiName = $request->route()->getName();
        $requestPayload = $request->all();
        $responsePayload = $response->original;

        // 加入使用者資訊，若未登入，將 user 設為空字串
        if (auth()->user()) {
            $user = auth()->user()->name;
        } else {
            $user = '';
        }

        $extra = [
            'ua' => $request->header('User-Agent'),
            'type' => 'backendStage',
        ];

        $this->logAction($method, $status, $route, $apiName, $requestPayload, $responsePayload, $user, $totalTime, $extra);

        return $response;
    }

    private function logAction($method, $status, $route, $apiName, $request, $response, $user, $totalTime, $extra)
    {
        $logData = [
            'log_number' => uniqid(),
            'time' => now()->toDateTimeString(),
            'method' => $method,
            'status' => $status,
            'ip' => request()->ip(),
            'route' => $route,
            'api_name' => $apiName,
            'request_uri' => request()->fullUrl(),
            'referer' => request()->header('referer'),
            'request' => $request,
            'response' => $response,
            'user' => $user,
            'total_time' => $totalTime,
            'extra' => $extra,
        ];

        Log::channel('custom')->info(json_encode($logData));
        Logger::create($logData);
    }
}
