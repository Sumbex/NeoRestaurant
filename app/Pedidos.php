<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = "pedido";

    protected function fechaActual()
    {
        $hora = DB::select("select now() as fecha");
        return $hora[0]->fecha;
    }

    protected function ingresarPedido($request)
    {
        $fecha = $this->fechaActual();
        $pedido = new Pedidos;
        $pedido->hora_pedido = $fecha;
    }
}
