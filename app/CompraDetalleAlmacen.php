<?php

namespace App;

use App\Insumos;
use Carbon\Carbon;
use App\DetalleAlmacen;
use App\DetalleProducto;
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
                    $stock = CantidadInsumosAlmacen::agregarStockInsumo($key, $carro);
                    if ($stock == true) {
                        DB::commit();
                        $count++;
                    } else {
                        DB::rollBack();
                    }
                } else {
                    DB::rollBack();
                }
            }
        }
        dd(count($almacenes) == $count);
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
                'p.razon_social as proveedor',
                'cda.created_at',
                'u.nombre'

            ])
            ->join('users as u', 'u.id', 'cda.creada_por')
            ->join('proveedores as p', 'p.id', 'cda.proveedor_id')
            /* ->join('almacen as a', 'a.id', 'cda.almacen_id') */
            ->where([
                'cda.activo' => 'S',
                'cda.anio_id' => $anio,
                'cda.mes_id' => $mes,
                'cda.almacen_id' => $sucursal_id
            ])
            ->get();
        if (!$compras->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($compras as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
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
                /* DB::raw("SUM(da.cantidad*da.precio_compra) as subtotal"), */
            ])
            ->join('insumos as i', 'i.id', 'da.insumo_id')
            ->where([
                'da.activo' => 'S',
                'da.compra_detalle_almacen_id' => $compra_id
            ])
            ->get();
        /* dd($detalles); */
        if (!$detalles->isEmpty()) {
            $total = 0;
            foreach ($detalles as $key) {
                $key->subtotal = $key->cantidad * $key->precio;
                $total = $total + $key->subtotal;
            }
            return ['estado' => 'success', 'detalles' => $detalles, 'total' => $total];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentra el detalle de la compra seleccionada.'];
        }
    }

    protected function verificarStock(/* $sucursal_id, */$pedidos)
    {
        $array = [];

        for ($i = 0; $i < count($pedidos); $i++) {
            $detalle = DetalleProducto::where([
                'activo' => 'S',
                'producto_id' => $pedidos[$i]['id_producto']
            ])
                ->get();
            for ($e = 0; $e < count($detalle); $e++) {
                $insumo = Insumos::find($detalle[$e]->insumo_id);
            }
        }
        dd($insumo);
    }

    protected function verificarStockProducto($sucursal, $produto)
    {
        /* $compras = DB::table('compra_detalle_almacen as cda')
            ->select([
                'da.insumo_id',
                DB::raw("SUM(da.cantidad) as stock_insumo"),
            ])
            ->join('detalle_almacen as da', 'da.compra_detalle_almacen_id', 'cda.id')
            ->join('almacen as a', 'a.id', 'cda.almacen_id')
            ->join('productos as p', 'p.almacen_id', 'a.id')
            ->where([
                'cda.activo' => 'S',
                'a.sucursal_id' => $sucursal,
                'p.id' => $produto
            ])
            ->groupBy('da.insumo_id')
            ->get(); */

        /* select dp.insumo_id as insumo, da.cantidad from productos as p 
        inner join detalle_producto as dp on dp.producto_id = p.id 
        inner join almacen as a on a.id = p.almacen_id 
        inner join compra_detalle_almacen as cda on cdp.almacen_id = p.almacen_id 
        inner join detalle_almacen as da on da.compra_detalle_almacen_id = cdp.id   
        where p.id = 11 and a.sucursal_id = 10 
        group by dp.insumo_id, da.cantidad */

        /* select i.id, i.cantidad from insumos as i 
        inner join detalle_producto as dp on dp.insumo_id = i.id where dp.producto_id = 11 */

        $insumo = DB::table('insumos as i')
            ->select([
                'i.id',
                'i.cantidad'
            ])
            ->join('detalle_producto as dp', 'dp.insumo_id', 'i.id')
            ->where([
                'i.activo' => 'S',
                'dp.producto_id' => $produto
            ])
            ->get();
        /*  dd($insumo); */

        $compras = DB::table('productos as p')
            ->select([
                'dp.insumo_id',
                'da.cantidad'
            ])
            ->join('detalle_producto as dp', 'dp.producto_id', 'p.id')
            ->join('almacen as a', 'a.id', 'p.almacen_id')
            ->join('compra_detalle_almacen as cda', 'cda.almacen_id', 'p.almacen_id')
            ->join('detalle_almacen as da', 'da.compra_detalle_almacen_id', 'cda.id')
            ->where([
                'p.activo' => 'S',
                'a.sucursal_id' => $sucursal,
                'p.id' => $produto
            ])
            ->groupBy('dp.insumo_id', 'da.cantidad')
            ->get();

        dd($compras);
        /*  $test = [];
        for ($i = 0; $i < count($insumo); $i++) {
            for ($q = 0; $q < count($compras); $q++) {
                if ($insumo[$i]->id == $compras[$q]->insumo_id) {
                    
                }
            }
        }
        dd($test); */
        /* foreach ($produtos as $key) {
            $detalle = DB::table('detalle_producto as dp')
                ->select([
                    'dp.id',
                    'dp.producto_id',
                    'dp.cantidad as cantidad_uso',
                    'i.insumo',
                    'i.cantidad'
                ])
                ->join('insumos as i', 'i.id', 'dp.insumo_id')
                ->where([
                    'dp.activo' => 'S',
                    'dp.producto_id' => $key['id_producto']
                ])
                ->get();
        }


        dd($detalle);
        if (!$detalle->isEmpty()) {
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentra el detalle de la compra seleccionada.'];
        } */
    }
}
