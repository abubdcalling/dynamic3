<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AddressController extends Controller
{
    public function show()
    {
        try {
            $address = Address::first();

            // Add full URLs to images
            if ($address) {
                $address->img = $address->img ? url('uploads/Addresses/' . $address->img) : null;
                $address->icon = $address->icon ? url('uploads/Addresses/' . $address->icon) : null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Address retrieved successfully.',
                'data'    => $address
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve address.'
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $address = Address::first();

            // Existing file names (in case not re-uploaded)
            $imgName = $address->img ?? null;
            $iconName = $address->icon ?? null;

            // Handle image upload
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $imgName = time() . '_img.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Addresses'), $imgName);
            }

            // Handle icon upload
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconName = time() . '_icon.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Addresses'), $iconName);
            }

            $data = [
                'title'    => $request->input('title'),
                'location' => $request->input('location'),
                'img'      => $imgName,
                'icon'     => $iconName,
            ];

            if ($address) {
                $address->update($data);
                $message = 'Address updated successfully.';
            } else {
                $address = Address::create($data);
                $message = 'Address created successfully.';
            }

            // Add full URLs for the response
            $address->img = $address->img ? url('uploads/Addresses/' . $address->img) : null;
            $address->icon = $address->icon ? url('uploads/Addresses/' . $address->icon) : null;

            return response()->json([
                'success' => true,
                'message' => $message,
                'data'    => $address
            ]);
        } catch (Exception $e) {
            Log::error('Error saving address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save address.'
            ], 500);
        }
    }
}
