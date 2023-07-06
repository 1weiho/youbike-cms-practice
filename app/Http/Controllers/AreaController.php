<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Rules\UniqueArea;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    // list all area
    public function listAll()
    {
        $areaModel = new Area();
        $collection = $areaModel->list();
        return view('area-list', ['area' => $collection]);
    }

    // add new area
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', new UniqueArea],
        ]);
        $areaModel = new Area();
        $areaModel->add($request->input('name'));
        return redirect('/area');
    }

    // delete a area by id
    public function delete($id)
    {
        $areaModel = new Area();
        $areaModel->deleteById($id);
        return redirect('/area');
    }

    // edit a area by id
    public function edit($id)
    {
        $areaModel = new Area();
        $collection = $areaModel->getById($id);
        return view('area-edit', ['area' => $collection]);
    }

    // update a area by id
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', new UniqueArea],
        ]);
        $areaModel = new Area();
        $areaModel->updateById($id, $request->input('name'));
        return redirect('/area');
    }
}
