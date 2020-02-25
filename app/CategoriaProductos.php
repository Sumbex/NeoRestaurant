<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CategoriaProductos extends Model
{
    protected $table = "categoria_productos";

    protected function ingresarCategoria($request)
    {
        $categoria = new CategoriaProductos;
        $categoria->producto = $request->categoria;
        $categoria->creada_por = Auth::user()->id;
        $categoria->estado_id = 1;
        $categoria->activo = 'S';
        if ($categoria->save()) {
            return ['estado' => 'success', 'mensaje' => 'Categoria creada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerCategoriasModal()
    {
        $categorias = DB::table('categoria_productos as cp')
            ->select([
                'cp.id',
                'cp.producto',
                'u.nombre',
                'cp.created_at'
            ])
            ->join('users as u', 'u.id', 'cp.creada_por')
            ->where([
                'cp.activo' => 'S'
            ])
            ->orderBy('cp.created_at', 'desc')
            ->get();
        if (!$categorias->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($categorias as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'categorias' => $categorias];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran categorias creadas.'];
        }
    }

    protected function traerCategorias()
    {
        $categorias = DB::table('categoria_productos')
            ->select([
                'id',
                'producto as descripcion',
            ])
            ->where([
                'activo' => 'S'
            ])
            ->get();

        if (!$categorias->isEmpty()) {
            return ['estado' => 'success', 'categorias' => $categorias];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }
}
