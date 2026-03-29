<?php

namespace App\Policies;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function view(User $user, Product $product): bool
    {
        return $user->company && $user->company->id === $product->company_id;
    }

    public function update(User $user, Product $product): bool
    {
        if (!$user->company || $user->company->id !== $product->company_id) {
            return false;
        }

        return in_array($product->status, [ProductStatus::Draft, ProductStatus::Incompliant]);
    }

    public function submit(User $user, Product $product): bool
    {
        return $this->update($user, $product);
    }

    public function resubmit(User $user, Product $product): bool
    {
        return $user->company
            && $user->company->id === $product->company_id
            && $product->status === ProductStatus::Incompliant;
    }
}
