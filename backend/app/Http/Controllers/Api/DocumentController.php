<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function store(StoreDocumentRequest $request)
    {
        $validated = $request->validated();

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
            'document' => new DocumentResource($document),
        ], 201);
    }

    public function index(Request $request)
    {
        $documents = $request->user()
            ->documents()
            ->latest()
            ->paginate(10);

        return DocumentResource::collection($documents);
    }
    public function show(Request $request, Document $document)
    {
        if ($document->user_id !== $request->user()->id) {
            abort(403);
        }
        return new DocumentResource($document);
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

    public function download(Request $request, Document $document)
    {

        if ($document->user_id !== $request->user()->id) {
            abort(403);
        }
        $disk = Storage::disk('local');
        if (! $disk->exists($document->file_path)) {
            return response()->json([
                'message' => 'File not found.',
            ], 404);
        }

        return $disk->download(
            $document->file_path,
            $document->file_name
        );
    }
}
