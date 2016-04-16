<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index');

Route::auth();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController');
    Route::resource('complaints', 'ComplaintsController', ['only' =>
        ['index', 'show', 'create', 'store']
    ]);
    Route::resource('replies', 'RepliesController', ['only' =>
        ['store']
    ]);
    Route::resource('attachments', 'AttachmentsController', ['only' =>
        ['show']
    ]);
    Route::group(['prefix' => 'api'], function () {
        Route::resource('facilities', 'Api\FacilitiesController', ['only' =>
            ['index', 'show']
        ]);
        Route::resource('users', 'Api\UsersController', ['only' =>
            ['index', 'show']
        ]);
    });
});