<?php

use App\Http\Controllers\Admin\AdBannerController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ==============================
// ADMIN ROUTES (Admin Only)
// ==============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk/delete', [UserController::class, 'bulkDelete'])->name('bulk.delete');
        Route::post('/bulk/activate', [UserController::class, 'bulkActivate'])->name('bulk.activate');
        Route::post('/bulk/deactivate', [UserController::class, 'bulkDeactivate'])->name('bulk.deactivate');

        // Single Actions
        Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
        Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
        Route::post('/{user}/impersonate', [UserController::class, 'impersonate'])->name('impersonate');
    });

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('index');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::put('/password', [ProfileController::class, 'updateProfilePassword'])->name('password.update');
        Route::delete('/delete', [ProfileController::class, 'deleteAccount'])->name('delete');
    });

    // Products Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/change-status', [ProductController::class, 'changeStatus'])->name('changeStatus');

        // Bulk Actions
        Route::post('/bulk/action', [ProductController::class, 'bulkActon'])->name('bulk-action');
        Route::post('/bulk/delete', [ProductController::class, 'bulkDelete'])->name('bulk.delete');
        Route::post('/bulk/activate', [ProductController::class, 'bulkActivate'])->name('bulk.activate');
        Route::post('/bulk/deactivate', [ProductController::class, 'bulkDeactivate'])->name('bulk.deactivate');
        Route::post('/bulk/feature', [ProductController::class, 'bulkFeature'])->name('bulk.feature');

        // Single Actions
        Route::post('/{product}/toggle-feature', [ProductController::class, 'toggleFeature'])->name('toggle.feature');
        Route::post('/{product}/toggle-bestseller', [ProductController::class, 'toggleBestseller'])->name('toggle.bestseller');
        Route::post('/{product}/toggle-new', [ProductController::class, 'toggleNew'])->name('toggle.new');
        Route::post('/{product}/update-stock', [ProductController::class, 'updateStock'])->name('update.stock');
        Route::post('/{product}/duplicate', [ProductController::class, 'duplicate'])->name('duplicate');

        // Images
        Route::post('/{product}/images', [ProductController::class, 'uploadImages'])->name('upload.images');
        Route::delete('/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('delete.image');
        Route::post('/{product}/images/reorder', [ProductController::class, 'reorderImages'])->name('reorder.images');

        // Export/Import
        Route::get('/export', [ProductController::class, 'export'])->name('export');
        Route::post('/import', [ProductController::class, 'import'])->name('import');
        Route::get('/import/template', [ProductController::class, 'importTemplate'])->name('import.template');
    });

    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');

        // Actions
        Route::post('/{category}/toggle-feature', [CategoryController::class, 'toggleFeature'])->name('toggle.feature');
        Route::post('/{category}/change-status', [CategoryController::class, 'changeStatus'])->name('change.status');
        Route::post('/{category}/reorder', [CategoryController::class, 'reorder'])->name('reorder');

        // Bulk Actions
        Route::post('/bulk/delete', [CategoryController::class, 'bulkDelete'])->name('bulk.delete');
        Route::post('/bulk/activate', [CategoryController::class, 'bulkActivate'])->name('bulk.activate');
        Route::post('/bulk/deactivate', [CategoryController::class, 'bulkDeactivate'])->name('bulk.deactivate');
    });

    Route::prefix('offer')->name('offers.')->group(function () {
        Route::get('/', [OfferController::class, 'index'])->name('index');
        Route::get('/create', [OfferController::class, 'create'])->name('create');
        Route::post('/', [OfferController::class, 'store'])->name('store');
        Route::get('/{offer}', [OfferController::class, 'show'])->name('show');
        Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('edit');
        Route::put('/{offer}', [OfferController::class, 'update'])->name('update');
        Route::delete('/{offer}', [OfferController::class, 'destroy'])->name('destroy');
        Route::post('{offer}/toggle-status', [OfferController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('reorder', [OfferController::class, 'reorder'])->name('reorder');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');

        // Order Actions
        Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update.status');
        Route::post('/{order}/update-payment', [OrderController::class, 'updatePayment'])->name('update.payment');
        Route::post('/{order}/add-note', [OrderController::class, 'addNote'])->name('add.note');
        Route::post('/{order}/send-invoice', [OrderController::class, 'sendInvoice'])->name('send.invoice');
        Route::post('/{order}/resend-confirmation', [OrderController::class, 'resendConfirmation'])->name('resend.confirmation');
        Route::post('/{order}/ship', [OrderController::class, 'ship'])->name('ship');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/refund', [OrderController::class, 'refund'])->name('refund');

        // Export
        Route::get('/export', [OrderController::class, 'export'])->name('export');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');

        // Order Items
        Route::post('/{order}/items', [OrderController::class, 'addItem'])->name('items.add');
        Route::put('/{order}/items/{item}', [OrderController::class, 'updateItem'])->name('items.update');
        Route::delete('/{order}/items/{item}', [OrderController::class, 'deleteItem'])->name('items.delete');
    });

    // Reviews Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');

        // Bulk Actions
        Route::post('/bulk/approve', [ReviewController::class, 'bulkApprove'])->name('bulk.approve');
        Route::post('/bulk/reject', [ReviewController::class, 'bulkReject'])->name('bulk.reject');
        Route::post('/bulk/delete', [ReviewController::class, 'bulkDelete'])->name('bulk.delete');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('dashboard');
        Route::get('/sales', [AnalyticsController::class, 'sales'])->name('sales');
        Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('revenue');
        Route::get('/customers', [AnalyticsController::class, 'customers'])->name('customers');
        Route::get('/products', [AnalyticsController::class, 'products'])->name('products');
        Route::get('/orders', [AnalyticsController::class, 'orders'])->name('orders');

        // Reports
        Route::get('/reports/sales', [AnalyticsController::class, 'salesReport'])->name('reports.sales');
        Route::get('/reports/customers', [AnalyticsController::class, 'customersReport'])->name('reports.customers');
        Route::get('/reports/products', [AnalyticsController::class, 'productsReport'])->name('reports.products');

        // Export
        Route::get('/export/{type}', [AnalyticsController::class, 'export'])->name('export');

        // Data
        Route::get('/data/sales-over-time', [AnalyticsController::class, 'salesOverTime'])->name('data.salesOverTime');
        Route::get('/data/top-products', [AnalyticsController::class, 'topProducts'])->name('data.topProducts');
        Route::get('/data/top-categories', [AnalyticsController::class, 'topCategories'])->name('data.topCategories');
        Route::get('/data/top-customers', [AnalyticsController::class, 'topCustomers'])->name('data.topCustomers');
    });

    // Content Management
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');

        Route::resource('ad-banners', AdBannerController::class)->except('show');
        Route::resource('sections', SectionController::class)->except('show');
        Route::resource('catalogs', CatalogController::class);

        // Pages
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', [ContentController::class, 'pages'])->name('index');
            Route::get('/create', [ContentController::class, 'createPage'])->name('create');
            Route::post('/', [ContentController::class, 'storePage'])->name('store');
            Route::get('/{page}/edit', [ContentController::class, 'editPage'])->name('edit');
            Route::put('/{page}', [ContentController::class, 'updatePage'])->name('update');
            Route::delete('/{page}', [ContentController::class, 'destroyPage'])->name('destroy');
            Route::post('/{page}/toggle-status', [ContentController::class, 'togglePageStatus'])->name('toggle.status');
        });

        // Blog Posts
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [ContentController::class, 'posts'])->name('index');
            Route::get('/create', [ContentController::class, 'createPost'])->name('create');
            Route::post('/', [ContentController::class, 'storePost'])->name('store');
            Route::get('/{post}/edit', [ContentController::class, 'editPost'])->name('edit');
            Route::put('/{post}', [ContentController::class, 'updatePost'])->name('update');
            Route::delete('/{post}', [ContentController::class, 'destroyPost'])->name('destroy');
            Route::post('/{post}/publish', [ContentController::class, 'publishPost'])->name('publish');
            Route::post('/{post}/archive', [ContentController::class, 'archivePost'])->name('archive');
        });

        // FAQs
        Route::prefix('faqs')->name('faqs.')->group(function () {
            Route::get('/', [ContentController::class, 'faqs'])->name('index');
            Route::get('/create', [ContentController::class, 'createFaq'])->name('create');
            Route::post('/', [ContentController::class, 'storeFaq'])->name('store');
            Route::get('/{faq}/edit', [ContentController::class, 'editFaq'])->name('edit');
            Route::put('/{faq}', [ContentController::class, 'updateFaq'])->name('update');
            Route::delete('/{faq}', [ContentController::class, 'destroyFaq'])->name('destroy');
            Route::post('/{faq}/toggle-status', [ContentController::class, 'toggleFaqStatus'])->name('toggle.status');
            Route::post('/reorder', [ContentController::class, 'reorderFaqs'])->name('reorder');
        });
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        // General Settings
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('update.general');

        // Store Settings
        Route::get('/store', [SettingsController::class, 'store'])->name('store');
        Route::put('/store', [SettingsController::class, 'updateStore'])->name('update.store');

        // Email Settings
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::put('/email', [SettingsController::class, 'updateEmail'])->name('update.email');

        // Payment Settings
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::put('/payment', [SettingsController::class, 'updatePayment'])->name('update.payment');

        // Shipping Settings
        Route::get('/shipping', [SettingsController::class, 'shipping'])->name('shipping');
        Route::put('/shipping', [SettingsController::class, 'updateShipping'])->name('update.shipping');

        // Tax Settings
        Route::get('/tax', [SettingsController::class, 'tax'])->name('tax');
        Route::put('/tax', [SettingsController::class, 'updateTax'])->name('update.tax');

        // Social Media
        Route::get('/social', [SettingsController::class, 'social'])->name('social');
        Route::put('/social', [SettingsController::class, 'updateSocial'])->name('update.social');

        // SEO Settings
        Route::get('/seo', [SettingsController::class, 'seo'])->name('seo');
        Route::put('/seo', [SettingsController::class, 'updateSeo'])->name('update.seo');

        // Roles & Permissions
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [SettingsController::class, 'roles'])->name('index');
            Route::get('/create', [SettingsController::class, 'createRole'])->name('create');
            Route::post('/', [SettingsController::class, 'storeRole'])->name('store');
            Route::get('/{role}/edit', [SettingsController::class, 'editRole'])->name('edit');
            Route::put('/{role}', [SettingsController::class, 'updateRole'])->name('update');
            Route::delete('/{role}', [SettingsController::class, 'destroyRole'])->name('destroy');
            Route::post('/{role}/permissions', [SettingsController::class, 'syncPermissions'])->name('sync.permissions');
        });

        // Permissions
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [SettingsController::class, 'permissions'])->name('index');
            Route::post('/', [SettingsController::class, 'storePermission'])->name('store');
            Route::get('settings/permissions/{permission}', [SettingsController::class, 'getPermission'])->name('show');
            Route::put('/{permission}', [SettingsController::class, 'updatePermission'])->name('update');
            Route::delete('/{permission}', [SettingsController::class, 'destroyPermission'])->name('destroy');
        });

        // Backup & Maintenance
        Route::get('/maintenance', [SettingsController::class, 'maintenance'])->name('maintenance');
        Route::post('/cache/clear', [SettingsController::class, 'clearCache'])->name('cache.clear');
        Route::post('/view/clear', [SettingsController::class, 'clearView'])->name('view.clear');
        Route::post('/backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
        Route::post('/optimize', [SettingsController::class, 'optimize'])->name('optimize');
    });

    // Media Library
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
        Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
        Route::post('/folder', [MediaController::class, 'createFolder'])->name('folder.create');
        Route::delete('/folder/{folder}', [MediaController::class, 'deleteFolder'])->name('folder.delete');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Hero Slides Management
    Route::prefix('hero-slides')->name('hero-slides.')->group(function () {
        Route::get('/', [HeroSlideController::class, 'index'])->name('index');
        Route::get('/create', [HeroSlideController::class, 'create'])->name('create');
        Route::post('/', [HeroSlideController::class, 'store'])->name('store');
        Route::get('/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('edit');
        Route::put('/{heroSlide}', [HeroSlideController::class, 'update'])->name('update');
        Route::delete('/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('destroy');

        // Actions
        Route::post('/{heroSlide}/toggle-status', [HeroSlideController::class, 'toggleStatus'])->name('toggle.status');
        Route::post('/reorder', [HeroSlideController::class, 'reorder'])->name('reorder');
    });
});
// ==============================
// MODERATOR ROUTES (Admin + Moderator)
// ==============================
Route::middleware(['auth', 'role:admin,moderator'])->prefix('moderate')->name('moderate.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'moderate'])->name('dashboard');

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'moderate'])->name('index');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
    });

    // Orders
    Route::get('/orders', [OrderController::class, 'moderate'])->name('orders');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update.status');

    // Content
    Route::get('/content', [ContentController::class, 'moderate'])->name('content');
});

// ==============================
// VENDOR ROUTES (if applicable)
// ==============================
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'vendor'])->name('dashboard');

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'vendor'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'vendor'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update.status');
    });
});
