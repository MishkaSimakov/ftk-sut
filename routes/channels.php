<?php

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return $user->isInChat(\App\Chat\Chat::find($chatId));
});
