<?php

namespace App\Http\Controllers;

use App\Enums\UserNotificationSubscriptions;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\AchievementsService;
use Assada\Achievements\Model\AchievementProgress;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        $achievements = (new AchievementsService())->orderByProgress(
            $user->achievements()->where('points', '>', 0)->get()->map->details
        );

        return view('user.show', compact('user', 'achievements'));
    }

    public function home()
    {
        return $this->show(auth()->user());
    }


    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function settings()
    {
        return $this->edit(auth()->user());
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $flags = [
            'noticeNews' => UserNotificationSubscriptions::NewsNotifications(),
            'noticeArticles' => UserNotificationSubscriptions::ArticleNotifications(),
            'noticeEvents' => UserNotificationSubscriptions::EventNotifications(),
            'noticeRating' => UserNotificationSubscriptions::RatingNotifications(),
        ];

        $appliedFlags = [];
        foreach ($flags as $name => $class) {
            if ($request->get($name) === 'on') {
                $appliedFlags[] = $class;
            }
        }

        $user->update([
            'email' => $request->get('email'),
            'notification_subscriptions' => UserNotificationSubscriptions::flags($appliedFlags)
        ]);

        return redirect()->back();
    }


    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect()->route('users.show', $user);
    }
}
