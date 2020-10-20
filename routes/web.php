<?php

use Illuminate\Support\Facades\Route;

Route::get('/', ['uses'=> 'MainController@welcome', 'as' => 'welcome']);
Route::get('/stat', ['uses'=> 'MainController@stat', 'as' => 'stat']);

Route::get('/sheep', ['uses' => 'MainController@getGroupsWithSheep', 'as' => 'group.index']);
Route::get('/sheep/manage', ['uses' => 'MainController@shuffleGroup', 'as' => 'shuffle.group']);
Route::get('/day', ['uses' => 'MainController@getDay', 'as' => 'day']);

Route::get('/total', ['uses' => 'MainController@getTotal', 'as' => 'sheep.total']);
Route::get('/alive', ['uses' => 'MainController@getAlive', 'as' => 'sheep.alive']);
Route::get('/dead', ['uses' => 'MainController@getDead', 'as' => 'sheep.dead']);
Route::get('/max', ['uses' => 'MainController@getMaxGroup', 'as' => 'group.max']);
Route::get('/min', ['uses' => 'MainController@getMinGroup', 'as' => 'group.min']);
