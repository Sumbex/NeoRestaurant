<?php

namespace App\Http\Controllers;

use App\CategoriaProductos;
use App\DetalleProducto;
use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function IngresarCategoria(Request $request)
    {
        return CategoriaProductos::ingresarCategoria($request);
    }

    public function TraerCategoriasModal()
    {
        return CategoriaProductos::traerCategoriasModal();
    }

    public function TraerCategorias()
    {
        return CategoriaProductos::traerCategorias();
    }

    public function IngresarProducto(Request $request)
    {
        return Productos::ingresarProducto($request);
    }

    public function TraerProductos($almacen)
    {
        return Productos::traerProductos($almacen);
    }

    public function TraerDetalleProducto($producto_id)
    {
        return DetalleProducto::traerDetalleProducto($producto_id);
    }

    public function TraerProductosParaPedidos($sucursal_id)
    {
        return Productos::traerProductosParaPedidos($sucursal_id);
    }
}
