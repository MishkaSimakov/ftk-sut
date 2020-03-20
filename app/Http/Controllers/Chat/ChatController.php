<?php

namespace App\Http\Controllers\Chat;

use App\Chat\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function show(Chat $chat)
    {
        return view('chat.show', compact('chat'));
    }

    public function create()
    {
        return view('chat.create');
    }
}
