<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\ProfileViewController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// ── Public ──
Route::get('/', fn() => view('home'))->name('home');
Route::get('/login', fn() => redirect('/')->with('open_login', true))->name('login');

// Add to public routes
Route::get('/privacy-policy',  [PageController::class, 'show'])->defaults('slug', 'privacy-policy')->name('page.privacy');
Route::get('/terms-of-service',[PageController::class, 'show'])->defaults('slug', 'terms-of-service')->name('page.terms');
Route::get('/page/{slug}',     [PageController::class, 'show'])->name('page.show');

// Paystack webhook — server-to-server, no session/auth, must stay public
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// ── Auth ──
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login',    [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
Route::post('/forgot-password/send-code',   [ForgotPasswordController::class, 'sendCode'])->middleware('throttle:5,1')->name('password.send-code');
Route::post('/forgot-password/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify-code');
Route::post('/forgot-password/reset',       [ForgotPasswordController::class, 'reset'])->name('password.reset');

// ── Authenticated ──
Route::middleware('auth')->group(function () {
    Route::get('/setup/location',   [AuthController::class, 'locationSetup'])->name('setup.location');
    Route::post('/setup/location',  [AuthController::class, 'saveLocation'])->name('setup.location.save');
    Route::get('/setup/photos',     [AuthController::class, 'photoSetup'])->name('setup.photos');
    Route::post('/setup/photos',    [AuthController::class, 'savePhotos'])->name('setup.photos.save');

    Route::get('/discover',         [DiscoverController::class, 'index'])->name('discover');
    Route::post('/swipe',           [DiscoverController::class, 'swipe'])->name('swipe');

    Route::get('/favourites',       [FavouriteController::class, 'index'])->name('favourites');

    Route::get('/profile/{id}',     [ProfileViewController::class, 'show'])->name('profile.view');
    Route::post('/favourite/{id}',  [FavouriteController::class, 'toggle'])->name('favourite.toggle');

    Route::get('/pricing',          [PaymentController::class, 'index'])->name('pricing');
    Route::post('/payment/initiate',[PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    Route::get('/my-profile',           [ProfileController::class, 'show'])->name('profile');
    Route::post('/my-profile/update',   [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/my-profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/chat',                  [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}',             [ChatController::class, 'open'])->name('chat.open');
    Route::post('/chat/send',            [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{id}/unread-check',[ChatController::class, 'unreadCheck'])->name('chat.unread.check');

    Route::get('/matches', [MatchController::class, 'index'])->name('matches');
    Route::delete('/chat/message/{id}', [ChatController::class, 'deleteMessage'])->name('chat.message.delete');
    Route::delete('/chat/conversation/{id}', [ChatController::class, 'deleteConversation'])->name('chat.conversation.delete');
    Route::post('/my-profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');

    Route::post('/my-profile/photos', [ProfileController::class, 'uploadPhotos'])->name('profile.photos.upload');
    Route::delete('/my-profile/photos/{id}', [ProfileController::class, 'deletePhoto'])->name('profile.photos.delete');
    
    Route::get('/discover/load-more', [DiscoverController::class, 'loadMore'])->name('discover.loadMore');
});

// ── Admin ──
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/',                           [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users',                      [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}',                 [AdminController::class, 'viewUser'])->name('admin.user.view');
    Route::post('/users/{id}/toggle-premium', [AdminController::class, 'toggleAdmin'])->name('admin.user.toggle');
    Route::delete('/users/{id}',              [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::get('/packages',                   [AdminController::class, 'packages'])->name('admin.packages');
    Route::post('/packages',                  [AdminController::class, 'createPackage'])->name('admin.packages.create');
    Route::post('/packages/{id}/toggle',      [AdminController::class, 'togglePackage'])->name('admin.packages.toggle');
    Route::get('/payments',                   [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/pages',           [AdminController::class, 'pages'])->name('admin.pages');
Route::get('/pages/{slug}/edit',[AdminController::class, 'editPage'])->name('admin.pages.edit');
Route::post('/pages/{slug}',   [AdminController::class, 'updatePage'])->name('admin.pages.update');
Route::get('/packages/{id}/edit',  [AdminController::class, 'editPackage'])->name('admin.packages.edit');
Route::post('/packages/{id}/update',[AdminController::class, 'updatePackage'])->name('admin.packages.update');
Route::post('/users/{id}/reactivate', [AdminController::class, 'reactivateUser'])->name('admin.user.reactivate');
Route::post('/users/{id}/toggle-featured', [AdminController::class, 'toggleFeatured'])->name('admin.user.toggleFeatured');
Route::post('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.user.deactivate');
});