<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Rules\UniqueMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Client;

class MenuController extends Controller
{

    // list all menu
    public function listAll()
    {
        $menuModel = new Menu();
        $collection = $menuModel->list();
        return view('menu-list', ['menu' => $collection]);
    }

    // add new menu
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', new UniqueMenu],
        ]);
        $menuModel = new Menu();
        $menuModel->add($request->input('name'));
        return redirect('/menu');
    }

    // delete a menu by id
    public function delete($id)
    {
        $menuModel = new Menu();
        $menuModel->deleteById($id);
        return redirect('/menu');
    }

    // edit a menu by id
    public function edit($id)
    {
        $menuModel = new Menu();
        $collection = $menuModel->getById($id);
        return view('menu-edit', ['menu' => $collection]);
    }

    // update a menu by id
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', new UniqueMenu],
        ]);
        $menuModel = new Menu();
        $menuModel->updateById($id, $request->input('name'));
        return redirect('/menu');
    }
}
