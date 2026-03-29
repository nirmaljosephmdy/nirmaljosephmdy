<?php
namespace App\Http\Controllers\Manufacturer;
use App\Http\Controllers\Controller;
use App\Services\DocumentService;
use App\Http\Requests\Manufacturer\StoreProductDocumentRequest;
use App\Support\ApiResponse;
class ProductDocumentController extends Controller {
 public function store(StoreProductDocumentRequest $request, $product, DocumentService $service) { $doc = $service->addDocument($product, $request->validated(), auth()->id()); return $request->expectsJson() ? ApiResponse::success($doc) : redirect()->back()->with('success', 'Document uploaded'); }
 public function destroy($document, DocumentService $service) { $service->deleteDocument($document); return request()->expectsJson() ? ApiResponse::success(null) : redirect()->back(); }
 public function download($document, DocumentService $service) { $doc = $service->getDocument($document); return response()->download(storage_path('app/private/' . $doc->file_path), $doc->title ?? 'document'); }
}