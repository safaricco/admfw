<?php

use Illuminate\Database\Seeder;

class HelpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ajuda')->insert(['icone' => 'icon-speedometer',      'titulo' => 'Dashboard',            'texto' => 'Permite o usuário ter uma visão de alguns indicadores do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-picture',          'titulo' => 'Banners',              'texto' => 'Permite o usuário a criar, apagar e alterar os banners.']);
        DB::table('ajuda')->insert(['icone' => 'icon-note',             'titulo' => 'Notícias',             'texto' => 'Permite o usuário a criar, apagar e alterar as notícias do blog, criar, apagar e alterar.']);
        DB::table('ajuda')->insert(['icone' => 'icon-check',            'titulo' => 'Categorias',           'texto' => 'Permite o usuário a criar, apagar e alterar as categorias a serem usadas nos produtos, serviços, dicas, eventos e notícias do blog.']);
        DB::table('ajuda')->insert(['icone' => 'icon-arrow-down',       'titulo' => 'Subcategorias',        'texto' => 'Permite o usuário a criar, apagar e alterar as subcategorias de cada categoria.']);
        DB::table('ajuda')->insert(['icone' => 'icon-doc',              'titulo' => 'Sobre',                'texto' => 'Permite o usuário a alterar as informações da página Sobre a empresa.']);
        DB::table('ajuda')->insert(['icone' => 'icon-screen-desktop',   'titulo' => 'Programas',            'texto' => 'Permite o usuário a criar, apagar e alterar os programas do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-social-dropbox',   'titulo' => 'Produtos',             'texto' => 'Permite o usuário a criar, apagar e alterar os produtos do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-home',             'titulo' => 'Imóveis',              'texto' => 'Permite o usuário a criar, apagar e alterar os imóveis do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-screen-tablet',    'titulo' => 'Patrocinadores',       'texto' => 'Permite o usuário a criar, apagar e alterar os patrocinadores do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-speech',           'titulo' => 'Dicas',                'texto' => 'Permite o usuário a criar, apagar e alterar as dicas do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-folder-alt',       'titulo' => 'Eventos',              'texto' => 'Permite o usuário a criar, apagar e alterar os eventos do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-envelope',         'titulo' => 'Newsletter',           'texto' => 'Permite o usuário a visualizar e fazer o download da lista de e-mails coletados através do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-camera',           'titulo' => 'Galeria de Fotos',     'texto' => 'Permite o usuário a criar, apagar e alterar as galerias de fotos do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-camcorder',        'titulo' => 'Galeria de Vídeos',    'texto' => 'Permite o usuário a criar, apagar e alterar as galerias de vídeos do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-bar-chart',        'titulo' => 'Relatórios',           'texto' => 'Permite o usuário a visualizar os relatórios de acesso ao site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Usuários',             'texto' => 'Permite o usuário a criar, alterar os usuários.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Perfis',               'texto' => 'Permite o usuário a criar, alterar os perfis de usuários do painel administrativo do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Contato',              'texto' => 'Permite o usuário a cadastrar as informações de contato que serão exibidas na página de contato do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Config. de E-mail',    'texto' => 'Permite o usuário a alterar as configurações de envio de e-mail do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Config. Analytics',    'texto' => 'Permite o usuário a alterar as configurações do google analytics.']);
        DB::table('ajuda')->insert(['icone' => 'icon-question',         'titulo' => 'Config. Site',         'texto' => 'Permite o usuário a alterar as configurações do site, como logo, logo do rodapé e nome do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-bubbles',          'titulo' => 'Comentários',          'texto' => 'Permite o usuário a gerenciar os comentários das notícias/postagens do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-notebook',         'titulo' => 'Depoimentos',          'texto' => 'Permite o usuário a gerenciar os depoimentos de clientes do site.']);
        DB::table('ajuda')->insert(['icone' => 'icon-graduation',       'titulo' => 'Serviços',             'texto' => 'Permite o usuario a criar, apagar e alterar os serviços prestados pela empresa.']);
    }
}
