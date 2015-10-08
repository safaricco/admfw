@extends('site.static.site')

@section('title', 'Serviços')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Serviços', 'mensagem' => 'Conheça nossos serviços', 'paginabc' => 'Serviços'])

    <div class="container">
        <div class="row" style="padding-top: 40px; padding-bottom: 40px">

            @foreach ($servicos as $servico)


                    <!-- feature box begin -->
                    <div class="feature-box-small-icon span4">
                        <div class="inner">
                            <i class="{{ $servico->ref }}"></i>
                            <div class="text">
                                <a href="{{ url('servicos/'.$servico->id_servico) }}"><h3>{{ $servico->nome }}</h3></a>
                                {!! str_limit($servico->descricao, 80) !!}
                            </div>
                        </div>
                    </div>
                    <!-- feature box close -->

            @endforeach

        </div>
    </div>

@endsection