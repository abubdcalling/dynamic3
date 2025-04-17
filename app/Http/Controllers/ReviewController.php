<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function show()
    {
        try {
            $data = Review::first();

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching Review data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $data = $request->only(['title', 'back_color', 'img']);

            $record = Review::first();

            if ($record) {
                $record->update($data);
                $message = 'Data updated successfully.';
            } else {
                $record = Review::create($data);
                $message = 'Data created successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $record
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing/updating Review data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to store or update data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
