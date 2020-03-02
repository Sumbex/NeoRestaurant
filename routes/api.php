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

    /* <---DatosBasicos---> */
    Route::get('/traer_anios', 'TraerDatosBasicosController@TraerAnios');
    /* Route::get('/traer_anio_actual', 'TraerDatosBasicosController@traerAnioActual'); */
    Route::get('/traer_meses', 'TraerDatosBasicosController@TraerMeses');
    /* Route::get('/traer_mes_actual', 'TraerDatosBasicosController@traerMesActual'); */
    /* <---DatosBasicos---> */

    /* <---Sucursal---> */
    //Sucursales
    Route::post('/ingresar_sucursal', 'SucursalController@IngresarSucursal');
    Route::get('/traer_sucursales', 'SucursalController@TraerSucursales');
    //Mesas
    Route::post('/ingresar_mesa', 'MesasController@IngresarMesas');
    Route::post('/abrir_cerrar_mesa', 'MesasController@AbrirCerrarMesa');
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
    Route::get('/traer_compras/{anio}/{mes}/{sucursal}', 'CompraDetalleAlmacenController@TraerCompras');
    Route::get('/traer_detalle_compra/{compra}', 'CompraDetalleAlmacenController@TraerDetalleCompra');
    Route::get('/traer_almacenes', 'DetalleAlmacenController@TraerAlmacenes');
    Route::get('/traer_insumos_compra', 'DetalleAlmacenController@TraerInsumos');
    Route::get('/traer_proveedores_select', 'DetalleAlmacenController@TraerProveedores');
    /* <---Almacen---> */

    /* <---Productos---> */
    //Categoria Productos
    Route::post('/ingresar_categoria_productos', 'ProductosController@IngresarCategoria');
    Route::get('/traer_categoria_productos', 'ProductosController@TraerCategoriasModal');
    Route::get('/traer_categoria_productos_select', 'ProductosController@TraerCategorias');

    //Productos
    Route::post('/ingresar_producto', 'ProductosController@IngresarProducto');
    Route::get('/traer_productos/{almacen}', 'ProductosController@TraerProductos');
    Route::get('/traer_productos_pedidos/{sucursal}/{categoria}', 'ProductosController@TraerProductosParaPedidos');
    Route::get('/traer_detalle_producto/{producto}', 'ProductosController@TraerDetalleProducto');

    /* <---Productos---> */

    /* <---Caja---> */
    Route::post('/ingresar_caja', 'CajaController@CrearCaja');
    Route::get('/traer_cajas', 'CajaController@TraerCajas');
    /* <---Caja---> */

    /* <---Movimientos Caja---> */
    Route::post('/abrir_caja', 'CajaController@abrirCerrarCaja');
    /* <---Movimientos Caja---> */

    /* <---Pedidos---> */
    Route::post('/ingresar_pedido', 'PedidosController@IngresarPedido');
    /* <---Pedidos---> */
});
