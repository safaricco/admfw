<?php

namespace App\Providers;

use App\Http\Controllers\Admin\Acesso;
use App\Models\Analytics;
use App\Models\Categoria;
use App\Models\Comentarios;
use App\Models\Configuracao;
use App\Models\Helps;
use App\Models\Noticia;
use App\Models\Sobres;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (collect(Analytics::find(1))->contains(1)):
            view()->share('analytics', Analytics::find(1));
        endif;

        if (collect(Configuracao::find(1))->contains(1)):
            view()->share('confsite', Configuracao::find(1));
        endif;

        if (collect(Comentarios::where('id_status_comentario', 1)->get())->count()):
            view()->share('comments', collect(Comentarios::where('id_status_comentario', 1)->get())->count());
        endif;

        view()->share('sobre', Sobres::findOrFail(1));

        if (Request::is('blog') or Request::is('blog/*')) :
            view()->share('categorias', Categoria::where('id_tipo_categoria', 3)->get());
            view()->share('ultimas', collect(Noticia::todas())->take(4));
        endif;

        if (Request::is('admin') or Request::is('admin/*')) :
            view()->share('ajuda', Helps::all());
        endif;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
