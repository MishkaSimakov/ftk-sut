<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Chat\Message;
use App\Events\ChatMessageCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

        return response()->json($message->id);
    }

    public function storeImage(Message $message, Request $request)
    {
        if (count($request->allFiles())) {
            foreach ($request->allFiles()['files'] as $image) {
                /** @var UploadedFile $image */

                $name = Str::slug(str_replace("." . $image->getClientOriginalExtension(), "", $image->getClientOriginalName()));
                $filename = $name . '.' . $image->getClientOriginalExtension();

                $message->addMedia($image->path())
                    ->usingFileName($filename)
                    ->usingName($name)
                    ->toMediaCollection();
            }
        }

        broadcast(new ChatMessageCreated($message->withoutRelations()->load(['user'])))->toOthers();

        return response()->json('ok');
    }
}
