<?php

namespace App\Http\Controllers;

use App\Mesas;
use Illuminate\Http\Request;

class MesasController extends Controller
{
    public function TraerSucursales()
    {
        return Mesas::traerSucursales();
    }

    public function IngresarMesas(Request $request)
    {
        return Mesas::ingresarMesas($request);
    }
}
