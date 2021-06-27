<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Models\Event;
use App\Notifications\EventCreatedNotification;
use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;


class EventsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    public function index()
    {
        $events = Event::future()->with(['users', 'travel'])->orderBy('date_start')->get();

        return view('events.index', compact('events'));
    }

    public function past()
    {
        $events = Event::past()->with(['users', 'travel'])->latest('date_start')->paginate(Event::PAGINATION_LIMIT);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->except('image'));

        $event->update([
            'image_url' => $this->storeEventImage($request->file('image'), $event)
        ]);

        if ($request->has('is_travel')) {
            $event->travel()->create([
                'distance' => $request->get('travel_distance'),
                'type' => $request->get('travel_type'),
            ]);
        }

        Notification::route('telegram', config('services.telegram-bot-api.channel_id'))
            ->notify(new EventCreatedNotification($event));

        return redirect()->route('events.index');
    }

    public function edit(Event $event)
    {
        $event->loadMissing('travel');

        return view('events.edit', compact('event'));
    }


    public function update(UpdateEventRequest $request, Event $event)
    {
        if ($request->hasFile('image')) {
            $this->destroyEventImage($event);

            $event->update([
                'image_url' => $this->storeEventImage($request->file('image'), $event)
            ]);
        }

        $event->update($request->except('image'));

        if ($request->has('is_travel')) {
            $event->travel()->updateOrCreate([
                'distance' => $request->get('travel_distance'),
                'type' => $request->get('travel_type'),
            ]);
        } elseif ($event->isTravel()) {
            $event->travel->delete();
        }

        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        $this->destroyEventImage($event);

        $event->delete();

        return redirect()->back();
    }

    public function editUsersList(Event $event)
    {
        $this->authorize('changeUsersList', $event);

        $event->loadMissing('users');

        return view('events.users.edit', compact('event'));
    }


    protected function storeEventImage(UploadedFile $file, Event $event): string
    {
        return (new ImageUploadService())->setMaxWidth(720)->setDisk('public')
            ->store($file, "/events/{$event->id}");
    }

    protected function destroyEventImage(Event $event)
    {
        Storage::disk('public')->delete($event->image_url);
    }
}
