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

Route::post('/invoices/create-draft', 'InvoicesController@createDraft');
Route::post('/invoices/save-draft', 'InvoicesController@saveDraft');
Route::post('/invoices/confirm-payment', 'InvoicesController@confirmPayment');
Route::get('/invoices/discard-draft', 'InvoicesController@discardDraft');
Route::get('/invoices/issue', 'InvoicesController@issueInvoice');
Route::get('/invoices/pay/{id}', 'InvoicesController@markPaid');
Route::get('/invoices/print/{id}', 'InvoicesController@print');
Route::resource('invoices', 'InvoicesController');

Route::get('/reports', 'ReportsController@index');
Route::get('/reports/d2d-1', 'ReportsController@index');
Route::get('/reports/d2d-2', 'ReportsController@d2d2');
Route::get('/reports/d2d-3', 'ReportsController@d2d3');
Route::get('/reports/mis-1', 'ReportsController@mis1');
Route::post('/reports/mis-1', 'ReportsController@mis1');
Route::get('/reports/mis-2', 'ReportsController@mis2');
Route::get('/reports/mis-3', 'ReportsController@mis3');

Route::get('/send-mail', 'MailController@sendEmail');
