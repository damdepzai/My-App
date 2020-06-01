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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', function () {
    return view('home');
})->where('path', '^((?!api).)*$');
Route::prefix('api')->group(function () {
    Route::get('/logout', 'HomeController@Logout');
    Route::get('/me', 'HomeController@me');
    Route::get('/list','MoneyController@list');
    Route::post('/create','MoneyController@store');
    Route::delete('/delete/{id}','MoneyController@deleteOne');
    Route::post('/delete/all','MoneyController@destroy');

});
