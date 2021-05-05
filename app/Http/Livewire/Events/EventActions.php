<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class EventActions extends Component
{
    public Event $event;
    public string $modal_id;

    public function signUp()
    {
        if (auth()->user()->cannot('signUp', $this->event)) {
            abort(403);
        }
        if ($this->event->users()->where('id', auth()->id())->exists()) {
            return;
        }

        $this->event->users()->attach(auth()->user());
        $this->event->refresh();
    }

    public function signOut()
    {
        if (auth()->user()->cannot('signUp', $this->event)) {
            abort(403);
        }
        if (!$this->event->users()->where('id', auth()->id())->exists()) {
            return;
        }

        $this->event->users()->detach(auth()->user());
        $this->event->refresh();
    }

    public function mount()
    {
        $this->modal_id = "event_{$this->event->id}_users_list_modal";
    }

    public function render()
    {
        return view('livewire.events.event-actions');
    }
}
