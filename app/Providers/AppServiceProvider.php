<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\Contracts\CompanyRepositoryInterface::class, \App\Repositories\Eloquent\CompanyRepository::class);
        $this->app->bind(\App\Repositories\Contracts\BrandRepositoryInterface::class, \App\Repositories\Eloquent\BrandRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ArAddressRepositoryInterface::class, \App\Repositories\Eloquent\ArAddressRepository::class);
        $this->app->bind(\App\Repositories\Contracts\CategoryRepositoryInterface::class, \App\Repositories\Eloquent\CategoryRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ProductCategoryRepositoryInterface::class, \App\Repositories\Eloquent\ProductCategoryRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PlanRepositoryInterface::class, \App\Repositories\Eloquent\PlanRepository::class);
        $this->app->bind(\App\Repositories\Contracts\SubscriptionRepositoryInterface::class, \App\Repositories\Eloquent\SubscriptionRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ProductRepositoryInterface::class, \App\Repositories\Eloquent\ProductRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ProductImageRepositoryInterface::class, \App\Repositories\Eloquent\ProductImageRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ProductIssueRepositoryInterface::class, \App\Repositories\Eloquent\ProductIssueRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ProductDocumentRepositoryInterface::class, \App\Repositories\Eloquent\ProductDocumentRepository::class);
        $this->app->bind(\App\Repositories\Contracts\AdminAuditLogRepositoryInterface::class, \App\Repositories\Eloquent\AdminAuditLogRepository::class);
        $this->app->bind(\App\Repositories\Contracts\UserRepositoryInterface::class, \App\Repositories\Eloquent\UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
