<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CatalogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\NewsletterController;

// ==============================
// PUBLIC FRONTEND ROUTES
// ==============================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'bn'])) {
        abort(400);
    }

    session(['locale' => $locale]);
    cookie()->queue('locale', $locale, 60 * 24 * 30);

    return redirect()->back()->withHeaders([
        'X-Frame-Options' => 'DENY',
        'X-Content-Type-Options' => 'nosniff'
    ]);
});


// Products
Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/category/{category:slug}', 'category')->name('category');
    Route::get('/featured-products', 'featured')->name('featured');
    Route::get('/new-arrivals', 'newArrivals')->name('new-arrivals');
    Route::get('/best-selling', 'bestSelling')->name('best-selling');
    Route::get('/recommended', 'recommended')->name('recommended');
    Route::get('/offers', 'offers')->name('offers');
});

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Brands
Route::get('/brands', [ProductController::class, 'brands'])->name('brands.index');

// Search Routes
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/popular', [SearchController::class, 'popular'])->name('search.popular');
});

// Cart Routes (available for guests and user)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Wishlist (requires auth)
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::post('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('moveToCart');
});

// Checkout (guest + user)
Route::prefix('checkout')->name('checkout.')->group(function () {
    // Cart checkout
    Route::get('/', [CheckoutController::class, 'index'])->name('index');

    // Buy Now checkout
    Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('buy-now');
    Route::get('/buy-now', [CheckoutController::class, 'buyNowCheckout'])->name('buy-now-checkout');

    // Process checkout (handles both)
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');

    // Success, failed, cancel
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/failed', [CheckoutController::class, 'failed'])->name('failed');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
});


// Order Tracking (public)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/track', [OrderController::class, 'track'])->name('track');
    Route::get('/{order}/tracking', [OrderController::class, 'tracking'])->name('tracking');
});

// Reviews
Route::middleware('auth')->prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/{product}', [ReviewController::class, 'store'])->name('store');
    Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
});

// User Profile
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ProfileController::class, 'orderDetails'])->name('order.details');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/{address}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// ========================= Start Static Pages =========================
// =========================
// About & Brand
// =========================
Route::view('/about-us', 'frontend.pages.about')->name('about');
Route::view('/technology-and-innovation', 'frontend.pages.technology')->name('technology');
Route::view('/certifications', 'frontend.pages.certifications')->name('certifications');
Route::view('/partners', 'frontend.pages.partners')->name('partners');
Route::view('/sustainability', 'frontend.pages.sustainability')->name('sustainability');
Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs');
Route::get('/catalog/view/{catalog}', [CatalogController::class, 'view'])->name('catalog.view');
Route::view('/careers', 'frontend.pages.careers')->name('careers');

// =========================    
// Support & Service
// =========================
Route::view('/contact', 'frontend.pages.contact')->name('contact');
Route::view('/support', 'frontend.pages.support')->name('support');
Route::view('/warranty', 'frontend.pages.warranty')->name('warranty');
Route::view('/service-centers', 'frontend.pages.service-centers')->name('service-centers');
Route::view('/manuals', 'frontend.pages.manuals')->name('manuals');
Route::view('/spare-parts', 'frontend.pages.spare-parts')->name('spare-parts');

// =========================
// Customer Help
// =========================
Route::view('/how-to-order', 'frontend.pages.how-to-order')->name('how-to-order');
Route::view('/shipping', 'frontend.pages.shipping')->name('shipping');
Route::view('/returns', 'frontend.pages.returns')->name('returns');
Route::view('/faq', 'frontend.pages.faq')->name('faq');

// =========================
// Legal
// =========================
Route::view('/terms', 'frontend.pages.terms')->name('terms');
Route::view('/privacy', 'frontend.pages.privacy')->name('privacy');

// ========================= End Static Pages =========================

// Contact Form
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Newsletter routes
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});
// ==============================
// AUTHENTICATED USER DASHBOARD
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    // User Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('account.orders');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/my-orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/my-orders/{order}/return', [OrderController::class, 'return'])->name('orders.return');

    // Downloads (if applicable)
    Route::get('/downloads', [ProfileController::class, 'downloads'])->name('downloads');
    // User Profile Management
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::put('/profile/password', [ProfileController::class, 'updateProfilePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount']);
});

// ==============================
// AUTH ROUTES
// ==============================
require __DIR__ . '/auth.php';

// ==============================
// ADMIN ROUTES
// ==============================
require __DIR__ . '/admin.php';
