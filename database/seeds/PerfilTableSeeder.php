<?php

use Illuminate\Database\Seeder;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfil')->insert(['descricao' => 'Administrador']);
        DB::table('perfil')->insert(['descricao' => 'Colaborador']);
    }
}
