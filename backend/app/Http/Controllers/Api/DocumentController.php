<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function show(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            abort(403);
        }
        return response()->json($document);
    }

    public function destroy(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            abort(403);
        }

        Storage::delete($document->file_path);

        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully',
        ]);
    }
}
