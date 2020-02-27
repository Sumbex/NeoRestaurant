<?php

namespace App;

use Carbon\Carbon;
use App\DetalleProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Productos extends Model
{
    protected $table = "productos";

    protected function guardarArchivo($archivo, $ruta)
    {
        $filenameext = $archivo->getClientOriginalName();
        $filename = pathinfo($filenameext, PATHINFO_FILENAME);
        $extension = $archivo->getClientOriginalExtension();
        $nombreArchivo = $filename . '_' . time() . '.' . $extension;
        $rutaDB = 'storage/' . $ruta . $nombreArchivo;

        $guardar = Storage::put($ruta . $nombreArchivo, (string) file_get_contents($archivo), 'public');

        if ($guardar) {
            return ['estado' =>  'success', 'archivo' => $rutaDB];
        } else {
            return ['estado' =>  'failed', 'mensaje' => 'Error al intentar guardar el archivo.'];
        }
    }

    protected function ingresarProducto($request)
    {
        /* dd($request->all()); */
        $count = 0;
        $carro = json_decode($request->carro, true);
        $almacenes = explode(",", $request->almacenes);
        foreach ($almacenes as $key) {
            DB::beginTransaction();
            $producto = new Productos;
            $producto->producto = $request->producto;
            $producto->almacen_id = $key;
            $producto->categoria_id = $request->categoria;
            $guardarArchivo = $this->guardarArchivo($request->archivo, 'ArchivosProductos/');
            if ($guardarArchivo['estado'] == "success") {
                $producto->foto = $guardarArchivo['archivo'];
            } else {
                return $guardarArchivo;
            }
            $producto->destino_id = $request->destino;
            $producto->precio_venta = $request->precio;
            $producto->creada_por = Auth::user()->id;
            $producto->estado_id = 1;
            $producto->activo = 'S';
            if ($producto->save()) {
                $detalle = DetalleProducto::ingresarDetalleProducto($carro, $producto->id);
                if ($detalle == true) {
                    DB::commit();
                    $count++;
                } else {
                    DB::rollBack();
                }
            }
        }
        if (count($almacenes) == $count) {
            return ['estado' => 'success', 'mensaje' => 'Producto creado Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerProductos($almacen)
    {
        $productos = DB::table('productos as p')
            ->select([
                'p.id',
                'p.producto',
                'cp.producto as categoria',
                'ed.descripcion as destino',
                'p.foto',
                'p.precio_venta as precio',
                'p.created_at',
                'u.nombre'
            ])
            ->join('categoria_productos as cp', 'cp.id', 'p.categoria_id')
            ->join('estado_destino as ed', 'ed.id', 'p.destino_id')
            ->join('users as u', 'u.id', 'p.creada_por')
            ->where([
                'p.activo' => 'S',
                'p.almacen_id' => $almacen
            ])
            ->get();
        if (!$productos->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($productos as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'productos' => $productos];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran productos creados.'];
        }
    }
    protected function traerProductosParaPedidos($sucursal_id)
    {
        $productos = DB::table('productos as p')
            ->select([
                'p.id',
                'p.producto',
                'p.precio_venta',
            ])
            ->join('almacen as a', 'a.id', 'p.almacen_id')
            ->join('sucursal as s', 's.id', 'a.sucursal_id')
            ->where([
                'p.activo' => 'S',
                's.id' => $sucursal_id
            ])
            ->get();
        if (!$productos->isEmpty()) {
            return ['estado' => 'success', 'productos' => $productos];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran productos para mostrar.'];
        }
    }
}
