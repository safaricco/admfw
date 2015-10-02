<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* SITE */
Route::get('/','SiteHome@index');
Route::get('/sobre/','SiteSobre@index');
Route::get('/programas/','SiteProgramas@index');
Route::get('/programas/{id}','SiteProgramas@show@{id}');
Route::get('/patrocinadores/','SitePatrocinadores@index');
Route::get('/patrocinadores/{id}','SitePatrocinadores@show@{id}');
Route::get('/noticias/','SiteNoticias@index');
Route::get('/noticias/{id}','SiteNoticias@show@{id}');
Route::get('/dicas/','SiteDicas@index');
Route::get('/dicas/{id}','SiteDicas@show@{id}');
Route::get('/eventos/','SiteEventos@index');
Route::get('/eventos/{id}','SiteEventos@show@{id}');
Route::get('/contato/','SiteContato@index');

// usado para fazer o thumb
Route::get('thumb/{width}/{height}/{tipo}/{img}', 'Imagem@thumb@{width}@{height}@{tipo}@{img}');

/* ADMIN */
Route::group(['prefix' => 'admin/', 'middleware' => 'auth.aux'], function(){

    Route::get('', function () { return Redirect::to('/admin/dashboard'); });
    Route::get('home', function (){ return redirect('admin/dashboard');});
    Route::get('dashboard', 'Admin\Dashboard@index');

    // ROTA PARA EXLUIR QUALQUER FOTO ÚNICA NA TABELA MULTIMIDIA, SERVE PARA QUALQUER CONTROLLER
    Route::post('multimidia/destroyFoto', 'Imagem@destroyFoto');

    Route::group(['prefix' => 'newsletter/'], function(){
        Route::get('listar', 'Admin\Newsletters@index');
        Route::get('novo', 'Admin\Newsletters@create');
        Route::post('store', 'Admin\Newsletters@store');
        Route::get('editar/{id}', 'Admin\Newsletters@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Newsletters@update@{id}');
        Route::post('destroy/{id}', 'Admin\Newsletters@destroy@{id}');

    });

    Route::group(['prefix' => 'noticias/'], function(){
        Route::get('listar', 'Admin\Noticias@index');
        Route::get('novo', 'Admin\Noticias@create');
        Route::post('store', 'Admin\Noticias@store');
        Route::get('editar/{id}', 'Admin\Noticias@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Noticias@update@{id}');
        Route::get('destroy/{id}', 'Admin\Noticias@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Noticias@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'categorias/'], function(){
        Route::get('listar', 'Admin\Categorias@index');
        Route::get('novo', 'Admin\Categorias@create');
        Route::post('store', 'Admin\Categorias@store');
        Route::get('editar/{id}', 'Admin\Categorias@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Categorias@update@{id}');
        Route::post('destroy/{id}', 'Admin\Categorias@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Categorias@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'subcategorias/'], function(){
        Route::get('listar', 'Admin\Subcategorias@index');
        Route::get('novo', 'Admin\Subcategorias@create');
        Route::post('store', 'Admin\Subcategorias@store');
        Route::get('editar/{id}', 'Admin\Subcategorias@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Subcategorias@update@{id}');
        Route::post('destroy/{id}', 'Admin\Subcategorias@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Subcategorias@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'comentarios/'], function(){
        Route::get('listar/{filtro?}', 'Admin\Comentario@index@{filtro?}');
        Route::get('novo', 'Admin\Comentario@create');
        Route::post('responder', 'Admin\Comentario@store');
        Route::get('editar/{id}', 'Admin\Comentario@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Comentario@update@{id}');
        Route::post('destroy/{id}', 'Admin\Comentario@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Comentario@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'sobre/'], function(){
        Route::get('listar', 'Admin\Sobre@index');
        Route::get('novo', 'Admin\Sobre@create');
        Route::post('store', 'Admin\Sobre@store');
        Route::get('editar/{id}', 'Admin\Sobre@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Sobre@update@{id}');
        Route::get('destroy/{id}', 'Admin\Sobre@destroy@{id}');
    });

    Route::group(['prefix' => 'programas/'], function(){
        Route::get('listar', 'Admin\Programas@index');
        Route::get('novo', 'Admin\Programas@create');
        Route::post('store', 'Admin\Programas@store');
        Route::get('editar/{id}', 'Admin\Programas@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Programas@update@{id}');
        Route::get('destroy/{id}', 'Admin\Programas@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Programas@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'patrocinadores/'], function(){
        Route::get('listar', 'Admin\Patrocinadores@index');
        Route::get('novo', 'Admin\Patrocinadores@create');
        Route::post('store', 'Admin\Patrocinadores@store');
        Route::get('editar/{id}', 'Admin\Patrocinadores@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Patrocinadores@update@{id}');
        Route::get('destroy/{id}', 'Admin\Patrocinadores@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Patrocinadores@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'produtos/'], function(){
        Route::get('listar', 'Admin\Produto@index');
        Route::get('novo', 'Admin\Produto@create');
        Route::post('store', 'Admin\Produto@store');
        Route::get('editar/{id}', 'Admin\Produto@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Produto@update@{id}');
        Route::get('destroy/{id}', 'Admin\Produto@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Produtos@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'servicos/'], function(){
        Route::get('listar', 'Admin\Servico@index');
        Route::get('novo', 'Admin\Servico@create');
        Route::post('store', 'Admin\Servico@store');
        Route::get('editar/{id}', 'Admin\Servico@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Servico@update@{id}');
        Route::get('destroy/{id}', 'Admin\Servico@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Servico@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'imoveis/'], function(){
        Route::get('listar', 'Admin\Imoveis@index');
        Route::get('novo', 'Admin\Imoveis@create');
        Route::post('store', 'Admin\Imoveis@store');
        Route::get('editar/{id}', 'Admin\Imoveis@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Imoveis@update@{id}');
        Route::get('destroy/{id}', 'Admin\Imoveis@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Imoveis@updateStatus@{status}@{id}');

    });

    Route::group(['prefix' => 'dicas/'], function(){
        Route::get('listar', 'Admin\Dicas@index');
        Route::get('novo', 'Admin\Dicas@create');
        Route::post('store', 'Admin\Dicas@store');
        Route::get('editar/{id}', 'Admin\Dicas@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Dicas@update@{id}');
        Route::get('destroy/{id}', 'Admin\Dicas@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Dicas@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'eventos/'], function(){
        Route::get('listar', 'Admin\Eventos@index');
        Route::get('novo', 'Admin\Eventos@create');
        Route::post('store', 'Admin\Eventos@store');
        Route::get('editar/{id}', 'Admin\Eventos@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Eventos@update@{id}');
        Route::get('destroy/{id}', 'Admin\Eventos@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Eventos@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'fotos/'], function(){
        Route::get('listar', 'Admin\Fotos@index');
        Route::get('novo', 'Admin\Fotos@create');
        Route::post('store', 'Admin\Fotos@store');
        Route::get('editar/{id}', 'Admin\Fotos@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Fotos@update@{id}');
        Route::get('destroy/{id}', 'Admin\Fotos@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Fotos@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'depoimentos/'], function(){
        Route::get('listar', 'Admin\Depoimento@index');
        Route::get('novo', 'Admin\Depoimento@create');
        Route::post('store', 'Admin\Depoimento@store');
        Route::get('editar/{id}', 'Admin\Depoimento@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Depoimento@update@{id}');
        Route::get('destroy/{id}', 'Admin\Depoimento@destroy@{id}');
        Route::get('status/{status}/{id}', 'Admin\Depoimento@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'videos/'], function(){
        Route::get('listar', 'Admin\Videos@index');
        Route::get('novo', 'Admin\Videos@create');
        Route::post('store', 'Admin\Videos@store');
        Route::get('editar/{id}', 'Admin\Videos@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Videos@update@{id}');
        Route::get('destroy/{id}', 'Admin\Videos@destroy@{id}');
        Route::post('destroyFoto', 'Admin\Videos@destroyFoto');
        Route::get('status/{status}/{id}', 'Admin\Videos@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'banners/'], function(){
        Route::get('listar', 'Admin\Banners@index');
        Route::get('novo', 'Admin\Banners@create');
        Route::post('store', 'Admin\Banners@store');
        Route::get('editar/{id}', 'Admin\Banners@show@{id}');
        Route::put('atualizar/{id}', 'Admin\Banners@update@{id}');
        Route::get('destroy/{id}', 'Admin\Banners@destroy@{id}');
        Route::post('destroyFoto', 'Admin\Banners@destroyFoto');
        Route::get('status/{status}/{id}', 'Admin\Banners@updateStatus@{status}@{id}');
    });

    Route::group(['prefix' => 'configuracoes/'], function(){

        Route::group(['prefix' => 'site/'], function(){
            Route::get('/', 'Admin\Configuracoes@index');
            Route::put('editar/{id}', 'Admin\Configuracoes@update@{id}');
        });

        Route::group(['prefix' => 'analytics/'], function(){
            Route::get('/', 'Admin\Analytic@index');
            Route::put('editar/{id}', 'Admin\Analytic@update@{id}');
        });

        Route::group(['prefix' => 'email/'], function(){
            Route::get('/', 'Admin\Email@index');
            Route::put('editar/{id}', 'Admin\Email@update@{id}');
        });

        Route::group(['prefix' => 'contato/'], function(){
            Route::get('/', 'Admin\Contato@index');
            Route::put('editar/{id}', 'Admin\Contato@update@{id}');
        });

        Route::group(['prefix' => 'usuarios/'], function(){
            Route::get('listar', 'Admin\Usuarios@index');
            Route::get('novo', 'Admin\Usuarios@create');
            Route::post('store', 'Admin\Usuarios@store');
            Route::get('editar/{id}', 'Admin\Usuarios@show@{id}');
            Route::put('atualizar/{id}', 'Admin\Usuarios@update@{id}');
            Route::get('status/{status}/{id}', 'Admin\Usuarios@updateStatus@{status}@{id}');

            Route::group(['prefix' => 'perfil/'], function(){
                Route::get('editar/{id}', 'Admin\Usuarios@edit@{id}');
                Route::post('foto/{id}', 'Admin\Usuarios@updateFoto@{id}');
                Route::post('dados/{id}', 'Admin\Usuarios@updatePerfil@{id}');
                Route::post('senha/{id}', 'Admin\Usuarios@updateSenha@{id}');
            });
        });

        Route::group(['prefix' => 'perfis/'], function(){
            Route::get('listar', 'Admin\Perfis@index');
            Route::get('novo', 'Admin\Perfis@create');
            Route::post('store', 'Admin\Perfis@store');
            Route::get('editar/{id}', 'Admin\Perfis@show@{id}');
            Route::put('atualizar/{id}', 'Admin\Perfis@update@{id}');
            Route::get('destroy/{id}', 'Admin\Perfis@destroy@{id}');
            Route::get('status/{status}/{id}', 'Admin\Perfis@updateStatus@{status}@{id}');
        });

        Route::group(['prefix' => 'modulos/'], function(){
            Route::get('listar', 'Admin\Funcoes@index');
            Route::get('novo', 'Admin\Funcoes@create');
            Route::post('store', 'Admin\Funcoes@store');
            Route::get('editar/{id}', 'Admin\Funcoes@show@{id}');
            Route::put('atualizar/{id}', 'Admin\Funcoes@update@{id}');
            Route::get('destroy/{id}', 'Admin\Funcoes@destroy@{id}');
            Route::get('status/{status}/{id}', 'Admin\Funcoes@updateStatus@{status}@{id}');
        });
    });
});

/* ADMIN */
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('/login', function (){ return redirect('admin/login');});
Route::get('/admin/login', function (){ return view('admin/login');});
Route::post('/admin/login/logar', 'Admin\Login@logar');
Route::post('recuperar-senha', 'Recuperar@store');