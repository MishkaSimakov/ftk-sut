<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Storage;
use Str;


class EventsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    public function index()
    {
        $events = Event::future()->with('users')->orderBy('date_start')->get();

        return view('events.index', compact('events'));
    }

    public function past()
    {
        $events = Event::past()->with('users')->orderBy('date_start')->paginate(Event::PAGINATION_LIMIT);

        return view('events.index', compact('events'));
    }


    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $path = $this->storeEventImage($request->file('image'));

        Event::create(
            array_merge($request->except('image'), [
                'image_url' => $path
            ])
        );

        return redirect()->route('events.index');
    }


    public function edit(Event $event)
    {
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
        $image_name = Str::random(6);
        $path = '\\events\\' . $image_name . '.' . $file->extension();
        Image::make($file)
            ->widen(750)
            ->save(public_path('storage' . $path));

        return $path;
    }
}
