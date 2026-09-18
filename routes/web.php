<?php
use App\Http\Controllers\{AdminController, AdminSettingsController, AuthController, InstallController, PostController, PublicController, CommentController, ProfileController};
use Illuminate\Support\Facades\Route;

Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'store'])->name('install.store');

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/news/{post:slug}', [PublicController::class, 'show'])->name('news.show');
Route::get('/category/{category:slug}', [PublicController::class, 'category'])->name('category.show');
Route::get('/search', [PublicController::class, 'search'])->name('search');
Route::post('/news/{post}/like', [PublicController::class, 'like'])->middleware('throttle:30,1')->name('news.like');
Route::post('/news/{post}/comments', [PublicController::class, 'comment'])->middleware('throttle:10,1')->name('news.comments.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::view('/', 'dashboard.index')->name('index');
    Route::resource('posts', PostController::class)->except(['show', 'destroy']);
});

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::post('/posts/{post}/approve', [AdminController::class, 'approve'])->name('posts.approve');
    Route::post('/posts/{post}/reject', [AdminController::class, 'reject'])->name('posts.reject');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/smtp', [AdminSettingsController::class, 'smtp'])->name('settings.smtp');
    Route::post('/settings', [AdminSettingsController::class, 'store'])->name('settings.store');
    Route::post('/settings/test-email', [AdminSettingsController::class, 'testEmail'])->name('settings.test-email');
});
