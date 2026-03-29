<?php

namespace App\Services;

use App\Enums\DocumentStatus;
use App\Enums\ProductStatus;
use App\Notifications\ProductReviewNotification;
use App\Repositories\Contracts\ProductIssueRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AdminModerationService
{
    public function __construct(
        protected ProductRepositoryInterface      $repo,
        protected ProductIssueRepositoryInterface $issueRepo,
        protected AuditLogService                 $auditService,
    ) {}

    public function markCompliant(int|string $id, int $adminId): \App\Models\Product
    {
        return DB::transaction(function () use ($id, $adminId) {
            $product = $this->repo->find($id);

            if ($product->status !== ProductStatus::InReview) {
                throw new \Exception('Only products with status "In Review" can be marked compliant.');
            }

            if (!$product->documents()->where('status', DocumentStatus::Accepted)->exists()) {
                throw new \Exception('At least one document must be accepted before marking compliant.');
            }

            $product->status      = ProductStatus::Compliant;
            $product->reviewed_at = now();
            $product->save();

            $this->auditService->log($adminId, 'Marked Compliant', 'Product', $product->id);

            $product->company->user->notify(
                new ProductReviewNotification($product, 'compliant')
            );

            return $product;
        });
    }

    public function markIncompliant(int|string $id, int $adminId): \App\Models\Product
    {
        return DB::transaction(function () use ($id, $adminId) {
            $product = $this->repo->find($id);

            if ($product->status !== ProductStatus::InReview) {
                throw new \Exception('Only products with status "In Review" can be marked incompliant.');
            }

            if (!$product->issues()->where('is_resolved', false)->exists()) {
                throw new \Exception('At least one open issue must exist before marking incompliant.');
            }

            $product->status = ProductStatus::Incompliant;
            $product->save();

            $this->auditService->log($adminId, 'Marked Incompliant', 'Product', $product->id);

            $product->company->user->notify(
                new ProductReviewNotification($product, 'incompliant')
            );

            return $product;
        });
    }

    public function reject(int|string $id, int $adminId, string $reason): \App\Models\Product
    {
        return DB::transaction(function () use ($id, $adminId, $reason) {
            $product = $this->repo->find($id);

            if ($product->status === ProductStatus::Rejected) {
                throw new \Exception('This product has already been rejected.');
            }

            $product->status = ProductStatus::Rejected;
            $product->save();

            $this->auditService->log($adminId, 'Rejected', 'Product', $product->id, $reason);

            $product->company->user->notify(
                new ProductReviewNotification($product, 'rejected', $reason)
            );

            return $product;
        });
    }

    public function addIssue(int|string $productId, int $adminId, string $text): \App\Models\ProductIssue
    {
        return DB::transaction(function () use ($productId, $adminId, $text) {
            $issue = $this->issueRepo->create([
                'product_id' => $productId,
                'admin_id'   => $adminId,
                'issue_text' => $text,
                'is_resolved' => false,
                'created_at' => now(),
            ]);

            $product = $this->repo->find($productId);
            if ($product->status !== ProductStatus::Incompliant) {
                $product->status = ProductStatus::Incompliant;
                $product->save();
            }

            $this->auditService->log($adminId, 'Added Issue', 'Product', $productId, $text);

            return $issue;
        });
    }

    public function resolveIssue(int|string $issueId, int $adminId): \App\Models\ProductIssue
    {
        $issue = $this->issueRepo->update($issueId, ['is_resolved' => true]);

        $this->auditService->log($adminId, 'Resolved Issue', 'ProductIssue', $issueId);

        return $issue;
    }
}
