<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Chat\Message;
use App\Events\ChatMessageCreated;
use App\Events\ChatMessageUpdated;
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
        $message->forwarded_id = $request->reply;

        $chat->messages()->save($message);

        $chat->touchLastMessage();
        $chat->setUnread($message);

        return response()->json($message->id);
    }

    public function storeImage(Message $message, Request $request)
    {
        $images = [];

        if (count($request->allFiles())) {
            foreach ($request->allFiles()['files'] as $image) {
                /** @var UploadedFile $image */

                $name = Str::slug(str_replace("." . $image->getClientOriginalExtension(), "", $image->getClientOriginalName()));
                $filename = $name . '.' . $image->getClientOriginalExtension();

                array_push(
                    $images, $message->addMedia($image->path())
                    ->usingFileName($filename)
                    ->usingName($name)
                    ->toMediaCollection()
                    ->getUrl()
                );
            }
        }

        broadcast(new ChatMessageCreated($message->withoutRelations()->load(['user'])))->toOthers();

        return response()->json($message->images);
    }

    public function update(Chat $chat, Message $message, Request $request)
    {
        $this->authorize('edit', $message);

        $message->update([
            'body' => $request->body,
            'is_edited' => true,
            'forwarded_id' => $request->reply
        ]);

        broadcast(new ChatMessageUpdated($message->withoutRelations()->load(['user'])))->toOthers();

        return response()->json($message->id);
    }
}
