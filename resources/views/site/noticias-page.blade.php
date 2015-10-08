@extends('site.static.site')

@section('title', 'Blog')

@section('content')

@include('site.static.breadcrumb', ['titulo' => 'Blog', 'mensagem' => 'Fique informado sobre o mundo terapêuta', 'paginabc' => 'Blog'])


    <!-- content begin -->
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="span9">

                    <div class="blog-read">
                        <div class="date-box">
                            <span class="day">{{ date('d', strtotime($blog->data)) }}</span>
                            <span class="month">{{ date('M', strtotime($blog->data)) }}</span>
                        </div>
                        <div class="post-content">
                            <div class="post-image">
                                <div class="callbacks_container">
                                    <ul class="rslides pic_slider">

                                        @foreach($imagens as $imagem)

                                            @if(!empty($destacada))

                                                <li><img src="{{ asset('uploads/noticias/'.$destacada->imagem_destacada) }}" alt="" /></li>

                                            @endif

                                            <li><img src="{{ asset('uploads/noticias/' . $imagem->imagem) }}" alt="" /></li>

                                        @endforeach

                                    </ul>
                                </div>
                            </div>


                            <div class="post-text">

                                @include('site.static.facebook-like', ['titulo' => $blog->titulo])

                                <h3><a href="{{ url('blog/' . $blog->slug . '/' . $blog->id_noticia) }}">{{ $blog->titulo }}</a></h3>

                                <p>{!! $blog->texto !!}</p>

                            </div>
                        </div>
                        {{--<div class="post-meta"><span><i class="icon-user"></i>By: <a href="#">Lynda Wu</a></span> <span><i class="icon-tag"></i><a href="#">News</a>, <a href="#">Events</a></span> <span><i class="icon-comment"></i><a href="#">10 Comments</a></span></div>--}}
                    </div>

                </div>

                @include('site.noticias-sidebar')


            </div>
        </div>
    </div>
    <!-- content close -->

@endsection