<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }
    public function store(StoreDocumentRequest $request)
    {
        $document = $this->documentService->upload(
            $request->user(),
            $request->file('document'),
            $request->validated()['title']
        );

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
