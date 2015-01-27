<?php

Route::get('/', 'Blocks\Controllers\HomeController@index');

// Json modules
Route::get('module/all.json', 'Blocks\Controllers\ModuleController@all_json');
Route::get('module/{code}.json', 'Blocks\Controllers\ModuleController@find_json');
Route::get('module/{code}.zip', 'Blocks\Controllers\ModuleController@download');

Route::get('module/publish', 'Blocks\Controllers\ModuleController@publish_form');
Route::post('module/publish', ['as' => 'module.publish', 'uses' => 'Blocks\Controllers\ModuleController@publish']);
Route::resource('module', 'Blocks\Controllers\ModuleController');

Route::group(['before' => 'guest'], function()
{
	Route::get('admin/login', ['as' => 'admin.login', 'uses' => 'Blocks\Controllers\AdminModuleController@login']);
	Route::post('admin/login', ['as' => 'admin.login_post', 'uses' => 'Blocks\Controllers\AdminModuleController@login_post']);
});

Route::group(['before' => 'logged'], function()
{
	Route::get('admin/logout', 'Blocks\Controllers\AdminModuleController@logout');
	Route::get('admin', ['as' => 'admin.home', 'uses' => 'Blocks\Controllers\AdminModuleController@home']);
	Route::resource('admin/module', 'Blocks\Controllers\AdminModuleController');
});