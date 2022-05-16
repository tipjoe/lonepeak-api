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

// Give-a-crap map.
// @deprecated
// We're still using locations to ensure new members live here and to be able
// to introduce nearby neighbors.

// Full list of locations with geo info (for map) and days since last GAC.
// Roads also needed for maps to be rendered.
Route::get('/location', [LocationController::class, 'index'])->name('location.index');
Route::get('/road', [RoadController::class, 'index'])->name('road.index');

// location.addresses gets a list of location IDs and addresses (address1) to
// constrain registrations to those living in our neighborhood.
Route::get('/location/addresses', [LocationController::class, 'addresses'])->name('location.addresses');



// TODO: move these to group model/controller since they should be relations on
// the parent (all neighborhood) group.
Route::get('/members', [UserController::class, 'getMembers'])->name('user.getMembers');
Route::get('/note', [NoteController::class, 'index'])->name('note.index');
Route::get('/friends', [UserController::class, 'getFriends'])->name('user.getFriends');

Route::post('/note', [NoteController::class, 'store'])->name('note.store');
Route::post('/gac', [GacController::class, 'store'])->name('gac.store');

Route::post('/create-referral-url', [ReferralController::class, 'createReferralUrl'])
    ->name('create-referral-url');

// User
Route::prefix('admin')->group(function () {
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
});

/** Old Authentication **/
// Auth::routes(['verify' => true]);
// Route::get('/logout', 'Auth\LoginController@logout');

// Get by ID or currently authenticated user.
Route::get('/user/{id?}', [UserController::class, 'show'])->name('user.get');
Route::put('/user/{id?}/update', [UserController::class, 'update'])->name('user.update');
Route::delete('/photo/{id}', [UserController::class, 'destroyPhoto'])->name('user.photo.delete');

// Handle referral URL (i.e. secure registration).
Route::get('/referral/{id}', [ReferralController::class, 'show'])->name('referral.show');

// Other.
// Blood drive page.
// Route::get('/blood', function () {
// })->name('page.blood');
