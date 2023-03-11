<?php

namespace Database\Seeders;

use App\Enums\TravelType;
use App\Enums\UserType;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EventSeeder extends Seeder
{
    public function run()
    {
        $events = Http::get('http://ftksut.ru/api/imports/events')->json();

        foreach ($events as $event) {
            if (!$event['title'] or $event['imageUrl'] === 'https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw_400x400.jpg') {
                continue;
            }

            $storedEvent = Event::create([
                'id' => $event['id'],

                'name' => $event['title'],
                'description' => $event['subtitle'],

                'date_start' => $event['date_start'],
                'date_end' => $event['date_end']
            ]);

            foreach ($event['users'] as $user) {
                $storedEvent->users()->attach(
                    $this->getUserId($user)
                );
            }

            if ($travel = $event['travel']) {
                $storedEvent->travel()->create([
                    'id' => $travel['id'],
                    'distance' => $travel['distance'],
                    'type' => $travel['is_bike'] ? TravelType::Bike : TravelType::Hiking
                ]);
            }

            try {
                $storedEvent->update([
                    'image_url' => $this->storeExternalEventImage('https://ftksut.ru' . $event['imageUrl'], $storedEvent)
                ]);
            } catch (\Exception $e) {
                var_dump($storedEvent->id);
            }
        }
    }

    protected function storeExternalEventImage(string $url, Event $event): string
    {
        $image = Image::make($url);

        $name = Str::random(40);
        $extension = Arr::last(explode('/', $image->mime()));
        $path = "/events/{$event->id}/{$name}.{$extension}";

        if ($image->width() > 720) {
            $image = $image->widen(720);
        }

        Storage::disk('public')->put($path, $image->encode());

        return $path;
    }

    protected function getUserId($user): int
    {
        if (!($foundUser = User::where('name', $user['name'])->first())) {
            $foundUser = User::create([
                'id' => $user['id'],
                'name' => $user['name'],
                'is_admin' => $user['is_admin'],
                'email' => $user['email'],
                'register_code' => $user['register_code'],
                'type' => UserType::Pupil
            ]);
        }

        return $foundUser->id;
    }
}
