<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Chat\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request, Chat $chat)
    {
        $message = new Message;
        $message->body = $request->body;
        $message->user()->associate($request->user());

        $chat->messages()->save($message);

        $chat->touchLastMessage();

//        broadcast(new ConversationReplyCreated($reply))->toOthers();

        return $message->load(['user']);
    }
}
