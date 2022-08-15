<?php

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

Route::apiResources([
	'layouts' => Api\LayoutController::class,
]);

// Get value of layout (layoutId, x, y) : should return value of given coordinates
Route::get('/get-value/{layout_id}', 'Api\LayoutController@getValue');