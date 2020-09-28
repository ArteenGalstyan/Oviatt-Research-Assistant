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
Route::get('/', function () {return view('welcome');});
Route::get('/admin', 'AdminController@home');
Route::get('/admin/logs', 'AdminController@logs');

/* Admin POST Routes */
Route::post('/get_logs', 'AdminController@get_logs');

/* General GET Routes */
Route::get('/login', 'LoginController@login_blade');
Route::get('/logout', 'LoginController@logout');

/* General POST Routes */
Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegistrationController@register');

