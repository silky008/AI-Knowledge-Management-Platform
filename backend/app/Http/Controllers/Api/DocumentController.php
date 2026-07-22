<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $file = $request->file('document');

        $path = $file->store('documents');

        $document = Document::create([
            'user_id'   => $request->user()->id,
            'title'     => $validated['title'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json([
            'message'  => 'Document uploaded successfully',
            'document' => $document,
        ], 201);
    }

    public function index(Request $request)
    {
        $documents = $request->user()
            ->documents()
            ->latest()
            ->paginate(10);

        return response()->json($documents);
    }
}
