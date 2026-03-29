<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    public function view(User $user, Brand $brand): bool
    {
        return $user->company && $user->company->id === $brand->company_id;
    }

    public function update(User $user, Brand $brand): bool
    {
        return $user->company && $user->company->id === $brand->company_id;
    }

    public function delete(User $user, Brand $brand): bool
    {
        return $user->company && $user->company->id === $brand->company_id;
    }
}
