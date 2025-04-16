<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class NavbarController extends Controller
{
    // Show the first navbar
    public function show()
    {
        try {
            $navbar = Navbar::first();

            if ($navbar && $navbar->logo) {
                $navbar->logo = url('uploads/Navbars/' . $navbar->logo);
            }

            return response()->json([
                'success' => true,
                'data' => $navbar
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching navbar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve navbar data.'
            ], 500);
        }
    }

    // Store or update the navbar
    public function storeOrUpdate(Request $request)
    {
        try {
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

            $navbar->logo = $navbar->logo ? url('uploads/Navbars/' . $navbar->logo) : null;

            return response()->json([
                'success' => true,
                'message' => 'Navbar updated successfully.',
                'data' => $navbar
            ]);
        } catch (Exception $e) {
            Log::error('Error saving navbar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save navbar data.'
            ], 500);
        }
    }
}
