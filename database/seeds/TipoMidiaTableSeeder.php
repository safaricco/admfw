<?php

use Illuminate\Database\Seeder;

class TipoMidiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_midia')->insert(['descricao' => 'banners']);
        DB::table('tipo_midia')->insert(['descricao' => 'categorias']);
        DB::table('tipo_midia')->insert(['descricao' => 'subcategorias']);
        DB::table('tipo_midia')->insert(['descricao' => 'contato']);
        DB::table('tipo_midia')->insert(['descricao' => 'dicas']);
        DB::table('tipo_midia')->insert(['descricao' => 'download']);
        DB::table('tipo_midia')->insert(['descricao' => 'eventos']);
        DB::table('tipo_midia')->insert(['descricao' => 'fotos']);
        DB::table('tipo_midia')->insert(['descricao' => 'imoveis']);
        DB::table('tipo_midia')->insert(['descricao' => 'noticias']);
        DB::table('tipo_midia')->insert(['descricao' => 'parceiros']);
        DB::table('tipo_midia')->insert(['descricao' => 'produtos']);
        DB::table('tipo_midia')->insert(['descricao' => 'servicos']);
        DB::table('tipo_midia')->insert(['descricao' => 'programas']);
        DB::table('tipo_midia')->insert(['descricao' => 'users']);
        DB::table('tipo_midia')->insert(['descricao' => 'sobre']);
        DB::table('tipo_midia')->insert(['descricao' => 'patrocinadores']);
        DB::table('tipo_midia')->insert(['descricao' => 'videos']);
        DB::table('tipo_midia')->insert(['descricao' => 'empregos']);
        DB::table('tipo_midia')->insert(['descricao' => 'depoimentos']);
    }
}
