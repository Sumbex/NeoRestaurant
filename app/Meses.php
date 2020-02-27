<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Meses extends Model
{
    protected $table = "mes";

    protected function traerMeses()
    {
        $meses = DB::table('mes')
            ->select([
                'id',
                'descripcion'
            ])
            ->where([
                'activo' => 'S'
            ])
            ->orderBy('id', 'asc')
            ->get();

        return ['estado' => 'success', 'meses' => $meses];
    }
    /* public function traerMeses()
	{
		return DB::table('mes')->orderBy('id', 'asc')->get();
	}
	public function traerMesActual()
	{
		$mes_actual = DB::select("select date_part('month',now()) as mes");
		$id = $mes_actual[0]->mes;
		return $this->get_mes($id);
	}

	public function get_mes($id)
	{
		switch ($id) {
			case '1':
				$mes = ['id' => $id, 'descripcion' => 'Enero'];
				break;
			case '2':
				$mes = ['id' => $id, 'descripcion' => 'Febrero'];
				break;
			case '3':
				$mes = ['id' => $id, 'descripcion' => 'Marzo'];
				break;
			case '4':
				$mes = ['id' => $id, 'descripcion' => 'Abril'];
				break;
			case '5':
				$mes = ['id' => $id, 'descripcion' => 'Mayo'];
				break;
			case '6':
				$mes = ['id' => $id, 'descripcion' => 'Junio'];
				break;
			case '7':
				$mes = ['id' => $id, 'descripcion' => 'Julio'];
				break;
			case '8':
				$mes = ['id' => $id, 'descripcion' => 'Agosto'];
				break;
			case '9':
				$mes = ['id' => $id, 'descripcion' => 'Septiembre'];
				break;
			case '10':
				$mes = ['id' => $id, 'descripcion' => 'Octubre'];
				break;
			case '11':
				$mes = ['id' => $id, 'descripcion' => 'Noviembre'];
				break;
			case '12':
				$mes = ['id' => $id, 'descripcion' => 'Diciembre'];
				break;
		}

		return $mes;
	} */
}
