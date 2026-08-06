<?php
namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class DocumentService
{
    public function upload(User $user, UploadedFile $file, string $title): Document
    {
        $path = $file->store('documents');

        return Document::create([
            'user_id'   => $user->id,
            'title'     => $title,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }
}
