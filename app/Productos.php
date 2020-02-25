<?php

namespace App;

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
}
