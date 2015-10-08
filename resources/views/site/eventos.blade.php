@extends('site.static.site')

@section('title', 'Eventos')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Eventos', 'mensagem' => '', 'paginabc' => 'Eventos'])

<div id="content">
    <div class="container">
        <div class="row">
            <div id="gallery" class="gallery">

                @foreach($eventos as $evento)

                    <div class="span6 item mobile">
                        <div class="picframe">

                            @foreach($imagens as $imagem)

                                @if($imagem->id_registro_tabela == $evento->id_evento)

                                    <span class="overlay">
                                        <span class="info-area">
                                            <a class="img-icon-url" href="{{ url('eventos/' . $evento->id_evento) }}"></a>
                                            <a class="img-icon-zoom" href="{{ asset('uploads/eventos/'.$imagem->imagem_destacada) }}" data-type="prettyPhoto[gallery]" title=""></a>
                                        </span>
                                        <span class="pf_text">
                                            <span class="project-name">{{ $evento->titulo }}</span>
                                            {{--<span>Mobile</span>--}}
                                        </span>
                                    </span>

                                    <img src="{{ url('thumb/570/428/eventos/'.$imagem->imagem_destacada) }}" data-original="{{ asset('uploads/fotos/'.$imagem->imagem_destacada) }}" alt="" />

                                @endif

                            @endforeach

                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection