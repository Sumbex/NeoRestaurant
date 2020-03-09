<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class MesaPedido extends Model
{
    protected $table = "mesa_pedido";

    /* $table->integer('mesa_id');
            $table->integer('pedido_id');
            $table->integer('creada_por');
            $table->integer('estado_id'); */

    protected function ingresarMesas($pedido_id, $mesas)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($mesas as $key) {
            $mesa = new MesaPedido;
            $mesa->mesa_id = $key['id'];
            $mesa->pedido_id = $pedido_id;
            $mesa->creada_por = Auth::user()->id;
            $mesa->estado_id = 1;
            $mesa->activo = 'S';
            if ($mesa->save()) {
                $count++;
            }
        }
        if (count($mesas) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }

    protected function actualizarMesa($pedido_id, $mesas, $mesasBorrar)
    {
        $count = 0;
        $counVer = 0;
        $borrar = 0;

        DB::beginTransaction();
        foreach ($mesas as $key) {
            $verificar = DB::table('mesa_pedido')
                ->select([
                    'id'
                ])
                ->where([
                    'pedido_id' => $pedido_id,
                    'mesa_id' => $key['id']
                ])
                ->first();
            if (is_null($verificar)) {
                $counVer++;
                $mesa = new MesaPedido;
                $mesa->mesa_id = $key['id'];
                $mesa->pedido_id = $pedido_id;
                $mesa->creada_por = Auth::user()->id;
                $mesa->estado_id = 1;
                $mesa->activo = 'S';
                if ($mesa->save()) {
                    $count++;
                }
            }
        }
        if ($counVer == $count) {
            $quitar = $this->quitarMesas($pedido_id, $mesasBorrar);
            if ($quitar == true) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } else {
            DB::rollBack();
            return false;
        }
    }

    protected function quitarMesas($pedido_id, $mesasBorrar)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($mesasBorrar as $key) {
            $verificar = DB::table('mesa_pedido')
                ->select([
                    'id'
                ])
                ->where([
                    'pedido_id' => $pedido_id,
                    'mesa_id' => $key['id']
                ])
                ->first();

            if (!is_null($verificar)) {
                $delete = MesaPedido::find($verificar->id);
                $delete->activo = 'N';
                if ($delete->save()) {
                    $count++;
                }
            }
        }
        if (count($mesasBorrar) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}
