<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mes')->insert([
            ['id' => '1', 'descripcion' => 'Enero', 'activo' => 'S'],
            ['id' => '2', 'descripcion' => 'Febrero', 'activo' => 'S'],
            ['id' => '3', 'descripcion' => 'Marzo', 'activo' => 'S'],
            ['id' => '4', 'descripcion' => 'Abril', 'activo' => 'S'],
            ['id' => '5', 'descripcion' => 'Mayo', 'activo' => 'S'],
            ['id' => '6', 'descripcion' => 'Junio', 'activo' => 'S'],
            ['id' => '7', 'descripcion' => 'Julio', 'activo' => 'S'],
            ['id' => '8', 'descripcion' => 'Agosto', 'activo' => 'S'],
            ['id' => '9', 'descripcion' => 'Septiembre', 'activo' => 'S'],
            ['id' => '10', 'descripcion' => 'Octubre', 'activo' => 'S'],
            ['id' => '11', 'descripcion' => 'Noviembre', 'activo' => 'S'],
            ['id' => '12', 'descripcion' => 'Diciembre', 'activo' => 'S']
        ]);
    }
}
