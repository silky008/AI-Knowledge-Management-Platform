<?php
namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DocumentService
{
    public function upload(User $user, UploadedFile $file, string $title): Document
    {

        DB::beginTransaction();
        $path = null;
        try {
            $path     = $file->store('documents', 'local');
            $document = Document::create([
                'user_id'   => $user->id,
                'title'     => $title,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
            DB::commit();
            return $document;
        } catch (Throwable $e) {
            DB::rollBack();
            if ($path) {
                Storage::delete($path);
            }

            throw $e;
        }

    }
}
