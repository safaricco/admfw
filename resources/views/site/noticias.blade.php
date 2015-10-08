@extends('site.static.site')

@section('title', 'Blog')

@section('content')

@include('site.static.breadcrumb', ['titulo' => 'Blog', 'mensagem' => 'Fique informado sobre o mundo terapêuta', 'paginabc' => 'Blog'])


    <!-- content begin -->
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="span9">
                    <ul class="blog-list">
                        @foreach($noticias as $blog)
                            <li>
                                <div class="date-box">
                                    <span class="day">{{ date('d', strtotime($blog->data)) }}</span>
                                    <span class="month">{{ date('M', strtotime($blog->data)) }}</span>
                                </div>

                                <div class="post-content">
                                    <div class="post-image">
                                        <span class="post-text">
                                            @foreach($imagens as $imagem)

                                                @if($imagem->id_registro_tabela == $blog->id_noticia)

                                                    <img src="{{ url('thumb/790/400/noticias/'.$imagem->imagem_destacada) }}" alt="" />

                                                @endif

                                            @endforeach
                                        </span>
                                    </div>

                                    <div class="post-text">
                                        <h3><a href="{{ url('blog/' . $blog->slug . '/' . $blog->id_noticia) }}">{{ $blog->titulo }}</a></h3>
                                        {!! $blog->resumo !!}
                                    </div>

                                </div>

                                <div class="post-meta">
                                    <span><i class="icon-user"></i>Por: {{ $blog->autor }}</span>
                                    <span><i class="icon-arrow-right"></i><a href="{{ url('blog/'.$blog->slug . '/' . $blog->id_noticia) }}">Leia Mais</a></span>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="pagination text-center ">
                        {!! $noticias->render() !!}
                    </div>

                </div>

                @include('site.noticias-sidebar')


            </div>
        </div>
    </div>
    <!-- content close -->
@endsection