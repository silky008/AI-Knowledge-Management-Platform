<?php
namespace App\Jobs;

use App\Models\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessDocument implements ShouldQueue
{
    use Queueable;
    public $tries   = 3;
    public $backoff = 10; // in seconds

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

    public function failed(?Throwable $exception): void
    {
        Log::error('Document processing permanently failed', [
            'document_id' => $this->document->id,
            'exception'   => $exception ? get_class($exception) : null,
        ]);
    }
}
