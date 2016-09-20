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

Route::get('/vendimia', function () {
    return view('ventas');
});
Route::get('/addclientes', function () {
    return view('clientes');
});
Route::get('/listArticulos', function () {
    return view('articulos');
});
Route::get('/configuracion', function () {
    return view('configuracion');
});
Route::get('/ventas', function () {
    return view('addventa');
});

Route::post('/getclientes','Clientes@getclientes');
Route::post('/saveCliente','Clientes@saveCliente');
Route::post('/deleteCliente','Clientes@deleteCliente');
Route::post('/updateCliente','Clientes@updateCliente');
Route::post('/getClave','Clientes@getClave');

/*Articulos*/
Route::post('/getarticulos','Articulos@getarticulos');
Route::post('/savearticulos','Articulos@savearticulos');
Route::post('/deletearticulos','Articulos@deletearticulos');
Route::post('/updatearticulos','Articulos@updatearticulos');

Route::post('/getConfig','Configuracion@getConfig');
Route::post('/saveConfiguracion','Configuracion@saveConfiguracion');
Route::post('/updateConfiguracion','Configuracion@updateConfiguracion');
/*Ventas*/
Route::post('/getventas','Ventas@getventas');
Route::post('/getFolio','Ventas@getFolio');
Route::post('/addVenta','Ventas@addVenta');