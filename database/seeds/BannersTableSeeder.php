<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* GRAVANDO BANNER 1 */
        DB::table('banners')->insert([
            'id_banner'     => 1,
            'titulo'        => 'Banner 1 exemplo',
            'texto'         => 'Texto exemplo',
            'link'          => '',
            'data_inicio'   => '',
            'data_final'    => '',
            'status'        => 1,
        ]);

        DB::table('midia')->insert([
            'id_midia'      => 1,
            'id_tipo_midia' => 1,
            'descricao'     => 'banners criado automaticamente',
            'status'        => 1,
        ]);

        DB::table('multimidia')->insert([
            'id_midia'      => 1,
            'imagem'        => 'BANNER.png',
            'status'        => 1,
        ]);

        /* GRAVANDO BANNER 2 */
        DB::table('banners')->insert([
            'id_banner'     => 2,
            'titulo'        => 'Banner 2 exemplo',
            'texto'         => 'Texto exemplo',
            'link'          => '',
            'data_inicio'   => '',
            'data_final'    => '',
            'status'        => 1,
        ]);

        DB::table('midia')->insert([
            'id_midia'      => 2,
            'id_tipo_midia' => 1,
            'descricao'     => 'banners criado automaticamente',
            'status'        => 1,
        ]);

        DB::table('multimidia')->insert([
            'id_midia'      => 2,
            'imagem'        => 'BANNER.png',
            'status'        => 1,
        ]);

        /* GRAVANDO BANNER 3 */
        DB::table('banners')->insert([
            'id_banner'     => 3,
            'titulo'        => 'Banner 3 exemplo',
            'texto'         => 'Texto exemplo',
            'link'          => '',
            'data_inicio'   => '',
            'data_final'    => '',
            'status'        => 1,
        ]);

        DB::table('midia')->insert([
            'id_midia'      => 3,
            'id_tipo_midia' => 1,
            'descricao'     => 'banners criado automaticamente',
            'status'        => 1,
        ]);

        DB::table('multimidia')->insert([
            'id_midia'      => 3,
            'imagem'        => 'BANNER.png',
            'status'        => 1,
        ]);
    }
}
