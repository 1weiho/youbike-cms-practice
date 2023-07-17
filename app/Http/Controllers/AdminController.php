<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // show admin list page
    public function listPage()
    {
        try {
            $this->authorize('viewAny', Admin::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('admin-list')->with('lang', json_encode(__('lang')));
    }

    // show admin add page
    public function addPage()
    {
        try {
            $this->authorize('create', Admin::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('admin-add')->with('lang', json_encode(__('lang')));
    }

    // show admin edit page
    public function editPage()
    {
        try {
            $this->authorize('update', Admin::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('admin-edit')->with('lang', json_encode(__('lang')));
    }

    public function resetPasswordPage()
    {
        try {
            $this->authorize('update', Admin::class);
        } catch (\Throwable $th) {
            return redirect()->route('admin.login');
        }
        return view('admin-reset-password')->with('lang', json_encode(__('lang')));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 檢查使用者是否有權限查看
        try {
            $this->authorize('viewAny', Admin::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        $canUpdate = $this->checkUpdatePermission();
        $canDelete = $this->checkDeletePermission();
        $collection = Admin::all();

        foreach ($collection as $key => $value) {
            $collection[$key]['role_permission'] = $value->role_permission();
        }

        foreach ($collection as $key => $value) {
            unset($collection[$key]['role_permission_id']);
        }

        return response()->json([
            'data' => $collection,
            'canUpdate' => $canUpdate,
            'canDelete' => $canDelete,
        ]);
    }

    private function checkUpdatePermission()
    {
        try {
            $this->authorize('update', Admin::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function checkDeletePermission()
    {
        try {
            $this->authorize('delete', Admin::class);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminRequest $request)
    {
        // 檢查使用者是否有權限新增
        try {
            $this->authorize('create', Admin::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        Admin::create($request->all());
        return response()->json(['message' => 'Admin created successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 檢查使用者是否有權限查看
        try {
            $this->authorize('viewAny', Admin::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        $collection = Admin::find($id);
        $collection['role_permission'] = $collection->role_permission();
        unset($collection['role_permission_id']);
        return response()->json($collection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, $id)
    {
        // 檢查使用者是否有權限更新
        try {
            $this->authorize('update', Admin::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        // reject updating password, username, return error
        if ($request->has('password') || $request->has('username')) {
            return response()->json(['message' => '帳號及密碼無法修改'], 400);
        }
        Admin::find($id)->update($request->all());
        return response()->json(['message' => 'Admin updated successfully', 'status' => 200]);
    }

    public function resetPassword(ResetPasswordRequest $request, $id)
    {
        $admin = Admin::find($id);

        $request->merge(['password' => bcrypt($request->password)]);
        $admin->password = $request->password;
        $admin->save();
        return response()->json(['message' => 'Admin password reset successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 檢查使用者是否有權限刪除
        try {
            $this->authorize('delete', Admin::class);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => __('lang.permissionDenied')], 403);
        }

        Admin::destroy($id);
        return response()->json(['message' => 'Admin deleted successfully', 'status' => 200]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => '請填入帳號',
            'password.required' => '請填入密碼',
        ]);
        $credentials = $request->only('username', 'password');

        if (Admin::where('username', $credentials['username'])->value('status') == 0) {
            return redirect()->back()->withErrors(['username' => '帳號已被停用'])->withInput($request->except('password'));
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            if (Admin::where('username', $credentials['username'])->exists()) {
                return redirect()->back()->withErrors(['password' => '密碼錯誤'])->withInput($request->except('password'));
            } else {
                return redirect()->back()->withErrors(['username' => '帳號不存在'])->withInput($request->except('password'));
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
