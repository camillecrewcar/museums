<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OpinionsController;
use App\Http\Controllers\ThreadsController;
use App\Models\Tags;
use Illuminate\Support\Facades\Route;

Route::get('/', [TagsController::class, 'index'])->name('root');
Route::get('/tags/{id}', [TagsController::class, 'index'])->name('tags.index');
Route::get('/tags/searchFor/tag', [TagsController::class, 'search'])->name('tags.search');



Route::get('/threads/{id}', [ThreadsController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadsController::class, 'store'])->name('threads.store');
Route::delete('/threadsDelete/{id}', [ThreadsController::class, 'destroy'])->name('thread.destroy');


Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');


Route::get('/cities/search', [CitiesController::class, 'search'])->name('cities.search');
Route::get('/places/{id}', [PlacesController::class, 'show'])->name('place.show');
Route::post('/places/{id}', [OpinionsController::class, 'addOpinion'])->name('opinion.add');
Route::get('/places', [CitiesController::class, 'index'])->name('places');
Route::get('/places/create/place', [PlacesController::class, 'create'])->name('places.create');
Route::post('/places', [PlacesController::class, 'store'])->name('places.store');
Route::put('/places/{opinion}', [OpinionsController::class, 'update'])->name('opinions.update');


Route::delete('/places/{opinion}', [OpinionsController::class, 'destroy'])->name('opinions.destroy');

// Logout Route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Login Route
Route::get('/login', function () {

    $tags = Tags::all();
    return view('root', compact('tags'));
})->name('login');
Route::post('/comments/like', [LikesController::class, 'like'])->name('likes.like');
Route::post('/comments/dislike', [LikesController::class, 'dislike'])->name('likes.dislike');
Route::post('/comments/unlike',  [LikesController::class, 'unlike'])->name('comments.unlike');
Route::post('/comments/undislike',  [LikesController::class, 'undislike'])->name('comments.undislike');



// Dashboard Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('role:1')->group(function () {
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/places/{id}/toggle-verification', [UserController::class, 'toggleVerification'])->name('admin.places.toggleVerification');
});


require __DIR__.'/auth.php';
