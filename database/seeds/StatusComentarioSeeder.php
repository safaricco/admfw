<?php

use Illuminate\Database\Seeder;

class StatusComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_comentario')->insert(['nome' => 'Aguardando aprovação']);
        DB::table('status_comentario')->insert(['nome' => 'Aprovado']);
        DB::table('status_comentario')->insert(['nome' => 'Rejeitado']);
        DB::table('status_comentario')->insert(['nome' => 'Lixo']);
        DB::table('status_comentario')->insert(['nome' => 'Span']);
    }
}
