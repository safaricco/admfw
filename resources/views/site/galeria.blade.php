@extends('site.static.site')

@section('title', 'Galeria')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Galeria', 'mensagem' => '', 'paginabc' => 'Galeria'])

<div id="content">
    <div class="container">
        <div class="row">
            <div id="gallery" class="gallery">

                @foreach($fotos as $foto)

                    <div class="span6 item mobile">
                        <div class="picframe">

                            @foreach($imagens as $imagem)

                                @if($imagem->id_registro_tabela == $foto->id_foto)

                                    <span class="overlay">
                                        <span class="info-area">
                                            <a class="img-icon-url" href="{{ url('galeria/' . $foto->id_foto) }}"></a>
                                            <a class="img-icon-zoom" href="{{ asset('uploads/fotos/'.$imagem->imagem_destacada) }}" data-type="prettyPhoto[gallery]" title=""></a>
                                        </span>
                                        <span class="pf_text">
                                            <span class="project-name">{{ $foto->titulo }}</span>
                                            {{--<span>Mobile</span>--}}
                                        </span>
                                    </span>

                                    <img src="{{ url('thumb/570/428/fotos/'.$imagem->imagem_destacada) }}" data-original="{{ asset('uploads/fotos/'.$imagem->imagem_destacada) }}" alt="" />

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