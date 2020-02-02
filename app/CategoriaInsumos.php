<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CategoriaInsumos extends Model
{
    protected $table = "categoria_insumos";

    protected function ingresarCategoria($request)
    {
        $categoria = new CategoriaInsumos;
        $categoria->insumo = $request->categoria;
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
        $categorias = DB::table('categoria_insumos as ci')
            ->select([
                'ci.id',
                'ci.insumo',
                'u.nombre',
                'ci.created_at'
            ])
            ->join('users as u', 'u.id', 'ci.creada_por')
            ->where([
                'ci.activo' => 'S'
            ])
            ->orderBy('ci.created_at', 'desc')
            ->get();
        if (!$categorias->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($categorias as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'categorias' => $categorias];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }

    protected function traerCategorias()
    {
        $categorias = DB::table('categoria_insumos')
            ->select([
                'id',
                'insumo as descripcion',
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
