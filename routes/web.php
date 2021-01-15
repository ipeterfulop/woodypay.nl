<?php

use App\Http\Controllers\AdminMainController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlockCopyController;
use App\Http\Controllers\BlockVisibilityController;
use App\Http\Controllers\CampaignRegistrationController;
use App\Http\Controllers\PublicMainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => config('app.allowRegistration')]);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login_post');

Route::post('/admin/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
Route::get('/admin/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

Route::middleware(['auth', 'can:access-admin'])->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/', [AdminMainController::class, 'index'])->name('admin_index');
        \App\Models\Administrator::setVueCRUDRoutes();
        \App\Models\Member::setVueCRUDRoutes();
        \App\Models\Useraction::setVueCRUDRoutes();
        \App\Models\Page::setVueCRUDRoutes();
        \App\Models\Block::setVueCRUDRoutes();
        \App\Models\TextImageItem::setVueCRUDRoutes();
        \App\Models\CollectionTextImageList::setVueCRUDRoutes();

        Route::post('/blocks/visibility', [BlockVisibilityController::class, 'update'])->name('block_visibility_endpoint');
        Route::post('/blocks/copy', [BlockCopyController::class, 'copy'])->name('copy_block_endpoint');
    });
});
Route::middleware(['auth'])->group(function() {
    Route::get('/profile/verify', [PublicMainController::class, 'verificationNotice'])->name('verification.notice');
    Route::post('/profile/verify', [PublicMainController::class, 'sendVerificationLink'])->name('verification.link');
});
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profile', [PublicMainController::class, 'profile'])->name('user_profile');
});
Route::middleware(['auth', 'signed'])->group(function() {
    Route::get('/profile/verify/{id}/{hash}', [PublicMainController::class, 'verifyEmail'])->name('verification.verify');
});

Route::get('/', [PublicMainController::class, 'index'])->name('public_index');
Route::view('/f', 'wlt');
//Route::post('/wlt', [CampaignRegistrationController::class, 'register'])->name('campaign_registration');
\App\Models\Page::setRoutes();
