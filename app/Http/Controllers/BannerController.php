<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class BannerController extends Controller
{
    public function show()
    {
        $banner = Banner::first();

        // Add full URL for images
        if ($banner) {
            $banner->back_img = $banner->back_img ? url('uploads/Banners/' . $banner->back_img) : null;
            $banner->icon = $banner->icon ? url('uploads/Banners/icons/' . $banner->icon) : null;
        }

        return response()->json($banner);
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $banner = Banner::first();

            $backImg = $banner->back_img ?? null;
            $iconImg = $banner->icon ?? null;

            // Handle background image
            if ($request->hasFile('back_img')) {
                $file = $request->file('back_img');
                $backImg = time() . '_back_img.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Banners'), $backImg);
            }

            // Handle icon image
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconImg = time() . '_icon.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Banners/icons'), $iconImg);
            }

            $data = [
                'title'       => $request->input('title'),
                'subtitle'    => $request->input('subtitle'),
                'description' => $request->input('description'),
                'back_img'    => $backImg,
                'icon'        => $iconImg,
            ];

            if ($banner) {
                $banner->update($data);
            } else {
                $banner = Banner::create($data);
            }

            // Add full URLs for response
            $banner->back_img = $banner->back_img ? url('uploads/Banners/' . $banner->back_img) : null;
            $banner->icon = $banner->icon ? url('uploads/Banners/icons/' . $banner->icon) : null;

            return response()->json($banner);

        } catch (Exception $e) {
            Log::error('Error saving Banner: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save banner.'
            ], 500);
        }
    }
}
