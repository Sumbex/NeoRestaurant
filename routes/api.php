<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'AuthController@Login');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('auth/logout', 'AuthController@Logout');

    /* <---Sucursal---> */
    //Sucursales
    Route::post('/ingresar_sucursal', 'SucursalController@IngresarSucursal');
    Route::get('/traer_sucursales', 'SucursalController@TraerSucursales');
    //Mesas
    Route::post('/ingresar_mesa', 'MesasController@IngresarMesas');
    Route::get('/traer_sucursales_select', 'MesasController@TraerSucursales');
    //Zonas
    Route::post('/ingresar_zona', 'ZonasController@IngresarZona');
    Route::get('/traer_zonas', 'ZonasController@TraerZonasModal');
    Route::get('/traer_zonas_select', 'ZonasController@TraerZonas');
    /* <---Sucursal---> */
});
