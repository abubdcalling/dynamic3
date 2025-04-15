<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $menu = Menu::first();

        $backImg = $menu->back_img ?? null;

        if ($request->hasFile('back_img')) {
            $file = $request->file('back_img');
            $backImg = time() . '_back_img.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Menus'), $backImg);
        }

        $data = ['back_img' => $backImg];

        if ($menu) {
            $menu->update($data);
        } else {
            $menu = Menu::create($data);
        }

        // Return full URL
        $menu->back_img = $menu->back_img ? url('uploads/Menus/' . $menu->back_img) : null;

        return response()->json($menu);
    }
}
