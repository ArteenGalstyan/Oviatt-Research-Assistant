<?php

use Illuminate\Support\Facades\Route;

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

/* Admin GET Routes */
Route::get('/', 'HomeController@home');
Route::get('/admin', 'AdminController@home');
Route::get('/admin/logs', 'AdminController@logs');

/* Admin POST Routes */
Route::post('/get_logs', 'AdminController@get_logs');

/* General GET Routes */
Route::get('/login', 'LoginController@login_blade');
Route::get('/logout', 'LoginController@logout');
Route::get('/verify_email', 'RegistrationController@verify_email_blade');
Route::get('/profile', 'UserController@profile_blade');
Route::get('/search', 'SearchController@search');
Route::get('/article', 'ArticleController@get_article');
Route::get('/history', 'HistoryController@history_blade');


/* General POST Routes */
Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegistrationController@register');
Route::post('/verify_email', 'RegistrationController@verify_email');
Route::post('/search/delete', 'HistoryController@delete_history');
Route::post('/password/update', 'UserController@change_password');
Route::post('/article/favorite', 'ArticleController@favorite_article');
