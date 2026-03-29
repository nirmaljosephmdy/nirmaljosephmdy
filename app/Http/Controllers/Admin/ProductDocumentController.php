<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DocumentService;
use App\Support\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductDocumentController extends Controller
{
    public function accept(int $document, DocumentService $service): RedirectResponse
    {
        try {
            $service->acceptDocument($document, auth()->id());
            return redirect()->back()->with('success', 'Document accepted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(int $document, Request $request, DocumentService $service): RedirectResponse
    {
        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        try {
            $service->rejectDocument($document, $request->input('admin_note'), auth()->id());
            return redirect()->back()->with('success', 'Document rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
