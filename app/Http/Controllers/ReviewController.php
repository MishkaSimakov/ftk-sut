<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('store');
    }

    public function index()
    {
        $reviews = Review::latest()->get();

        return view('reviews.index', compact('reviews'));
    }

    public function store(StoreReviewRequest $request)
    {
        $review = Review::create($request->validated());

        return redirect()->back()->with('message', 'Ваш отзыв сохранён.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index');
    }
}
