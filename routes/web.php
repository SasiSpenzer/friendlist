<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendsController;

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
    return view('auth.login');
});

// Invite Globe Route
Route::get('/global_invite/{id}', [FriendsController::class, 'acceptFriends'])
    ->name('friend_list.accept');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';


// Create a group of Routes for Fiend list Routes By Sasi Spenzer
Route::middleware('auth')->group(function () {


    Route::resource('friend_list', FriendsController::class);

    Route::post('/invite-friends', [FriendsController::class, 'inviteFriends'])
        ->name('friend_list.invite');


});
