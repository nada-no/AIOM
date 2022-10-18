<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Player;
use App\Http\Controllers\PlaylistController;
use App\Http\Resources\SongCollection;
use App\Models\Song;
use GuzzleHttp\Psr7\Request;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/pruebas', function () {
    return view('playlist');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [SongController::class, 'listDashboard'])->name('listDashboard');
    Route::get('/upload/song', function () {
        return view('upload_song');
    });
    Route::post('/addSong', [SongController::class, 'addSong'])->name('addSong');
    Route::get('/music', [SongController::class, 'index']);

    Route::get('/player/{idSong}', [Player::class, 'playSong']);
    Route::get('/player', [Player::class, 'playQueue']);

    Route::get('/profile', function () {
        return view('profile');
    });
    Route::post('/updateAccount', [AccountController::class, 'updateAccount'])->name('updateAccount');

    Route::post('/deleteAccount', [AccountController::class, 'deleteAccount'])->name('deleteAccount');

    Route::get('/playlists', [PlaylistController::class, 'list']);

    Route::any('/music/addFavorites/{idSong}', [SongController::class, 'addFavorites'])->name('addFavorites');

    Route::post('/addQueue', [SongController::class, 'addQueue'])->name('addQueue');
    
    Route::get('/queue', function () {
        return view('queue');
    });

    Route::post('/addPlaylist', [PlaylistController::class, 'new'])->name('addPlaylist');

    Route::get('/playlists/{idPlaylist}', [PlaylistController::class, 'show']);

    Route::get('/playlists/play/{idPlaylist}', [Player::class, 'playPlaylist']);


    Route::get('/playlists/delete/{idPlaylist}', [PlaylistController::class, 'delete']);
    Route::get('/favorites', [SongController::class, 'listFavorites'])->name('listFavorites');

    Route::get('/search', [SongController::class, 'search']);

});

require __DIR__ . '/auth.php';
