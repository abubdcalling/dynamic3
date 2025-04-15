<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    // Show the first about record
    public function show()
    {
        $about = About::first();
        return response()->json($about);
    }

    // Store or update the About section
    public function storeOrUpdate(Request $request)
    {
        $about = About::first();

        $data = [
            'title'         => $request->input('title'),
            'subtitle'      => $request->input('subtitle'),
            'description'   => $request->input('description'),
            'button_name'   => $request->input('button_name'),
            'button_url'    => $request->input('button_url'),
        ];

        if ($about) {
            $about->update($data);
        } else {
            $about = About::create($data);
        }

        return response()->json($about);
    }
}
