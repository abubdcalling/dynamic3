<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OurContact;
use Illuminate\Http\Request;

class OurContactController extends Controller
{
    public function show()
    {
        $contact = OurContact::first();
        return response()->json($contact);
    }

    public function storeOrUpdate(Request $request)
    {
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
        } else {
            $contact = OurContact::create($data);
        }

        return response()->json($contact);
    }
}
