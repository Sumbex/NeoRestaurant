<?php

namespace App\Http\Controllers;

use App\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function IngresarActualizarPedido(Request $request)
    {
        return Pedidos::ingresarActualizarPedido($request);
    }

    public function TraerPedido($sucursal, $mesa)
    {
        return Pedidos::traerPedido($sucursal, $mesa);
    }
}
