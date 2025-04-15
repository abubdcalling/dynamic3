<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $contact = Contact::first();

        // If contact exists, return as JSON response
        if ($contact) {
            return response()->json($contact);
        }

        // If contact not found, return a 404 response
        return response()->json(['message' => 'Contact not found'], 404);
    }

    /**
     * Store or update the contact information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request)
    {
        $contact = Contact::first();

        // Validate the incoming request
        $request->validate([
            'color' => 'nullable|string',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'button_name' => 'nullable|string',
            'button_url' => 'nullable|url',
        ]);

        // Prepare data for saving or updating
        $data = [
            'color' => $request->input('color'),
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'button_name' => $request->input('button_name'),
            'button_url' => $request->input('button_url'),
        ];

        // If a contact exists, update it; otherwise, create a new one
        if ($contact) {
            $contact->update($data);
        } else {
            $contact = Contact::create($data);
        }

        // Return the updated or newly created contact as JSON
        return response()->json($contact);
    }
}
