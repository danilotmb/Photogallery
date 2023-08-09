<?php

use App\Events\NewAlbumCreated;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PhotosController;
use App\Mail\TestEmail;
use App\Mail\TestMd;
use App\Models\Album;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('/', fn() => redirect()->route('gallery.index'));

Route::middleware(['auth'])->prefix('dashboard')->group(function () 
{
    Route::get('/users', function () 
    {
        return User::with('albums')->paginate(5);
    });

    Route::resource('/albums', AlbumsController::class);

    Route::get('/', [AlbumsController::class, 'index']);

    Route::get('/albums/{album}/images', [AlbumsController::class, 'getImages'])->name('albums.images');

    Route::resource('photos', PhotosController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/albums/{album}/edit', [AlbumsController::class, 'edit'])->name('albums.edit');

    Route::patch('/albums/{album}/update', [AlbumsController::class, 'update'])->name('albums.update');

    

 
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//mail
Route::get('testMail', function() {
    $user = User::get()->first();
    Mail::to(Auth::user())->send(new TestMd($user));
});

Route::get('testEvent', function () {
    $album = Album::first();
    event(new NewAlbumCreated($album));
});


//gallery 
Route::group(['prefix' => 'gallery'], function(){
    Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('albums', [GalleryController::class, 'index']);
    Route::get('album/{album}/images', [GalleryController::class, 'showAlbumImages']) ->name('gallery.albums.images');

});
require __DIR__ . '/auth.php';