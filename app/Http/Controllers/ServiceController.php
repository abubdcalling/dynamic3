<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Get the service data
    public function show()
    {
        $service = Service::first();
        return response()->json($service);
    }

    // Store or update the service data
    public function storeOrUpdate(Request $request)
    {
        $service = Service::first();

        $data = $request->only([
            'heading',
            'icon',
            'title1', 'icon1',
            'title2', 'icon2',
            'title3', 'icon3',
            'title4', 'icon4',
            'title5',
        ]);

        if ($service) {
            $service->update($data);
        } else {
            $service = Service::create($data);
        }

        return response()->json($service);
    }
}
