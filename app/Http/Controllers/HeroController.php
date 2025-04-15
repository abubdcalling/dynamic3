<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    // Get the hero data
    public function show()
    {
        $hero = Hero::first();
        return response()->json($hero);
    }

    // Store or update the hero section
    public function storeOrUpdate(Request $request)
    {
        $hero = Hero::first();

        $data = [
            'title'         => $request->input('title'),
            'subtitle'      => $request->input('subtitle'),
            'description'   => $request->input('description'),
            'button_title'  => $request->input('button_title'),
            'button_name'   => $request->input('button_name'),
            'button_url'    => $request->input('button_url'),
        ];

        if ($hero) {
            $hero->update($data);
        } else {
            $hero = Hero::create($data);
        }

        return response()->json($hero);
    }
}
