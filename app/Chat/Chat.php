<?php

namespace App\Chat;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $appends = [
        'selfOwned',
        'isUnread',
        'ownerId',
        'pageCount'
    ];

    public $perPage = 25;

    public function users()
    {
        return $this->belongsToMany(User::class, ChatUser::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->with('user');
    }

    public function touchLastMessage()
    {
        $this->last_message = Carbon::now();
        $this->save();
    }

    public function setUnread(Message $message)
    {
        $this->users()->where('id', '!=', $message->user_id)->update(['is_unread' => true]);
    }

    public function read(User $user) {
        $this->users()->where('id', $user->id)->update([
            'is_unread' => false,
            'read_at' => Carbon::now(),
        ]);
    }

    public function usersExceptCurrentlyAuthenticated()
    {
        return $this->users()->where('id', '!=', Auth::user()->id);
    }

    public function getSelfOwnedAttribute()
    {
        return $this->getOwnerIdAttribute() === auth()->user()->id;
    }

    public function getOwnerIdAttribute()
    {
        return $this->users()->where('is_owner', true)->first()->id;
    }

    public function getIsUnreadAttribute()
    {
        return $this->users()->where('id', auth()->user()->id)->pluck('is_unread')->first();
    }

    public function getPageCountAttribute()
    {
        return intval(
            ceil(
                $this->messages()->count() / $this->perPage
            )
        );
    }
}
