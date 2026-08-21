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

        $updated = Document::where('id', $this->document->id)
            ->where('status', 'uploaded')
            ->update([
                'status' => 'processing',
            ]);
        if ($updated === 0) {
            Log::info('Document is already being processed or processed', [
                'document_id' => $this->document->id,
            ]);

            return;
        }

        Log::info('Processing document', [
            'document_id' => $this->document->id,
        ]);
        Document::where('id', $this->document->id)
            ->update([
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
