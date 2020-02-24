<?php

namespace App;

use App\DetalleAlmacen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompraDetalleAlmacen extends Model
{
    protected $table = "compra_detalle_almacen";

    protected function fecha($value)
    {
        $fecha = $value;
        $anio = substr($fecha, -10, 4);
        $mes = substr($fecha, -5, 2);
        $dia = substr($fecha, -2, 2);
        return [
            'anio' => $anio, 'mes' => $mes, 'dia' => $dia
        ];
    }
    protected function anioID($value)
    {
        return DB::table('anio')->where('descripcion', $value)->first()->id;
    }

    protected function mesID($value)
    {
        return DB::table('mes')->where('id', $value)->first()->id;
    }

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

    protected function registrarCompra($request)
    {
        $carro = json_decode($request->carro, true);
        $almacenes = explode(",", $request->almacenes);
        $count = 0;
        $fecha = $this->fecha($request->fecha);
        $anio = $this->anioID($fecha['anio']);
        $mes = $this->mesID($fecha['mes']);
        foreach ($almacenes as $key) {
            DB::beginTransaction();
            $compra = new CompraDetalleAlmacen;
            $compra->anio_id = $anio;
            $compra->mes_id = $mes;
            $compra->dia = $fecha['dia'];
            $compra->almacen_id = $key;
            $compra->proveedor_id = $request->proveedor;
            $compra->numero_comprobante = $request->comprobante;
            $guardarArchivo = $this->guardarArchivo($request->archivo, 'ArchivosCompraAlmacen/');
            if ($guardarArchivo['estado'] == "success") {
                $compra->archivo = $guardarArchivo['archivo'];
            } else {
                return $guardarArchivo;
            }
            $compra->total = $request->total;
            $compra->creada_por = Auth::user()->id;
            $compra->estado_id = 1;
            $compra->activo = 'S';
            if ($compra->save()) {
                $ingresarDetalle = DetalleAlmacen::ingresarDetalleAlmacen($carro, $compra->id);
                if ($ingresarDetalle == true) {
                    DB::commit();
                    $count++;
                } else {
                    DB::rollBack();
                }
            }
        }

        if (count($almacenes) == $count) {
            return ['estado' => 'success', 'mensaje' => 'Compra registrada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerCompras($anio, $mes, $sucursal_id)
    {
        $compras = DB::table('compra_detalle_almacen as cda')
            ->select([
                'cda.id',
                'cda.numero_comprobante as comprobante',
                'cda.archivo',
                'cda.total',
                'p.razon_social as proveedor'

            ])
            ->join('proveedores as p', 'p.i', 'cda.proveedor_id')
            ->where([
                'cda.activo' => 'S',
                'cda.anio_id' => $anio,
                'cda.mes_id' => $mes,
                'cda.id' => $sucursal_id
            ])
            ->get();
        if (!$compras->isEmpty()) {
            return ['estado' => 'success', 'compras' => $compras];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran compras registradas.'];
        }
    }

    protected function traerDetalleCompra($compra_id)
    {
        $detalles = DB::table('detalle_almacen as da')
            ->select([
                'da.id',
                'i.insumo',
                'da.cantidad',
                'da.precio_compra as precio',
                DB::raw("SUM(da.cantidad*da.precio_compra) as subtotal")
            ])
            ->join('insumo as i', 'i.id', 'da.insumo_id')
            ->where([
                'da.activo' => 'S',
                'da.id' => $compra_id
            ])
            ->get();
        if (!$detalles->isEmpty()) {
            $total = 0;
            foreach ($detalles as $key) {
                $total = $total + $key->subtotal;
            }
            return ['estado' => 'success', 'detalles' => $detalles, 'total' => $total];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentra el detalle de la compra seleccionada.'];
        }
    }
}
