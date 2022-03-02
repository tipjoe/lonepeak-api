<?php

use App\Http\Controllers\GacController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\UserController;
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

// Using web routes for api with Sanctum to utilize session tokens.

/** Old Authentication **/
// Auth::routes(['verify' => true]);
// Route::get('/logout', 'Auth\LoginController@logout');

/**
 * Old home. Convert to generic PageController for dynamic content based on
 * path arguments.
 */
// Route::get('/home', 'HomeController@index')->name('home')
//     ->middleware('verified');

// Give-a-crap map.
Route::get('/location', [LocationController::class, 'index'])->name('location.index');
Route::get('/road', [RoadController::class, 'index'])->name('road.index');


// TODO: move these to group model/controller since they should be relations on
// the parent (all neighborhood) group.
Route::get('/members', [UserController::class, 'getMembers'])->name('user.getMembers');
Route::get('/note', [NoteController::class, 'index'])->name('note.index');
Route::get('/friends', [UserController::class, 'getUserConnections'])->name('user.getFriends');

Route::post('/note', [NoteController::class, 'store'])->name('note.store');
Route::post('/gac', [GacController::class, 'store'])->name('gac.store');

Route::post('/create-referral-url', [ReferralController::class, 'createReferralUrl'])
    ->name('create-referral-url');

// User
Route::prefix('admin')->group(function () {
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
});

// Get by ID or currently authenticated user.
Route::get('/user/{id?}', [UserController::class, 'get'])->name('user.get');
Route::put('/user/{id?}/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/{id?}photo/delete', [UserController::class, 'destroyPhoto'])->name('user.photo.delete');

// Handle referral URL (i.e. secure registration).
Route::get('/referral/{id}', [ReferralController::class, 'show'])->name('referral.show');


// Other.
// Route::get('/blood', function () {
// })->name('page.blood');


// Route::get('/dog', function () {
//     $user = User::find(1);

//     return (new UserRegistered())
//         ->toMail($user);
// });
