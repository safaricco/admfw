@extends('site.static.site')

@section('title', 'Serviço')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => $servico->nome, 'mensagem' => str_limit($servico->resumo, 80), 'paginabc' => 'Serviços'])

    <div class="container">
        <div style="padding-bottom: 40px; padding-top: 40px">

            @if (!empty($servico->Descricao))
                {{ $servico->descricao }}
            @endif


            @if (!empty($imagens))

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding detnoticias_fotos">

                @foreach ($imagens as $imagem)


                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 foto padding">
                        <!--div class="box"-->
                            <div class="box-imagem">
                                <div class="imagem-video">
                                    <img src="{{ url('thumb/238/180/servicos/'.$imagem->imagem) }}" class="img-responsive img-rounded" />
                                    <!--img src="' . site_url('public/imagens/servico/' . $imagem->Imagem) .'" class="img-responsive img-rounded" /-->
                                </div>
                            </div>
                        <!--/div-->
                    </div>

                @endforeach

            </div>

            @endif

            @if (!empty($servico->Video))

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <iframe width="600" height="480" src="https://www.youtube.com/embed/{{ $servico->Video }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif
        </div>

@endsection