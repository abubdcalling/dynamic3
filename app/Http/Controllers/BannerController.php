<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class BannerController extends Controller
{
    public function show()
    {
        try {
            $banner = Address::first();

            // Add full URL for images
            if ($banner) {
                $banner->back_img = $banner->back_img ? url('uploads/Banners/' . $banner->back_img) : null;
                $banner->icon = $banner->icon ? url('uploads/Banners/' . $banner->icon) : null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Banner retrieved successfully.',
                'data'    => $banner
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching Banner: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve banner.'
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            // Optional validation (same rules you used before)
            $validated = $request->validate([
                'title'    => 'required|string|max:255',
                'location' => 'required|string|max:500',
                'img'      => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'icon'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            ]);

            $address = Address::first();

            $img = $address->img ?? null;
            $icon = $address->icon ?? null;

            // Upload img
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $img = time() . '_img.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Addresses'), $img);
            }

            // Upload icon
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $icon = time() . '_icon.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Addresses'), $icon);
            }

            $data = [
                'title'    => $validated['title'],
                'location' => $validated['location'],
                'img'      => $img,
                'icon'     => $icon,
            ];

            if ($address) {
                $address->update($data);
            } else {
                $address = Address::create($data);
            }

            // Add full URLs for response
            $address->img = $address->img ? url('uploads/Addresses/' . $address->img) : null;
            $address->icon = $address->icon ? url('uploads/Addresses/' . $address->icon) : null;

            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
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
