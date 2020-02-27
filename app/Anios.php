<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Anios extends Model
{
    protected $table = "anio";

    protected function traerAnios()
    {
        $anios = DB::table('anio')
            ->select([
                'id',
                'descripcion'
            ])
            ->where([
                'activo' => 'S'
            ])
            ->orderBy('descripcion', 'desc')
            ->get();

        return ['estado' => 'success', 'anios' => $anios];
    }

    protected function traerAnioActual(){
        $anio = DB::select("select date_part('year',now()) as anio");
        $anio_db = DB::table('anio')
        ->select([
            'id',
            'descripcion'
        ])
        ->where([
            'activo' => 'S',
            'descripcion' => $anio[0]->anio
        ])
        ->get();

        return ['estado' => 'success', 'anios' => $anio_db];
    }

}
