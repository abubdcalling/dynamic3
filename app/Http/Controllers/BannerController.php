<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function show()
    {
        $banner = Banner::first();

        // Add full URL for back_img before sending
        if ($banner && $banner->back_img) {
            $banner->back_img = url('uploads/Banners/' . $banner->back_img);
        }

        return response()->json($banner);
    }

    public function storeOrUpdate(Request $request)
    {
        $banner = Banner::first();

        $backImg = $banner->back_img ?? null;

        // Handle background image upload
        if ($request->hasFile('back_img')) {
            $file = $request->file('back_img');
            $backImg = time() . '_back_img.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Banners'), $backImg);
        }

        $data = [
            'title'       => $request->input('title'),
            'subtitle'    => $request->input('subtitle'),
            'description' => $request->input('description'),
            'back_img'    => $backImg,
        ];

        if ($banner) {
            $banner->update($data);
        } else {
            $banner = Banner::create($data);
        }

        // Attach full URL for the image before sending response
        $banner->back_img = $banner->back_img ? url('uploads/Banners/' . $banner->back_img) : null;

        return response()->json($banner);
    }
}
