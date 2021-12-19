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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'user'], function() {
    Route::post('/register', ['App\Http\Controllers\FreelancerController', 'register']);
    Route::post('/login', ['App\Http\Controllers\FreelancerController', 'login']);

    Route::group(['middleware' => ['jwt.user']], function () {
        Route::get('/checkToken', ['App\Http\Controllers\FreelancerController', 'checkToken']);
        Route::post('/logout', ['App\Http\Controllers\FreelancerController', 'logout']);
        Route::resource('/category', 'App\Http\Controllers\FreelancerCategoryController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::resource('/ownCard', 'App\Http\Controllers\FreelancerCardController')->only([
            'index', 'store', 'show', 'destroy'
        ]);
        Route::put('/ownCard/{cid}/{uid}', ['App\Http\Controllers\FreelancerCardController', 'update']);
//        Route::resource('/card', 'App\Http\Controllers\CardController')->only([
//            'index'
//        ]);
        Route::post('/filter', ['App\Http\Controllers\CardController', 'filter']);
        Route::resource('/rating', 'App\Http\Controllers\RatingController')->only([
            'store'
        ]);
        Route::resource('/save', 'App\Http\Controllers\SavedController')->only([
            'index', 'store', 'destroy'
        ]);
        Route::resource('/categories', 'App\Http\Controllers\CategoryController')->only([
            'index', 'show'
        ]);
    });
});

Route::group(['prefix' => 'designer'], function() {
    Route::post('/register', ['App\Http\Controllers\DesignerController', 'register']);
    Route::post('/login', ['App\Http\Controllers\DesignerController', 'login']);

    Route::group(['middleware' => ['jwt.designer']], function () {
        Route::get('/checkToken', ['App\Http\Controllers\DesignerController', 'checkToken']);
        Route::post('/logout', ['App\Http\Controllers\DesignerController', 'logout']);
        Route::resource('/card', 'App\Http\Controllers\CardController')->only([
            'store', 'show', 'update', 'destroy'
        ]);
        Route::resource('/post', 'App\Http\Controllers\PostController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::resource('/cardCategory', 'App\Http\Controllers\CardCategoryController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
    });
});

Route::group(['prefix' => 'admin'], function() {
    Route::post('/register', ['App\Http\Controllers\AdminController', 'register']);
    Route::post('/login', ['App\Http\Controllers\AdminController', 'login']);

    Route::group(['middleware' => ['jwt.admin']], function () {
        Route::post('/logout', ['App\Http\Controllers\AdminController', 'logout']);
        Route::resource('/category', 'App\Http\Controllers\CategoryController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
    });
});
