<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Chat\Message;
use App\Events\ChatMessageCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessage;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(StoreChatMessage $request, Chat $chat)
    {
        $this->authorize('affect', $chat);

        $message = new Message;
        $message->body = $request->body;
        $message->user()->associate($request->user());

        $chat->messages()->save($message);

        $chat->touchLastMessage();
        $chat->setUnread($message);

        broadcast(new ChatMessageCreated($message))->toOthers();

        return response()->json([
            'message' => $message->load(['user']),
            'chat' => $message->chat->load(['users'])
        ]);
    }
}
