<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $chats = $request->user()->chats()->with('users')->get();

        return response()->json($chats);
    }

    public function show(Chat $chat)
    {
        return $chat->load(['users']);
    }
}
