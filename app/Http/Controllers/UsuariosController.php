<?php

namespace App\Http\Controllers;

use App\Empleados;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function CrearUsuario(Request $request)
    {
        return Empleados::crearUsuario($request);
    }
    public function TraerUsuarios($sucursal)
    {
        return Empleados::traerUsuarios($sucursal);
    }
}
