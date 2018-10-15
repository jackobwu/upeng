<?php
Route::namespace('Auth')->group(function () {

    Route::post('/register', 'RegisterController@register');

    Route::post('/login', 'LoginController@login');

    Route::post('/password/change', 'ChangePasswordController@change');

    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'ResetPasswordController@reset');

    Route::get('/refresh', 'TokenController@refresh');

    Route::get('/user', 'TokenController@user');

    Route::post('logout', 'LoginController@logout');
});


Route::middleware('jwt.custom.check')->group(function () {
    Route::get('/profile/{username}', 'ProfileController@show');

    Route::get('/profile/{user}/statuses', 'ProfileController@statuses');

    Route::get('/statuses/{status}/replies', 'ReplyController@index');
});

Route::middleware('jwt.auth')->group(function () {
    Route::put('/profile', 'ProfileController@update');

    Route::get('/search', 'SearchController@results');

    Route::get('/statuses', 'StatusController@index');

    Route::post('/statuses', 'StatusController@store');

    Route::delete('/statuses/{id}', 'StatusController@destroy');

    Route::resource('/friendships', 'FriendshipController', [
        'only' => ['index', 'store', 'update', 'destroy'],
        'parameters' => ['friendships' => 'user'],
    ]);

    Route::post('/statuses/{status}/likes', 'LikeController@store');

    Route::delete('/statuses/{status}/likes', 'LikeController@destroy');

    Route::post('/statuses/{status}/replies', 'ReplyController@store');
});



