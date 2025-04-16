<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AddressController extends Controller
{
    public function show()
    {
        try {
            $address = Address::first();

            return response()->json([
                'success' => true,
                'message' => 'Address retrieved successfully.',
                'data' => $address
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve address.'
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $address = Address::first();

            $data = [
                'title'    => $request->input('title'),
                'location' => $request->input('location'),
                'icon'     => $request->input('icon'),
            ];

            if ($address) {
                $address->update($data);
                $message = 'Address updated successfully.';
            } else {
                $address = Address::create($data);
                $message = 'Address created successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $address
            ]);
        } catch (Exception $e) {
            Log::error('Error saving address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save address.'
            ], 500);
        }
    }
}
