<?php

use Illuminate\Database\Seeder;

class PerfilUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfil_user')->insert(['id_perfil' => 1, 'id_user' => 2]);
    }
}
