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

    public function TraerMesas()
    {
        return Mesas::traerMesas();
    }

    public function TraerMesasSucursal($id)
    {
        return Mesas::traerMesasSucursal($id);
    }

    public function AbrirCerrarMesa(Request $request)
    {
        return Mesas::abrirCerrarMesa($request);
    }
}
