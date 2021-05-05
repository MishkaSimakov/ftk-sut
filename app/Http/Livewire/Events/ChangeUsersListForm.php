<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;

class ChangeUsersListForm extends Component
{
    public Event $event;
    public string $modal_id;
    public int $selected_user = -1;

    public function mount()
    {
        $this->modal_id = "event_{$this->event->id}_users_list_edit_modal";
    }

    public function addUser()
    {
        if (auth()->user()->cannot('changeUsersList', $this->event)) {
            abort(403);
        }
        if ($this->selected_user === -1) {
            return;
        }

        $user = User::find($this->selected_user);

        if ($this->event->users()->where('id', $user->id)->exists()) {
            return;
        }

        $this->event->users()->attach($user);
        $this->event->refresh();

        $this->selected_user = -1;
    }

    public function removeUser(User $user)
    {
        if (auth()->user()->cannot('changeUsersList', $this->event)) {
            abort(403);
        }
        if (!$this->event->users()->where('id', $user->id)->exists()) {
            return;
        }

        $this->event->users()->detach($user);
        $this->event->refresh();
    }

    public function render()
    {
        $users = User::select(['id', 'name'])->whereNotIn('id', $this->event->users->pluck('id'))->get();

        return view('livewire.events.change-users-list-form', [
            'users' => $users
        ]);
    }
}
