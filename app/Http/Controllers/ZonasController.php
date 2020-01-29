<?php

namespace App\Http\Controllers;

use App\Zonas;
use Illuminate\Http\Request;

class ZonasController extends Controller
{
    public function TraerZonas()
    {
        return Zonas::traerZonas();
    }

    public function IngresarZona(Request $request)
    {
        return Zonas::IngresarZona($request);
    }
}
