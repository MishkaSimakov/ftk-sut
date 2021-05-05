<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
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


    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $image_name = Str::random(6);
        $path = '\\events\\' . $image_name . '.' . $request->file('image')->extension();
        Image::make($request->file('image'))
            ->widen(750)
            ->save(public_path('storage' . $path));

        Event::create(
            array_merge($request->except('image'), [
                'image_url' => $path
            ])
        );

        return redirect()->route('events.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
