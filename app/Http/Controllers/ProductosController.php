<?php

namespace App\Http\Controllers;

use App\CategoriaProductos;
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
}
