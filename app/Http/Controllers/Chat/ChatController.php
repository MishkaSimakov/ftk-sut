<?php

namespace App\Http\Controllers\Chat;

use App\Chat\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function show(Chat $chat)
    {
        $this->authorize('show', $chat);

        return view('chat.show', compact('chat'));
    }

    public function create()
    {
        return view('chat.create');
    }
}