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

Route::get('article/step1', 'ArticleController@indexStep1');
Route::get('article/step2', 'ArticleController@indexStep2');
Route::get('article/step3', 'ArticleController@indexStep3');
Route::get('article/step4', 'ArticleController@indexStep4');
