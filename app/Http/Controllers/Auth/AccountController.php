<?php

namespace App\Http\Controllers\Auth;

use App\Achievements\Events\UserWriteDescription;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function settings()
    {
        return view('user.settings');
    }

    public function update(StoreUser $request)
    {
//        if ($request->password) {
//            $validatedData = $request->validate([
//                'password' => 'required|string|min:6|confirmed',
//            ]);
//
//            Auth::user()->update([
//                'password' => Hash::make($validatedData['password'])
//            ]);
//        } else {
        if (Auth::user()->student) {
            Auth::user()->student->update([
                'birthday' => Carbon::parse($request->birthday),
            ]);
        }

        Auth::user()->update([
            'phone' => $request->phone,
            'vk_link' => $request->vk_link,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        UserWriteDescription::dispatch($request->user());
//    }

        return redirect()->back();
    }

    public function image(Request $request)
    {
        if ($request->user()->getMedia()->count()) {
            $request->user()->deleteMedia($request->user()->getMedia()->first());
        }

        /** @var UploadedFile $photo */
        $photo = Arr::first($request->allFiles());

        $name = Str::slug(str_replace("." . $photo->getClientOriginalExtension(), "", $photo->getClientOriginalName()));
        $filename = $name . '.' . $photo->getClientOriginalExtension();

        return response()->json(
            $request->user()->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection()->getUrl()
        );
    }
}
