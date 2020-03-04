<?php

namespace App\Http\Controllers;

use App\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function IngresarPedido(Request $request)
    {
        return Pedidos::ingresarPedido($request);
    }

    public function TraerPedido($sucursal, $mesa)
    {
        return Pedidos::traerPedido($sucursal, $mesa);
    }
}
