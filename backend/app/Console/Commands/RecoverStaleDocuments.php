<?php
namespace App\Console\Commands;

use App\Jobs\ProcessDocument;
use App\Models\Document;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('documents:recover-stale')]
#[Description('Recover documents stuck in processing')]
class RecoverStaleDocuments extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $documents = Document::where('status', 'processing')
            ->where('processing_started_at', '<', now()->subMinutes(30))
            ->get();

        foreach ($documents as $document) {
            // Reset the status to 'uploaded' and clear the processing_started_at timestamp
            $updated = Document::where('id', $document->id)
                ->where('status', 'processing')
                ->where('processing_started_at', '<', now()->subMinutes(30))
                ->update([
                    'status'                => 'uploaded',
                    'processing_started_at' => null,
                ]);

            if ($updated === 0) {
                continue;
            }

            // Dispatch the job to process the document again
            ProcessDocument::dispatch($document);
            $this->info("Recovered document {$document->id}");
        }

        return Command::SUCCESS;

    }
}
