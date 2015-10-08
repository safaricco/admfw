@extends('site.static.site')

@section('title', 'Sobre mim')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Sobre mim', 'mensagem' => 'Conheça um pouco sobre mim', 'paginabc' => 'Sobre'])

    <section>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <p>{!! $dados->texto !!}</p>
                </div>
            </div>
        </div>
    </section>

@endsection