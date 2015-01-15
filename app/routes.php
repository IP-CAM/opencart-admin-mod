<?php

Route::get('/', 'Blocks\Controllers\HomeController@index');

Route::get('module/publish', 'Blocks\Controllers\ModuleController@publishfile');
Route::post('module/publish', 'Blocks\Controllers\ModuleController@publish');
Route::resource('module', 'Blocks\Controllers\ModuleController');