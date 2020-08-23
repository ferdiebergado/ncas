<?php

namespace App\Jobs;

use App\User;
use App\Jobs\MergePDF;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QueuePDFExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $service;
    private $data;
    private $filename;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $service, array $data, string $filename, User $user)
    {
        $this->service = $service;
        $this->data = $data;
        $this->filename = $filename;
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
        $count = $filtered->count();
        $threshold = Config::get('custom.collection.chunk_threshold', 200);
        $i = (int) ceil($count / $threshold);
        $skip = 0;

        // dispatch a job for each chunk (default: 200) of competencies
        for ($j = 0; $j < $i; $j++) {
            $filename = $this->filename . '-' . $j . '.pdf';
            // check if it's the last chunk
            if ($j === $i - 1) {
                // process the last chunk and merge all the created pdf file into a single file then notify the user.
                return GeneratePDF::withChain([
                    new MergePDF($i, $this->filename, $this->user),
                    new NotifyUserOfCompletedExport($this->user, $filename)
                ])->dispatch($this->service, $this->data, $skip, $threshold, $filename, $this->user);
            }
            // create a pdf file for the chunk
            GeneratePDF::dispatch($this->service, $this->data, $skip, $threshold, $filename, $this->user);
            $skip += $threshold;
        }
    }
}
