<?php

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
    Route::get('/traer_mesas', 'MesasController@TraerMesas');
    Route::get('/traer_mesas_sucursal/{id}', 'MesasController@TraerMesasSucursal');
    Route::get('/traer_sucursales_select', 'MesasController@TraerSucursales');
    //Zonas
    Route::post('/ingresar_zona', 'ZonasController@IngresarZona');
    Route::get('/traer_zonas', 'ZonasController@TraerZonasModal');
    Route::get('/traer_zonas_select', 'ZonasController@TraerZonas');
    /* <---Sucursal---> */

    /* <---Almacen---> */
    //Proveedores
    Route::post('/ingresar_proveedor', 'ProveedoresController@IngresarProveedor');
    Route::get('/traer_proveedores', 'ProveedoresController@TraerProveedores');

    //Categoria Insumos
    Route::post('/ingresar_categoria_insumo', 'InsumosController@IngresarCategoria');
    Route::get('/traer_categoria_insumos', 'InsumosController@TraerCategoriasModal');
    Route::get('/traer_categoria_insumos_select', 'InsumosController@TraerCategorias');

    //Insumos
    Route::post('/ingresar_insumo', 'InsumosController@IngresarInsumo');
    Route::get('/traer_insumos', 'InsumosController@TraerInsumos');

    //Registro Compras
    Route::post('/registrar_compra', 'CompraDetalleAlmacenController@RegistrarCompra');
    Route::get('/traer_compras/{anio}/{mes}','CompraDetalleAlmacenController@TraerCompras');
    Route::get('/traer_almacenes', 'DetalleAlmacenController@TraerAlmacenes');
    Route::get('/traer_insumos_compra', 'DetalleAlmacenController@TraerInsumos');
    Route::get('/traer_proveedores_select', 'DetalleAlmacenController@TraerProveedores');
    /* <---Almacen---> */
});
