<?php
	Route::resource('/articles', 'ArticlesController');

	Route::get('/articles/delete/{id}', 'ArticlesController@destroy');
	Route::get('/articles/edit/{id}', 'ArticlesController@edit');