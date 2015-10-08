@extends('site.static.site')

@section('title', 'Home')

@section('content')

    @include('site.static.banner')

    <div id="content" class="no-bottom">

        <div class="container">

            @if (!empty($servicos))
                <div class="block-title text-center">
                    <h1>Nossos serviços</h1>
                    Conheça nossos serviços
                </div>
                <div class="row">


                   @foreach ($servicos as $servico)

                        <div class="feature-box-small-icon span4">
                            <div class="inner">
                                <i class="{{ $servico->ref }}"></i>
                                <div class="text">
                                    <a href="{{ url('servicos/'.$servico->id_servico) }}"><h3>{{ $servico->nome }}</h3></a>
                                    {!! str_limit($servico->descricao, 80) !!}
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>

            @endif

            <hr>
        </div>



        <div class="container">

            @if (!empty($produtos))

                <div class="project">
                    <div class="container">
                        <div class="row">
                            <div class="span12">
                                <div class="block-title text-center">
                                    <h1>Produtos da Terapêutica Nutricional</h1>
                                    Conheça nossa linha de produtos terapêuticos
                                </div>
                                <div class="control-slider">
                                    <span class="prev-slider-produto"><i class="icon-chevron-left"></i></span><span class="next-slider-produto"><i class="icon-chevron-right"></i></span>
                                </div>
                            </div>


                            <div class="clearfix"></div>
                            <div class="flexslider produto-carousel project-carousel-3-col">

                                <ul class="slides">

                                    @foreach ($produtos as $produto)

                                        <li class="produto">
                                            <div class="span3">
                                                <div class="picframe">

                                                    <div class="produto_img">
                                                        <center>
                                                            <img data-src="holder.js/300x200" alt="" src="{{ $produto->Imagem }}">
                                                        </center>
                                                        <div class="caption">
                                                            <center>
                                                                <h4><a href="http://www.terapeuticanutricional.com.br/produto/viewProduto/{{ $produto->Id }}" target="_blank" title="{{ $produto->Nome }}">{{ $produto->Nome }}</a></h4>
                                                                <p><a href="http://www.terapeuticanutricional.com.br/produto/viewProduto/{{ $produto->Id }}" target="_blank" class="btn btn-primary">Saiba Mais</a></p>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </div>

                    </div>
                </div>


            @endif

            <hr>
        </div>

        <div class="container">
            <div class="row">

                @if(!empty($noticias))
                    <div class="span8">
                        <div class="block-title text-center">
                            <h3>Últimas postagens no blog</h3>
                        </div>

                        <div class="row">

                            @foreach($noticias as $noticia)

                                <div class="feature-box-image span4">
                                    <div class="inner">
                                        <div class="text">
                                            <img src="{{ url('thumb/372/187/noticias/' . $noticia->imagem_destacada) }}" data-original="images/feature-pic-1.jpg" alt="">
                                            <h3>{{ $noticia->titulo }}</h3>
                                            {{ str_limit($noticia->resumo, 100) }}
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>

                    </div>
                @endif

                @if(!empty($depoimentos))
                    <div class="project">
                        <div class="span4">
                            <div class="row">
                                <div class="span4">
                                    <h3 class="float-left">Depoimentos</h3>
                                    <div class="control-slider">
                                        <span class="prev-slider"><i class="icon-chevron-left"></i></span><span class="next-slider"><i class="icon-chevron-right"></i></span>
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                                <div class="flexslider pf-carousel project-carousel">

                                    <ul class="slides gallery">
                                        @foreach($depoimentos as $depo)
                                            <li class="single-pf-item item">
                                                <div class="span4">
                                                    <div class="de_testi">

                                                        @if(!empty($depo->video))
                                                            <blockquote>
                                                                <iframe width="310" height="210" src="https://www.youtube.com/embed/{{ $depo->video }}" frameborder="0" allowfullscreen></iframe>
                                                            </blockquote>
                                                        @else

                                                            <blockquote>
                                                                <p>{!! $depo->texto !!}</p>
                                                            </blockquote>

                                                        @endif

                                                        <div class="de_testi_by">
                                                            <div class="de_testi_company">
                                                                <strong>{{ $depo->nome }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach


                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection