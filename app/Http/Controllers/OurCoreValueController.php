<?php

namespace App\Http\Controllers;

use App\Models\OurCoreValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class OurCoreValueController extends Controller
{
    public function show()
    {
        try {
            $data = OurCoreValue::first();

            if ($data && $data->img) {
                $data->img = url('uploads/OurCoreValue/' . $data->img);
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching OurCoreValue data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve core value data.',
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $core = OurCoreValue::first();

            $imgName = $core->img ?? null;

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $imgName = time() . '_corevalue.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/OurCoreValue'), $imgName);
            }

            $data = [
                'title'        => $request->input('title'),
                'description1' => $request->input('description1'),
                'description2' => $request->input('description2'),
                'img'          => $imgName,
                'icon1'        => $request->input('icon1'),
                'icon2'        => $request->input('icon2'),
            ];

            if ($core) {
                $core->update($data);
            } else {
                $core = OurCoreValue::create($data);
            }

            $core->img = $core->img ? url('uploads/OurCoreValue/' . $core->img) : null;

            return response()->json([
                'success' => true,
                'message' => 'Core values saved successfully.',
                'data' => $core,
            ]);
        } catch (Exception $e) {
            Log::error('Error saving OurCoreValue data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save core value data.',
            ], 500);
        }
    }
}
