<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function show()
    {
        $address = Address::first(); // You can modify this to fetch all if needed
        return response()->json($address);
    }

    public function storeOrUpdate(Request $request)
    {
        $address = Address::first();

        $data = [
            'title'    => $request->input('title'),
            'location' => $request->input('location'),
            'icon'     => $request->input('icon'),
        ];

        if ($address) {
            $address->update($data);
        } else {
            $address = Address::create($data);
        }

        return response()->json($address);
    }
}
