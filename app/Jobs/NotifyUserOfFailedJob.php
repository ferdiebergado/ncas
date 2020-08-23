<?php

namespace App\Jobs;

use App\Notifications\ExportReady;
use App\Notifications\FailedJobBroadcastNotification;
use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyUserOfFailedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\User
     */
    public $user;

    public $exception;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Exception $exception)
    {
        $this->user = $user;
        $this->exception = $exception;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new FailedJobBroadcastNotification($this->exception));
    }
}
