<?php

use Illuminate\Database\Seeder;

class SubcategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategorias')->insert(['id_categoria' => 1, 'titulo' => 'Subcategoria de Produtos']);
        DB::table('subcategorias')->insert(['id_categoria' => 2, 'titulo' => 'Subcategoria de Serviço']);
        DB::table('subcategorias')->insert(['id_categoria' => 3, 'titulo' => 'Subcategoria de Notícias']);
        DB::table('subcategorias')->insert(['id_categoria' => 4, 'titulo' => 'Subcategoria de Imóveis']);
    }
}
