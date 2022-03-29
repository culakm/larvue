<?php

use App\Http\Controllers\Api\BookableAvailabilityController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookableReviewController;
// use App\Models\Bookable; //pre priame routovanie bez kontrolera
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// routovanie bez kontrolera
// Route::get('bookables', function (Request $request) {
//     return Bookable::all();
// });

// Route::get('bookables/{id?}', function (Request $request, $id) {
//     return Bookable::findOrFail($id);
// });

// routovanie s kontrolerom pre kazdu cestu zvlast
// Route::get('bookables', [BookableController::class,'index']);
// Route::get('bookables/{id?}', [BookableController::class,'show']);

// routovanie s kontrolerom pre vsetky naraz
Route::apiResource(
    'bookables',
    BookableController::class
)
->only(['index', 'show']);

Route::get('bookables/{id}/availability', BookableAvailabilityController::class)
->name('bookables.availability.show');

Route::get('bookables/{id}/reviews', BookableReviewController::class)
->name('bookables.reviews.index');