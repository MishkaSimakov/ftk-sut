<?php

namespace App\Http\Controllers;

use App\Vote;
use App\VoteOption;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function show(Vote $vote)
    {
        $vote->load(['users', 'options']);

        return view('vote.show', compact('vote'));
    }

    public function widget(Vote $vote)
    {
        $vote->load(['users', 'options']);

        return view('vote.widget', compact('vote'));
    }

    public function create()
    {
        return view('vote.create');
    }

    public function store(Request $request)
    {
        $vote = new Vote();

        $vote->title = $request->title;
        $vote->description = $request->description;
        $vote->is_multiselect = $request->multiselect === 'on';
        $vote->user_id = auth()->user()->id;

        $vote->save();

        foreach ($request->question as $question) {
            VoteOption::create(['vote_id' => $vote->id, 'title' => $question]);
        }

        return redirect(route('vote.show', compact('vote')));
    }
}
