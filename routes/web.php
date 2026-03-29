<?php

use Illuminate\Support\Facades\Route;

// Controllers
// We will create these shortly. For now, we stub the route definitions properly.

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeWebhookController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ArAddressController as AdminArAddressController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductDocumentController as AdminProductDocumentController;

use App\Http\Controllers\Manufacturer\DashboardController as ManufacturerDashboardController;
use App\Http\Controllers\Manufacturer\CompanyController;
use App\Http\Controllers\Manufacturer\SubscriptionController;
use App\Http\Controllers\Manufacturer\NotificationController;
use App\Http\Controllers\Manufacturer\BrandController;
use App\Http\Controllers\Manufacturer\ProductController;
use App\Http\Controllers\Manufacturer\ProductDocumentController as ManufacturerProductDocumentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Public Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Stripe webhooks (no auth middleware, CSRF excluded in bootstrap/app.php)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index','show']);
    Route::post('users/{user}/block', [UserController::class, 'block'])->name('users.block');
    Route::post('users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
    Route::post('users/{user}/subscription-override', [UserController::class, 'subscriptionOverride']);
    Route::resource('categories', CategoryController::class);
    Route::resource('categories.sub-categories', ProductCategoryController::class);
    Route::resource('ar-addresses', AdminArAddressController::class);
    Route::get('products/queue', [ProductReviewController::class, 'queue'])->name('products.queue');
    Route::get('products/{product}/review', [ProductReviewController::class, 'show'])->name('products.review');
    Route::post('products/{product}/compliant', [ProductReviewController::class, 'markCompliant'])->name('products.compliant');
    Route::post('products/{product}/incompliant', [ProductReviewController::class, 'markIncompliant'])->name('products.incompliant');
    Route::post('products/{product}/reject', [ProductReviewController::class, 'reject'])->name('products.reject');
    Route::post('products/{product}/issues', [ProductReviewController::class, 'addIssue'])->name('products.issues.store');
    Route::patch('products/{product}/issues/{issue}/resolve', [ProductReviewController::class, 'resolveIssue'])->name('products.issues.resolve');
    Route::post('documents/{document}/accept', [AdminProductDocumentController::class, 'accept'])->name('documents.accept');
    Route::post('documents/{document}/reject', [AdminProductDocumentController::class, 'reject'])->name('documents.reject');
});

// Manufacturer routes
Route::prefix('app')->name('app.')->middleware(['auth', 'role:manufacturer'])->group(function () {
    Route::get('/dashboard', [ManufacturerDashboardController::class, 'index'])->name('dashboard');

    // Company (free — no subscription required)
    Route::resource('company', CompanyController::class)->only(['create','store','edit','update']);

    // Subscription (free)
    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('subscription/reactivate', [SubscriptionController::class, 'reactivate'])->name('subscription.reactivate');
    Route::get('subscription/required', [SubscriptionController::class, 'required'])->name('subscription.required');
    Route::get('subscription/billing-history', [SubscriptionController::class, 'billingHistory'])->name('subscription.billing-history');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Gated routes — require subscription
    Route::middleware('subscription')->group(function () {
        // Brand routes (full resourceful)
        Route::resource('brands', BrandController::class);

        // Product list & detail
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

        // Wizard entry point — creates draft and redirects to step 1
        Route::get('products/create/new', [ProductController::class, 'create'])->name('products.create');

        // Wizard step views
        Route::get('products/{product}/step/{step}', [ProductController::class, 'step'])
            ->where('step', '[1-6]')
            ->name('products.step');

        // Wizard step saves (POST)
        Route::post('products/{product}/step/1', [ProductController::class, 'saveStep1'])->name('products.step1.save');
        Route::post('products/{product}/step/2', [ProductController::class, 'saveStep2'])->name('products.step2.save');
        Route::post('products/{product}/step/3', [ProductController::class, 'saveStep3'])->name('products.step3.save');
        Route::post('products/{product}/step/4', [ProductController::class, 'saveStep4'])->name('products.step4.save');

        // Submit / Resubmit
        Route::post('products/{product}/submit', [ProductController::class, 'submit'])->name('products.submit');
        Route::post('products/{product}/resubmit', [ProductController::class, 'resubmit'])->name('products.resubmit');

        // Document routes (step 5 uploads + management)
        Route::post('products/{product}/documents', [ManufacturerProductDocumentController::class, 'store'])->name('products.documents.store');
        Route::get('documents/{document}/download', [ManufacturerProductDocumentController::class, 'download'])->name('documents.download');
        Route::delete('documents/{document}', [ManufacturerProductDocumentController::class, 'destroy'])->name('documents.destroy');
    });
});
