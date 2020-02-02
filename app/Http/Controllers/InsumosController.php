<?php

namespace App\Http\Controllers;

use App\CategoriaInsumos;
use App\Insumos;
use Illuminate\Http\Request;

class InsumosController extends Controller
{
    public function IngresarCategoria(Request $request)
    {
        return CategoriaInsumos::ingresarCategoria($request);
    }

    public function TraerCategoriasModal()
    {
        return CategoriaInsumos::traerCategoriasModal();
    }

    public function TraerCategorias()
    {
        return CategoriaInsumos::traerCategorias();
    }

    public function IngresarInsumo(Request $request)
    {
        return Insumos::ingresarInsumo($request);
    }

    public function TraerInsumos()
    {
        return Insumos::traerInsumos();
    }
}
