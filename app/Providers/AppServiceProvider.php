<?php

namespace App\Providers;

use App\Http\Controllers\Admin\Acesso;
use App\Models\Comentarios;
use App\Models\Configuracao;
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
        if (collect(Configuracao::find(1))->contains(1)):
            view()->share('confsite', Configuracao::find(1));
        endif;

        if (collect(Comentarios::where('id_status_comentario', 1)->get())->count()):
            view()->share('comments', collect(Comentarios::where('id_status_comentario', 1)->get())->count());
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
