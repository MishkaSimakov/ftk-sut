<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Models\Event;
use App\Models\Travel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Storage;


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
        $events = Event::past()->with(['users', 'travel'])->orderBy('date_start')->paginate(Event::PAGINATION_LIMIT);

        return view('events.index', compact('events'));
    }


    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $path = $this->storeEventImage($request->file('image'));

        $event = Event::create(
            array_merge($request->except('image'), [
                'image_url' => $path
            ])
        );

        if ($request->get('is_travel') === 'on') {
            $event->travel()->save(
                Travel::make([
                    'distance' => $request->get('travel_distance'),
                    'type' => $request->get('travel_type'),
                ])
            );
        }

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
            Storage::disk('public')->delete($event->image_url);

            $path = $this->storeEventImage($request->file('image'));

            $event->update(['image_url' => $path]);
        }

        $event->update($request->except('image'));

        if ($request->get('is_travel') === 'on') {
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
        Storage::disk('public')->delete($event->image_url);
        $event->delete();

        return redirect()->back();
    }

    public function editUsersList(Event $event)
    {
        $this->authorize('changeUsersList', $event);

        $event->loadMissing('users');

        return view('events.users.edit', compact('event'));
    }


    protected function storeEventImage(UploadedFile $file): string
    {
        $name = Str::random(40);
        $extension = $file->extension();
        $path = "/events/{$name}.{$extension}";

        $image = Image::make($file);
        if ($image->width() > 720) {
            $image = $image->widen(720);
        }

        $image->save(
            config('filesystems.disks.public.root') . $path
        );

        return $path;
    }
}
