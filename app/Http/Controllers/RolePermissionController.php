<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = RolePermission::all();
        foreach ($collection as $key => $value) {
            $collection[$key]['area_permission'] = $value->area_permission();
            $collection[$key]['account'] = $value->account();
        }

        foreach ($collection as $key => $value) {
            unset($collection[$key]['area_permission_id']);
        }

        return response()->json($collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RolePermission::create($request->all());
        return response()->json(['message' => 'Role permission created successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = RolePermission::find($id);

        return response()->json($collection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function edit(RolePermission $rolePermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collection = RolePermission::find($id);
        $collection->update($request->all());

        return response()->json(['message' => 'Role permission updated successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RolePermission::destroy($id);
        return response()->json(['message' => 'Role Permission deleted successfully', 'status' => 200]);
    }
}
