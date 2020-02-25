<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function CrearCaja(Request $request)
    {
        return Caja::crearCaja($request);
    }

    public function TraerCajas()
    {
        return Caja::traerCajas();
    }

}
