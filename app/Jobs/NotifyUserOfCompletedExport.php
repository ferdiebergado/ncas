<?php

namespace App\Jobs;

use App\Notifications\ExportReady;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\User
     */
    public $user;

    public $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new ExportReady($this->user, $this->file));
    }
}
