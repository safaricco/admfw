<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert(['descricao' => 'Perfil']);
        DB::table('role')->insert(['descricao' => 'Permitir']);
        DB::table('role')->insert(['descricao' => 'Não Permitir']);
    }
}
