<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function show(Teacher $teacher)
    {
        return view('teacher.show', compact('teacher'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:50|string',
            'middle_name' => 'required|max:50|string',
            'last_name' => 'required|max:50|string',
            'club_id' => 'required|integer',
            'avatar' => 'required|image',
        ]);

        $teacher = new Teacher(Arr::except($validatedData, 'avatar'));

        $teacher->save();

        $avatar = $validatedData['avatar'];

        $name = Str::slug(str_replace("." . $avatar->getClientOriginalExtension(), "", $avatar->getClientOriginalName()));
        $filename = $name . '.' . $avatar->getClientOriginalExtension();

        $teacher->addMedia($avatar->path())
            ->usingFileName($filename)
            ->usingName($name)
            ->toMediaCollection();

        return redirect(route('admin.index'));
    }
}
