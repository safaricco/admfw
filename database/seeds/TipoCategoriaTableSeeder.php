<?php


use Illuminate\Database\Seeder;

class TipoCategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_categorias')->insert(['titulo' => 'produto']);
        DB::table('tipo_categorias')->insert(['titulo' => 'servico']);
        DB::table('tipo_categorias')->insert(['titulo' => 'noticia']);
        DB::table('tipo_categorias')->insert(['titulo' => 'imovel']);
    }
}
