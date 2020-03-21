<?php

namespace App\Http\Controllers\Api;

use App\Chat\Chat;
use App\Events\ChatCreated;
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
        return $chat->load(['users', 'messages']);
    }

    public function store(Request $request)
    {
        $chat = new Chat;
        $chat->name = $request->title;

        $chat->save();

        $chat->users()->sync(
            array_unique($request->recipients)
        );
        $chat->users()->syncWithoutDetaching([$request->user()->id => ['is_owner' => true]]);


        $chat->load('users');

        broadcast(new ChatCreated($chat))->toOthers();

        return response()->json('/chat/' . $chat->id);
    }
}
