<?php

namespace App\Http\Controllers;

use App\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function IngresarSucursal(Request $request)
    {
        return Sucursal::ingresarSucursal($request);
    }

    public function TraerSucursales()
    {
        return Sucursal::traerSucursales();
    }
}
