<?php

Route::get('/', 'Blocks\Controllers\HomeController@index');

// Json modules
Route::get('module/all.json', 'Blocks\Controllers\ModuleController@all_json');
Route::get('module/{code}.json', [
	'as' => 'module_json_path',
	'uses' => 'Blocks\Controllers\ModuleController@find_json'
]);
Route::get('module/{code}.zip', [
	'as' => 'module_download_path',
	'uses' => 'Blocks\Controllers\ModuleController@download'
]);

Route::get('module/version', 'Blocks\Controllers\ModuleController@version');
Route::get('module/publish', 'Blocks\Controllers\ModuleController@publish_form');
Route::post('module/publish', ['as' => 'module.publish', 'uses' => 'Blocks\Controllers\ModuleController@publish']);
Route::get('module', 'Blocks\Controllers\ModuleController@index');

// Validate keys
Route::get('key/validate', 'Blocks\Controllers\KeyValidatorController@validate');

Route::group(['before' => 'guest'], function()
{
	Route::get('admin/login', ['as' => 'admin.login', 'uses' => 'Blocks\Controllers\AdminModuleController@login']);
	Route::post('admin/login', ['as' => 'admin.login_post', 'uses' => 'Blocks\Controllers\AdminModuleController@login_post']);
});

Route::group(['before' => 'logged'], function()
{
	Route::get('admin/logout', 'Blocks\Controllers\AdminModuleController@logout');
	Route::get('admin', ['as' => 'admin.home', 'uses' => 'Blocks\Controllers\AdminModuleController@home']);
	Route::resource('admin/module', 'Blocks\Controllers\AdminModuleController', [
		'only' => ['index', 'edit', 'update']
	]);
});

// Payments
Route::get('pay', [
	'as' => 'pay_path',
	'uses' => 'Blocks\Controllers\PayController@index'
]);

Route::post('pay', [
	'as' => 'pay_action_path',
	'uses' => 'Blocks\Controllers\PayController@pay'
]);

Route::get('pay/success', [
	'as' => 'success_pay_path',
	'uses' => 'Blocks\Controllers\PayController@success'
]);

Route::get('pay/fail', [
	'as' => 'fail_pay_path',
	'uses' => 'Blocks\Controllers\PayController@fail'
]);