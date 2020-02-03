<?php

namespace App\Http\Controllers;

use App\Proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function IngresarProveedor(Request $request)
    {
        return Proveedores::ingresarProveedor($request);
    }
    public function TraerProveedores()
    {
        return Proveedores::traerProveedores();
    }
}
