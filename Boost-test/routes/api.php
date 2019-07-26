<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('video/size/{username}', 'API\VideoController@getVideoSize');

Route::get('video/metadata/{videoID}', 'API\VideoController@getVideoMetadata');

Route::put('update/metadata/{videoID}/{newVideoSize}/{newViewersCount}', 'API\VideoController@updateVideoMetadata');

Route::fallback(function () {
    return response()->json(['message' => 'Supply all required fields!'], 404);
});
