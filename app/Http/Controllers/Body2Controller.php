<?php

namespace App\Http\Controllers;

use App\Models\Body2;
use Illuminate\Http\Request;

class Body2Controller extends Controller
{
    public function show()
    {
        $body2 = Body2::first();

        if ($body2 && $body2->icon) {
            $body2->icon = url('uploads/Body2/' . $body2->icon);
        }

        return response()->json($body2);
    }

    public function storeOrUpdate(Request $request)
    {
        $body2 = Body2::first();

        $icon = $body2->icon ?? null;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $icon = time() . '_icon.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Body2'), $icon);
        }

        $data = [
            'title' => $request->input('title'),
            'icon'  => $icon,
        ];

        if ($body2) {
            $body2->update($data);
        } else {
            $body2 = Body2::create($data);
        }

        $body2->icon = $body2->icon ? url('uploads/Body2/' . $body2->icon) : null;

        return response()->json($body2);
    }
}
