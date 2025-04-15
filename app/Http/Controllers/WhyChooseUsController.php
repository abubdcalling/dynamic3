<?php

namespace App\Http\Controllers;

use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    public function show()
    {
        $data = WhyChooseUs::first();
        return response()->json($data);
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->only(['title', 'description', 'button_name', 'button_url']);

        $record = WhyChooseUs::first();

        if ($record) {
            $record->update($data);
        } else {
            $record = WhyChooseUs::create($data);
        }

        return response()->json($record);
    }
}
