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
        /* 01 */ DB::table('tipo_midia')->insert(['descricao' => 'banners']);
        /* 02 */ DB::table('tipo_midia')->insert(['descricao' => 'categorias']);
        /* 03 */ DB::table('tipo_midia')->insert(['descricao' => 'subcategorias']);
        /* 04 */ DB::table('tipo_midia')->insert(['descricao' => 'contato']);
        /* 05 */ DB::table('tipo_midia')->insert(['descricao' => 'dicas']);
        /* 06 */ DB::table('tipo_midia')->insert(['descricao' => 'download']);
        /* 07 */ DB::table('tipo_midia')->insert(['descricao' => 'eventos']);
        /* 08 */ DB::table('tipo_midia')->insert(['descricao' => 'fotos']);
        /* 09 */ DB::table('tipo_midia')->insert(['descricao' => 'imoveis']);
        /* 10 */ DB::table('tipo_midia')->insert(['descricao' => 'noticias']);
        /* 11 */ DB::table('tipo_midia')->insert(['descricao' => 'parceiros']);
        /* 12 */ DB::table('tipo_midia')->insert(['descricao' => 'produtos']);
        /* 13 */ DB::table('tipo_midia')->insert(['descricao' => 'servicos']);
        /* 14 */ DB::table('tipo_midia')->insert(['descricao' => 'programas']);
        /* 15 */ DB::table('tipo_midia')->insert(['descricao' => 'users']);
        /* 16 */ DB::table('tipo_midia')->insert(['descricao' => 'sobre']);
        /* 17 */ DB::table('tipo_midia')->insert(['descricao' => 'patrocinadores']);
        /* 18 */ DB::table('tipo_midia')->insert(['descricao' => 'videos']);
        /* 19 */ DB::table('tipo_midia')->insert(['descricao' => 'empregos']);
        /* 20 */ DB::table('tipo_midia')->insert(['descricao' => 'depoimentos']);
        /* 21 */ DB::table('tipo_midia')->insert(['descricao' => 'help']);
        /* 22 */ DB::table('tipo_midia')->insert(['descricao' => 'destaques']);
        /* 23 */ DB::table('tipo_midia')->insert(['descricao' => 'equipe']);
    }
}
