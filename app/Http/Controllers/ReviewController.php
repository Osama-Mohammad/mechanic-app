<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ServiceRequest $serviceRequest)
    {
        $review = Review::where('customer_id', Auth::guard('customer')->user()->id)->where('service_request_id', $serviceRequest->id)->first();

        if ($review) {
            // If a review exists, redirect to the edit page
            return redirect()->route('reviews.edit', $review)->with('info', 'You have already reviewed this service request. You can update your review below.');
        }
        // If no review exists, proceed to the create page
        return view('reviews.create', compact('serviceRequest'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ServiceRequest $serviceRequest)
    {

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        $review = new Review();
        $review->customer_id = $serviceRequest->customer_id;
        $review->mechanic_id = $serviceRequest->mechanic_id;
        $review->service_request_id = $serviceRequest->id;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->date = now();

        $review->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Ensure the authenticated customer owns the review
        if ($review->customer_id !== Auth::guard('customer')->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Ensure the authenticated customer owns the review
        if ($review->customer_id !== Auth::guard('customer')->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Update the review
        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('serviceRequest.index')->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }

    public function AllReviews()
    {
        $reviews = Auth::guard('customer')->user()->reviews;
        return view('reviews.index', compact('reviews'));
    }
}
