<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', 'NavigationController@index');
Route::get('/profile', 'NavigationController@profile')->middleware(['auth']);
Route::get('/dashboard', 'NavigationController@dashboard')->middleware(['auth']);
Route::get('/events', 'NavigationController@events')->middleware(['auth']);
Route::get('/judges', 'NavigationController@judges')->middleware(['auth']);
Route::get('/contestants', 'NavigationController@contestants')->middleware(['auth']);
Route::get('/evaluation', 'NavigationController@evaluation')->middleware(['auth']);
Route::get('/users', 'NavigationController@users')->middleware(['auth']);
Route::get('/settings', 'NavigationController@settings')->middleware(['auth']);
Route::get('/about', 'NavigationController@about')->middleware(['auth']);
Route::resource('application', 'ApplicationController')->middleware(['auth']);
Route::resource('user', 'UserController')->middleware(['auth']);
Route::resource('event', 'EventController')->middleware(['auth']);;
Route::resource('category', 'CategoryController')->middleware(['auth']);;
Route::resource('subcategory', 'SubcategoryController')->middleware(['auth']);;
Route::resource('judge', 'JudgeController')->middleware(['auth']);;
Route::resource('contestant', 'ContestantController')->middleware(['auth']);;
Route::resource('score', 'ScoreController')->middleware(['auth']);;

Route::get('/x', 'NavigationController@x');
Route::get('/x/{j}', 'NavigationController@xj');
Route::get('/x/{t}/{j}', 'NavigationController@xt');
Route::get('/x/{t}/{j}/{c}', 'NavigationController@xc');

Route::get('/test/{id}', function($id) {
  return \App\Judge::find($id)->standings(3);
});
