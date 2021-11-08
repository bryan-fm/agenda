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

Route::group(['middleware' => 'auth', 'prefix'=>'contatos'], function(){

    Route::get('/','ContatosController@index');
    Route::get('/addFormContatos', ['as' => 'add_form_contatos', 'uses' => 'ContatosController@addForm']);
    Route::post('/insertContatos', ['as' => 'insert_contatos', 'uses' => 'ContatosController@store']);
    Route::get('/editFormContatos/{id}', ['as' => 'edit_form_contatos', 'uses' => 'ContatosController@editForm']);

});
