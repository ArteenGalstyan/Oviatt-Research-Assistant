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

Route::get('/', function () {return view('welcome');});
Route::get('/admin', 'AdminController@home');
Route::get('/admin/logs', 'AdminController@logs');


Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');


