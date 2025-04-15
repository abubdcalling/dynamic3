<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    // Show the first navbar
    public function show()
    {
        $navbar = Navbar::first();

        if ($navbar && $navbar->logo) {
            $navbar->logo = url('uploads/Navbars/' . $navbar->logo);
        }

        return response()->json($navbar);
    }

    // Store or update the navbar
    public function storeOrUpdate(Request $request)
    {
        $navbar = Navbar::first();

        $logo = $navbar->logo ?? null;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Navbars'), $logo);
        }

        $data = [
            'logo'        => $logo,
            'itemname1'   => $request->input('itemname1'),
            'itemlink1'   => $request->input('itemlink1'),
            'itemname2'   => $request->input('itemname2'),
            'itemlink2'   => $request->input('itemlink2'),
            'itemname3'   => $request->input('itemname3'),
            'itemlink3'   => $request->input('itemlink3'),
            'itemname4'   => $request->input('itemname4'),
            'itemlink4'   => $request->input('itemlink4'),
        ];

        if ($navbar) {
            $navbar->update($data);
        } else {
            $navbar = Navbar::create($data);
        }

        // Add full URL to logo for response
        $navbar->logo = $navbar->logo ? url('uploads/Navbars/' . $navbar->logo) : null;

        return response()->json($navbar);
    }
}
