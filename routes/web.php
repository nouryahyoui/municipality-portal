<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\OfficialController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->middleware('web')->name('setLocale');

Route::prefix('articles')->group(function () {
    Route::get('/', [PublicArticleController::class, 'index'])->name('articles.index');
    Route::get('/category/{category}', [PublicArticleController::class, 'byCategory'])->name('articles.category');
    Route::get('/{slug}', [PublicArticleController::class, 'show'])->name('articles.show');
});

Route::prefix('events')->group(function () {
    Route::get('/', [PublicEventController::class, 'index'])->name('events.index');
    Route::get('/{slug}', [PublicEventController::class, 'show'])->name('events.show');
});

// Public Services Routes (auth required)
Route::middleware('auth')->prefix('services')->group(function () {
    Route::get('/request', [App\Http\Controllers\Public\ServiceController::class, 'requestForm'])->name('services.request');
    Route::post('/request', [App\Http\Controllers\Public\ServiceController::class, 'submitRequest'])->name('services.request.submit');
    Route::get('/complaint', [App\Http\Controllers\Public\ServiceController::class, 'complaintForm'])->name('services.complaint');
    Route::post('/complaint', [App\Http\Controllers\Public\ServiceController::class, 'submitComplaint'])->name('services.complaint.submit');
});

Route::middleware(['web', 'auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('articles', ArticleController::class, ['as' => 'admin']);
    Route::post('articles/{article}/publish', [ArticleController::class, 'publish'])->name('admin.articles.publish');
    Route::post('articles/{article}/archive', [ArticleController::class, 'archive'])->name('admin.articles.archive');

    Route::resource('news', NewsController::class, ['as' => 'admin']);

    Route::resource('events', EventController::class, ['as' => 'admin']);
    Route::get('events/{event}/registrations', [EventController::class, 'registrations'])->name('admin.events.registrations');

    Route::resource('galleries', GalleryController::class, ['as' => 'admin']);
    Route::post('galleries/{gallery}/images', [GalleryController::class, 'addImage'])->name('admin.galleries.addImage');
    Route::delete('gallery-images/{image}', [GalleryController::class, 'removeImage'])->name('admin.galleries.removeImage');

    Route::prefix('requests')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('admin.requests.index');
        Route::get('/statistics', [RequestController::class, 'statistics'])->name('admin.requests.statistics');
        Route::get('/{request}', [RequestController::class, 'show'])->name('admin.requests.show');
        Route::post('/{request}/assign', [RequestController::class, 'assign'])->name('admin.requests.assign');
        Route::post('/{request}/status', [RequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
        Route::post('/{request}/complete', [RequestController::class, 'complete'])->name('admin.requests.complete');
    });

    Route::prefix('complaints')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('admin.complaints.index');
        Route::get('/statistics', [ComplaintController::class, 'statistics'])->name('admin.complaints.statistics');
        Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('admin.complaints.show');
        Route::post('/{complaint}/assign', [ComplaintController::class, 'assign'])->name('admin.complaints.assign');
        Route::post('/{complaint}/respond', [ComplaintController::class, 'respond'])->name('admin.complaints.respond');
        Route::post('/{complaint}/close', [ComplaintController::class, 'close'])->name('admin.complaints.close');
    });

    Route::resource('departments', DepartmentController::class, ['as' => 'admin']);
    Route::resource('officials', OfficialController::class, ['as' => 'admin']);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::post('permissions/assign-role/{user}', [App\Http\Controllers\Admin\PermissionController::class, 'assignRole'])->name('admin.permissions.assignRole');
    Route::get('audit', [App\Http\Controllers\Admin\AuditController::class, 'index'])->name('admin.audit.index');
});

Route::middleware('auth')->group(function () {
    Route::post('events/{event}/register', [PublicEventController::class, 'register'])->name('events.register');
    Route::delete('event-registrations/{registration}', [PublicEventController::class, 'cancelRegistration'])->name('events.cancelRegistration');
});

require __DIR__.'/auth.php';