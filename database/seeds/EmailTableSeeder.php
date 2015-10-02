<?php

use Illuminate\Database\Seeder;

class EmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->insert([
            'protocolo' => 'smtp',
            'host'      => 'smtp.safaricomunicacao.com',
            'porta'     => 587,
            'endereco'  => 'noreply@safaricomunicacao.com',
            'senha'     => 'cont#9080'
        ]);
    }
}
