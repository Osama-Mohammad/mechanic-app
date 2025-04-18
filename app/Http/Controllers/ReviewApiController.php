<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class ReviewApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $serviceRequest = ServiceRequest::findOrFail($id);

        if (!$serviceRequest) {
            return response()->json([
                'error' => 'Service request not found',
            ], 404);
        }

        if ($request->user()->id != $serviceRequest->customer_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);


        if (!$validated) {
            return response()->json([
                'error' => 'Invalid Credentials',
            ], 400);
        }

        $review = new Review();
        $review->customer_id = $request->user()->id;
        $review->mechanic_id = $serviceRequest->mechanic_id;
        $review->service_request_id = $serviceRequest->id;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->date = now();

        $review->save();

        return response()->json([
            'message' => 'Review created successfully.',
            'Review' => $review,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $review = Review::findOrFail($id);

        if (!$review) {
            return response()->json([
                'error' => 'Review not found',
            ], 404);
        }

        if ($request->user()->id != $review->customer_id) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);


        if (!$validated) {
            return response()->json([
                'error' => 'Invalid Credentials',
            ], 400);
        }

        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];

        return response()->json([
            'message' => 'Review Updated successfully.',
            'Review' => $review,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
