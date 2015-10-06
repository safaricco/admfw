<?php

use Illuminate\Database\Seeder;

class FuncaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 01 */ DB::table('funcao')->insert(['acesso' => 'banners',        'nome' => 'Banners',                  'descricao' => 'Permite o usuário a criar, apagar e alterar os banners.']);
        /* 02 */ DB::table('funcao')->insert(['acesso' => 'noticias',       'nome' => 'Notícias',                 'descricao' => 'Permite o usuário a criar, apagar e alterar as notícias do blog, criar, apagar e alterar.']);
        /* 03 */ DB::table('funcao')->insert(['acesso' => 'categorias',     'nome' => 'Categorias',               'descricao' => 'Permite o usuário a criar, apagar e alterar as categorias a serem usadas nos produtos, serviços, dicas, eventos e notícias do blog.']);
        /* 04 */ DB::table('funcao')->insert(['acesso' => 'subcategorias',  'nome' => 'Subcategorias',            'descricao' => 'Permite o usuário a criar, apagar e alterar as subcategorias de cada categoria.']);
        /* 05 */ DB::table('funcao')->insert(['acesso' => 'sobre',          'nome' => 'Sobre',                    'descricao' => 'Permite o usuário a alterar as informações da página Sobre a empresa.']);
        /* 06 */ DB::table('funcao')->insert(['acesso' => 'programas',      'nome' => 'Programas',                'descricao' => 'Permite o usuário a criar, apagar e alterar os programas do site.']);
        /* 07 */ DB::table('funcao')->insert(['acesso' => 'produtos',       'nome' => 'Produtos',                 'descricao' => 'Permite o usuário a criar, apagar e alterar os produtos do site.']);
        /* 08 */ DB::table('funcao')->insert(['acesso' => 'imoveis',        'nome' => 'Imóveis',                  'descricao' => 'Permite o usuário a criar, apagar e alterar os imóveis do site.']);
        /* 09 */ DB::table('funcao')->insert(['acesso' => 'patrocinadores', 'nome' => 'Patrocinadores',           'descricao' => 'Permite o usuário a criar, apagar e alterar os patrocinadores do site.']);
        /* 10 */ DB::table('funcao')->insert(['acesso' => 'dicas',          'nome' => 'Dicas',                    'descricao' => 'Permite o usuário a criar, apagar e alterar as dicas do site.']);
        /* 11 */ DB::table('funcao')->insert(['acesso' => 'eventos',        'nome' => 'Eventos',                  'descricao' => 'Permite o usuário a criar, apagar e alterar os eventos do site.']);
        /* 12 */ DB::table('funcao')->insert(['acesso' => 'newsletter',     'nome' => 'Newsletter',               'descricao' => 'Permite o usuário a visualizar e fazer o download da lista de e-mails coletados através do site.']);
        /* 13 */ DB::table('funcao')->insert(['acesso' => 'fotos',          'nome' => 'Galeria de Fotos',         'descricao' => 'Permite o usuário a criar, apagar e alterar as galerias de fotos do site.']);
        /* 14 */ DB::table('funcao')->insert(['acesso' => 'videos',         'nome' => 'Galeria de Vídeos',        'descricao' => 'Permite o usuário a criar, apagar e alterar as galerias de vídeos do site.']);
        /* 15 */ DB::table('funcao')->insert(['acesso' => 'relatorios',     'nome' => 'Relatórios',               'descricao' => 'Permite o usuário a visualizar os relatórios de acesso ao site.']);
        /* 16 */ DB::table('funcao')->insert(['acesso' => 'usuarios',       'nome' => 'Usuários',                 'descricao' => 'Permite o usuário a criar, alterar os usuários.']);
        /* 17 */ DB::table('funcao')->insert(['acesso' => 'perfis',         'nome' => 'Perfis',                   'descricao' => 'Permite o usuário a criar, alterar os perfis de usuários do painel administrativo do site.']);
        /* 18 */ DB::table('funcao')->insert(['acesso' => 'contato',        'nome' => 'Contato',                  'descricao' => 'Permite o usuário a cadastrar as informações de contato que serão exibidas na página de contato do site.']);
        /* 19 */ DB::table('funcao')->insert(['acesso' => 'email',          'nome' => 'Config. de E-mail',        'descricao' => 'Permite o usuário a alterar as configurações de envio de e-mail do site.']);
        /* 20 */ DB::table('funcao')->insert(['acesso' => 'analytics',      'nome' => 'Config. Analytics',        'descricao' => 'Permite o usuário a alterar as configurações do google analytics.']);
        /* 21 */ DB::table('funcao')->insert(['acesso' => 'site',           'nome' => 'Config. Site',             'descricao' => 'Permite o usuário a alterar as configurações do site, como logo, logo do rodapé e nome do site.']);
        /* 22 */ DB::table('funcao')->insert(['acesso' => 'comentarios',    'nome' => 'Comentários',              'descricao' => 'Permite o usuário a gerenciar os comentários das notícias/postagens do site.']);
        /* 23 */ DB::table('funcao')->insert(['acesso' => 'depoimentos',    'nome' => 'Depoimentos',              'descricao' => 'Permite o usuário a gerenciar os depoimentos de clientes do site.']);
        /* 24 */ DB::table('funcao')->insert(['acesso' => 'servicos',       'nome' => 'Serviços',                 'descricao' => 'Permite o usuario a criar, apagar e alterar os serviços prestados pela empresa.']);
        /* 25 */ DB::table('funcao')->insert(['acesso' => 'multimidia',     'nome' => 'Multimidia',               'descricao' => 'Permite o usuario a exluir uma única imagem por vez.']);
    }
}
