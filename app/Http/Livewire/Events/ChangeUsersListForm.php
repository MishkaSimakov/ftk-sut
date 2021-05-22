<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class ChangeUsersListForm extends Component
{
    public Event $event;
    public string $modal_id;
    public int $selected_user = -1;

    public array $users_distances = [];
    public Collection $users;

    public function mount()
    {
        $this->modal_id = "event_{$this->event->id}_users_list_edit_modal";

        $this->users = User::select(['id', 'name'])->whereNotIn('id', $this->event->users->pluck('id'))->orderBy('name')->get();
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

        // append user to event users
        $this->event->users()->attach($user);
        $this->event->refresh();

        // remove user from users select
        $this->users = $this->users->where('id', '!=', $user->id);
        $this->users = $this->users->sortBy('name');

        // reset users select
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

        // remove user from event users
        $this->event->users()->detach($user);
        $this->event->refresh();

        // append user to users select
        $this->users->push($user);
        $this->users = $this->users->sortBy('name');
    }

    public function changeUserDistance(User $user)
    {
        $this->event->users()->updateExistingPivot($user->id, [
            'distance_traveled' => $this->users_distances[$user->id]
        ]);
    }

    public function render()
    {
        if ($this->event->isTravel()) {
            foreach ($this->event->users as $user) {
                if (!isset($this->users_distances[$user->id])) {
                    $this->users_distances[$user->id] = $user->pivot->distance_traveled ?? $this->event->travel->distance;
                }
            }
        }

        return view('livewire.events.change-users-list-form');
    }
}
