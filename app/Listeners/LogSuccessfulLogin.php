<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin implements ShouldQueue
{
    protected $request;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle successful login.
     *
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $login = [
            'user_id' => $event->user->id,
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        \App\Login::create($login);

        $user = $event->user;
        $user->last_login_at = now();
        $user->last_login_ip = $this->request->ip();
        $user->last_login_user_agent = $this->request->userAgent();
        $user->save();
    }
}
