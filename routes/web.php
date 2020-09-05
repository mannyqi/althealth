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

Route::get('/', 'WelcomeController@index');

/**
 * Automatically create routes based on controller generated using the 'php artisan make:controller SomeController --resource'
 */
Route::resource('clients', 'ClientsController');
Route::get('/clients/json/{id}', 'ClientsController@getClient');

Route::resource('suppliers', 'SuppliersController');
Route::resource('supplements', 'SupplementsController');

Route::resource('invoices', 'InvoicesController');
Route::post('/invoices/create-draft', 'InvoicesController@createDraft');

Route::get('/reports', 'ReportsController@index');
Route::get('/reports/d2d-1', 'ReportsController@index');
Route::get('/reports/d2d-2', 'ReportsController@d2d2');
Route::get('/reports/d2d-3', 'ReportsController@d2d3');
Route::get('/reports/mis-1', 'ReportsController@mis1');
Route::get('/reports/mis-2', 'ReportsController@mis2');
Route::get('/reports/mis-3', 'ReportsController@mis3');

