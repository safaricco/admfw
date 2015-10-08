@extends('site.static.site')

@section('title', 'Produtos')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Produtos', 'mensagem' => 'Conheça os produtos terapêutica nutricional', 'paginabc' => 'Produtos'])

    <div class="container">

        <ul class="thumbnails">
            @foreach ($produtos as $produto)

                <li class="span3 produto">
                    <div class="thumbnail produto_img">
                        <img data-src="holder.js/300x200" alt="" src="{{ $produto->Imagem }}">
                        <div class="caption">
                            <h3>{{ str_limit($produto->Nome, 10) }}</h3>
                            <p><a href="http://www.terapeuticanutricional.com.br/produto/viewProduto/{{ $produto->Id }}" target="_blank" class="btn btn-primary">Saiba Mais</a></p>
                        </div>
                    </div>
                </li>

            @endforeach
        </ul>
    </div>

@endsection