<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ZipCode;

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

Route::get('/', function () {
    return new JsonResponse([
        'app' => 'Api BackBone ' . config('backbone.api_version'),
        'env' => App::environment(),
    ]);
})->name('api.get.home');

Route::get('zip-codes/{zipcode}', [ZipCode\ZipCodeController::class, 'show']);


