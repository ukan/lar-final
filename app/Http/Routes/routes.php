<?php
	Route::resource('/users', 'UsersController');
	Route::get('/', function(){
		return view('welcome');
	});
	
	Route::get('google-analytics-summary', array('as'=>'google-analytics-summary','uses'=>'HomeController@getAnalyticsSummary'));

	Route::get('google-analytics-ga', array('as'=>'google-analytics-ga','uses'=>'HomeController@getGA'));

	Route::get('ganteng', array('as'=>'ganteng','uses'=>'HomeController@index'));

	Route::get('/login',function(){
		return view('users.login');
	});

	Route::get('/signup','HomeController@getAnalyticsSummary');

	Route::resource('/signin','LoginsController');
	Route::get('/logout','LoginsController@logout');

	/*import/export file excels format*/
	Route::get('importExport', 'MaatwebsiteDemoController@importExport');
	Route::get('downloadExcel/{type}/{id}', 'ArticlesController@downloadExcel');
	// Route::get('downloadExcel/{type}/{id}', 'MaatwebsiteDemoController@downloadExcel');
	Route::post('importExcel', 'MaatwebsiteDemoController@importExcel');

	/*reset password*/
	Route::get('/reset-password', 
		array('as' => 'reset-password', 'uses' => 'UsersController@reset_password'));
	Route::post('/process-reset-password', 
		array('as' => 'process-reset-password', 'uses' => 'UsersController@process_reset_password'));
	Route::get('/change-password/{forgot_token}', 
		array('as' => 'change-password', 'uses' => 'UsersController@change_password'));
	Route::post('/process-change-password/{forgot_token}', 
		array('as' => 'process-change-password', 'uses' => 'UsersController@process_change_password'));

	
	