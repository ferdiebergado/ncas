<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use App\User;

class MergePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $count;
    protected $file;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $count, string $file, User $user)
    {
        $this->count = $count;
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
        $filename = storage_path('app/') . $this->file;
        $ext = '.pdf';

        $pdfMerger = PdfMerger::init();

        for ($i = 0; $i < $this->count; $i++) {
            $pdfMerger->addPDF($filename . '-' . $i . $ext);
        }

        $pdfMerger->merge();
        $pdfMerger->save($filename . $ext);
    }
}
