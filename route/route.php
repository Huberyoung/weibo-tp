<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::group('/', function () {
    Route::get('', 'home');
    Route::get('help', 'help');
    Route::get('about', 'about');
})->prefix('index/staticPages/');


Route::resource('users','index/users');

Route::group('/', function (){
    Route::get('login','create');
    Route::post('save','save');
    Route::delete('logout','delete');
})->prefix('index/Sessions/');

Route::group('password/',function (){
    Route::get('request','showLinkRequestForm');
    Route::post('email','sendResetLinkEmail');
    Route::get('reset/:token','showResetForm');
    Route::post('update','reset');
})->prefix('index/ForgotPassword/');

Route::group('statuses',function (){
    Route::post('/','save');
    Route::delete('/:id','delete');
})->prefix('index/Statuses/');

Route::get('signup/confirm/:token','index/Users/confirm');

Route::get('users/:id/followers','index/Users/followers');

//Route::get('users/:id/followings','index/Users/followings');
