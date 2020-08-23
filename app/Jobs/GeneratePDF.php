<?php

namespace App\Jobs;

use PDF;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GeneratePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $service;
    private $data;
    private $skip;
    private $take;
    private $file;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $service, array $data, int $skip, int $take, string $file, User $user)
    {
        $this->service = $service;
        $this->data = $data;
        $this->skip = $skip;
        $this->take = $take;
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = App::make($this->service);
        $filtered = $service->filteredQuery($this->data);
        $competencies = $filtered->skip($this->skip)->take($this->take)->get(['id', 'title', 'level_id', 'category_id']);
        $file = storage_path('app/' . $this->file);
        $pdf = PDF::loadView('competency.export', compact('competencies'));
        $pdf->save($file);
    }
}
