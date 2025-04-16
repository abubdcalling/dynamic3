<?php

namespace App\Http\Controllers;

use App\Models\OurContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class OurContactController extends Controller
{
    public function show()
    {
        try {
            $contact = OurContact::first();

            return response()->json([
                'success' => true,
                'message' => 'Contact information retrieved successfully.',
                'data' => $contact
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching contact information: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact information.'
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $contact = OurContact::first();

            $data = [
                'heading'      => $request->input('heading'),
                'email'        => $request->input('email'),
                'phone'        => $request->input('phone'),
                'email_icon'   => $request->input('email_icon'),
                'phone_icon'   => $request->input('phone_icon'),
                'copyright'    => $request->input('copyright'),
            ];

            if ($contact) {
                $contact->update($data);
                $message = 'Contact information updated successfully.';
            } else {
                $contact = OurContact::create($data);
                $message = 'Contact information created successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $contact
            ]);
        } catch (Exception $e) {
            Log::error('Error saving contact information: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save contact information.'
            ], 500);
        }
    }
}
