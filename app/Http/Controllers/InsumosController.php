<?php

namespace App\Http\Controllers;

use App\CategoriaInsumos;
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
}
