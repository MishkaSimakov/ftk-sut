<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class EventSingle extends Component
{
    public Event $event;

    public function signUp()
    {
        if (auth()->user()->cannot('signUp', $this->event)) {
            abort(403);
        }
        if ($this->event->users()->where('id', auth()->id())->exists()) {
            return;
        }

        $this->event->users()->syncWithoutDetaching(auth()->user());
    }

    public function render()
    {
        return view('livewire.events.event-single');
    }
}
