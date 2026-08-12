<?php
namespace App\Jobs;

use App\Models\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessDocument implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::info('Processing document', [
            'document_id' => $this->document->id,
        ]);
    }
}
