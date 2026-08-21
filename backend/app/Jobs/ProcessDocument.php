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
        if ($this->document->status === 'processed') {
            Log::info('Document already processed, skipping', [
                'document_id' => $this->document->id,
            ]);

            return;
        }

        $this->document->update([
            'status' => 'processing',
        ]);

        Log::info('Processing document', [
            'document_id' => $this->document->id,
        ]);
        $this->document->update([
            'status' => 'processed',
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        $this->document->update([
            'status' => 'failed',
        ]);
        Log::error('Document processing permanently failed', [
            'document_id' => $this->document->id,
            'exception'   => $exception ? get_class($exception) : null,
        ]);
    }
}
