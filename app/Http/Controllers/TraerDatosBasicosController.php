<?php

namespace App\Http\Controllers;

use App\Anios;
use App\Meses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraerDatosBasicosController extends Controller
{
	public function TraerAnios()
	{
		return Anios::traerAnios();
	}
	public function TraerMeses()
	{
		return Meses::traerMeses();
	}
}
