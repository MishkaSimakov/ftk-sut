<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Vote $vote, Request $request)
    {
        $vote->users()->syncWithoutDetaching([auth()->user()->id => [
            'option_id' => $request->selected
        ]]);

        return response()->json($vote->load(['users', 'options']));
    }

    public function all()
    {
        $votes = Vote::all()->sortByDesc('created_at')->map(function ($vote) {
            return [
                'value' => strval($vote->id),
                'text' => $vote->title,
            ];
        });

        return response()->json($votes);
    }
}
