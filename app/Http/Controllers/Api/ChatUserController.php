<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatUserController extends Controller
{
    public function store(Chat $chat, Request $request)
    {
        $this->authorize('tune', $chat);

        $chat->users()->syncWithoutDetaching($request->recipients);

        $chat->load(['users']);

//        broadcast(new Ch($conversation))->toOthers();

        return $chat;
    }
}
