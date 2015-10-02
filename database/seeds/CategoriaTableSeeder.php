<?php

use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert(['id_tipo_categoria' => 1, 'titulo' => 'Categoria de Produtos']);
        DB::table('categorias')->insert(['id_tipo_categoria' => 2, 'titulo' => 'Categoria de Serviço']);
        DB::table('categorias')->insert(['id_tipo_categoria' => 3, 'titulo' => 'Categoria de Notícias']);
        DB::table('categorias')->insert(['id_tipo_categoria' => 4, 'titulo' => 'Categoria de Imóveis']);
    }
}
