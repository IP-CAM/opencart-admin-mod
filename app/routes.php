<?php

Route::get('/', 'Blocks\Controllers\HomeController@index');

Route::get('module/publish', 'Blocks\Controllers\ModuleController@publish_form');
Route::post('module/publish', ['as' => 'module.publish', 'uses' => 'Blocks\Controllers\ModuleController@publish']);
Route::resource('module', 'Blocks\Controllers\ModuleController');