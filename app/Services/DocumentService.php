<?php

namespace App\Services;

use App\Enums\DocumentStatus;
use App\Repositories\Contracts\ProductDocumentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function __construct(
        protected ProductDocumentRepositoryInterface $repo,
        protected AuditLogService                    $auditService,
    ) {}

    public function addDocument(int|string $productId, array $data, int $userId): \App\Models\ProductDocument
    {
        $file    = $data['file'];
        $path    = $file->store('documents', 'private');
        $version = $this->repo->all()
            ->where('product_id', $productId)
            ->where('document_type', $data['document_type'])
            ->max('version') ?? 0;

        return $this->repo->create([
            'product_id'    => $productId,
            'uploaded_by'   => $userId,
            'document_type' => $data['document_type'],
            'title'         => $data['title'] ?? null,
            'file_path'     => $path,
            'file_size'     => $file->getSize(),
            'mime_type'     => $file->getMimeType(),
            'version'       => $version + 1,
            'status'        => DocumentStatus::Pending,
        ]);
    }

    public function deleteDocument(int|string $id): bool
    {
        $doc = $this->repo->find($id);
        Storage::disk('private')->delete($doc->file_path);
        return $this->repo->delete($id);
    }

    public function acceptDocument(int|string $id, ?int $adminId = null): \App\Models\ProductDocument
    {
        return DB::transaction(function () use ($id, $adminId) {
            $doc = $this->repo->update($id, ['status' => DocumentStatus::Accepted]);

            if ($adminId) {
                $this->auditService->log($adminId, 'Accepted Document', 'ProductDocument', $id);
            }

            return $doc;
        });
    }

    public function rejectDocument(int|string $id, string $note, ?int $adminId = null): \App\Models\ProductDocument
    {
        return DB::transaction(function () use ($id, $note, $adminId) {
            $doc = $this->repo->update($id, [
                'status'     => DocumentStatus::Rejected,
                'admin_note' => $note,
            ]);

            if ($adminId) {
                $this->auditService->log($adminId, 'Rejected Document', 'ProductDocument', $id, $note);
            }

            return $doc;
        });
    }

    public function getDocument(int|string $id): \App\Models\ProductDocument
    {
        return $this->repo->find($id);
    }
}
