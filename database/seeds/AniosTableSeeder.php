<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AniosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('anio')->insert([
            ['id' => '1', 'descripcion' => '2020', 'activo' => 'S']
        ]);
    }
}
