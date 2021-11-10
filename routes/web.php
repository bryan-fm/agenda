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
    return redirect()->route('home');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix'=>'contatos'], function(){

    Route::get('/',['as' => 'home', 'uses' => 'ContatosController@index']);
    Route::get('/addFormContatos', ['as' => 'add_form_contatos', 'uses' => 'ContatosController@addForm']);
    Route::post('/insertContatos', ['as' => 'insert_contatos', 'uses' => 'ContatosController@store']);
    Route::get('/editFormContatos/{id}', ['as' => 'edit_form_contatos', 'uses' => 'ContatosController@editForm']);
    Route::get('/deleteContatos/{id}', ['as' => 'delete_contato', 'uses' => 'ContatosController@delete']);

    Route::get('/filtrarContatosNome', ['as' => 'filtrar_contato_nome', 'uses' => 'ContatosController@filtrarNome']);
    Route::get('/filtrarContatosCategoria', ['as' => 'filtrar_contato_categoria', 'uses' => 'ContatosController@filtrarCategoria']);

});

Route::group(['middleware' => 'auth', 'prefix'=>'categoria'], function(){

    Route::get('/','CategoriaController@index');
    Route::get('/addFormCategoria', ['as' => 'add_form_categoria', 'uses' => 'CategoriaController@addForm']);
    Route::get('/editFormCategoria/{id}', ['as' => 'edit_form_categoria', 'uses' => 'CategoriaController@editForm']);
    Route::post('/insertCategoria', ['as' => 'insert_categoria', 'uses' => 'CategoriaController@store']);
    Route::get('/deleteCategoria/{id}', ['as' => 'delete_categoria', 'uses' => 'CategoriaController@delete']);

});
