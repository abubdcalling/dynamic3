<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class AddressController extends Controller
{
    public function show()
    {
        try {
            $address = Address::first();

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
                'message' => 'Failed to retrieve address.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        // ✅ Validation rules
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string|max:255',
            'location' => 'required|string|max:500',
            'img'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required'    => 'The title field is required.',
            'location.required' => 'The location field is required.',
            'img.image'         => 'The img must be an image.',
            'icon.image'        => 'The icon must be an image.',
        ]);

        // ❌ Return on validation fail
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $address = Address::first();

            $imgName = $address->img ?? null;
            $iconName = $address->icon ?? null;

            // 🖼 Handle image upload
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $imgName = time() . '_img.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Addresses'), $imgName);
            }

            // 🖼 Handle icon upload
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

            // Add full URLs
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
                'message' => 'Failed to save address.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
