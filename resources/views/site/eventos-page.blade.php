@extends('site.static.site')

@section('title', 'Eventos')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Eventos', 'mensagem' => str_limit($evento->titulo, 80), 'paginabc' => 'Eventos'])


    <div id="content">
        <div class="container project-view">
            <div class="row">
                <div class="span9">
                    <div class="post-image">
                        <div class="callbacks_container">
                            <ul class="rslides pic_slider">
                                @foreach($imagens as $imagem)

                                    @if(!empty($destacada))

                                        <li><img src="{{ asset('uploads/eventos/'.$destacada->imagem_destacada) }}" alt="" /></li>

                                    @endif

                                    <li><img src="{{ asset('uploads/eventos/' . $imagem->imagem) }}" alt="" /></li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="span3">
                    <h4>{{ $evento->titulo }}</h4>
                    {!! $evento->texto !!}
                    <hr>
                    @include('site.static.facebook-like', ['titulo' => $evento->titulo])
                </div>

            </div>
        </div>
    </div>

@endsection