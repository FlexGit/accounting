<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MainController@index');
Route::get('/main/report/ajax', 'MainController@getReportAjax');

Route::get('/operation', 'OperationController@index');
Route::get('/operation/list/ajax', 'OperationController@getOperationListAjax');
Route::post('/operation/edit', 'OperationController@edit');
Route::post('/operation/save', 'OperationController@save');
Route::post('/operation/delete', 'OperationController@delete');

Route::get('/template', 'TemplateController@index');
Route::get('/template/list/ajax', 'TemplateController@getTemplateListAjax');
Route::get('/template/list-control/ajax', 'TemplateController@getTemplateListControlAjax');
Route::post('/template/edit', 'TemplateController@edit');
Route::post('/template/save', 'TemplateController@save');
Route::post('/template/delete', 'TemplateController@delete');

Route::get('/category', 'CategoryController@index');
Route::get('/category/list/ajax', 'CategoryController@getCategoryListAjax');
//Route::get('/category/list-control/ajax', 'CategoryController@getCategoryListControlAjax');
Route::post('/category/edit', 'CategoryController@edit');
Route::post('/category/save', 'CategoryController@save');
Route::post('/category/delete', 'CategoryController@delete');
