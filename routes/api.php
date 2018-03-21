<?php 

Route::post('/user', ['as' => 'user', 'uses' => 'HomeController@storeUser']);