@extends('site.static.site')

@section('title', 'Galeria')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Galeria', 'mensagem' => str_limit($galeria->titulo, 80), 'paginabc' => 'Galeria'])

    <div id="content">
        <div class="container project-view">
            <div class="row">
                <div class="span12">
                    <h2>{{ $galeria->titulo }}</h2>
                    @include('site.static.facebook-like', ['titulo' => $galeria->titulo])
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="span12">
                    <div class="post-image">
                        <div class="callbacks_container">
                            <ul class="rslides pic_slider">
                                @foreach($imagens as $imagem)

                                    @if(!empty($destacada))

                                        <li><img src="{{ asset('uploads/fotos/'.$destacada->imagem_destacada) }}" alt="" /></li>

                                    @endif

                                    <li><img src="{{ asset('uploads/fotos/' . $imagem->imagem) }}" alt="" /></li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
            <div class="row">
                <div class="span12">
                    {!! $galeria->texto !!}
                </div>
            </div>
        </div>
    </div>

@endsection