<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class DiscordInvite extends Component
{
    public User $user;
    public string $code = '';

    public function generate()
    {
        $url = URL::signedRoute(
            'api.discord.invite', ['user' => $this->user->id]
        );

        $this->code = join(
            '.',
            array_map(
                function ($x) {
                    return explode('=', $x)[1];
                },
                explode(
                    '&',
                    explode('?', $url)[1]
                )
            )
        );
    }

    public function render()
    {
        return view('livewire.users.discord-invite', [
            'code' => $this->code
        ]);
    }
}
