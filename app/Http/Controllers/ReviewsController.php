<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreReviewRequest;
use App\Models\Review;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only('index');
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
}
