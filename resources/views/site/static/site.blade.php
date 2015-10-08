<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title> {{ $confsite->nome_site }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $confsite->descricao }}">
    <meta name="keywords" content="{{ $confsite->keywords }}">
    <meta name="author" content="Safari Comunicacao">

    @if (Request::is('blog') or Request::is('blog/*'))
        @include('site.static.facebook-meta')
    @endif

    @include('site.static.link')

    <link rel="shortcut icon" href="favicon.ico"/>


</head>

<body>

<div id="wrapper">

    <!-- header begin -->
    <header>
        <div class="container">
            <div id="logo">
                <div class="inner">
                    <a href="{{ url() }}" class="nome">ALCIR MARQUES</a>

                </div>
            </div>

            <!-- mainmenu begin -->
            <ul id="mainmenu">
                <li class="{{ Request::is('/') ? 'active' : ''  }}">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="{{ Request::is('sobre') ? 'active' : ''  }}">
                    <a href="{{ url('sobre') }}">Sobre</a>
                </li>
                <li class="{{ Request::is('produtos') ? 'active' : ''  }}">
                    <a href="{{ url('produtos') }}">Produtos</a>
                </li>
                <li class="{{ Request::is('servicos/*') ? 'active' : ''  }}">
                    <a href="{{ url('servicos') }}">Serviços</a>
                </li>
                <li class="{{ Request::is('galeria/*') ? 'active' : ''  }}">
                    <a href="{{ url('galeria') }}">Galeria</a>
                </li>
                <li class="{{ Request::is('eventos/*') ? 'active' : ''  }}">
                    <a href="{{ url('eventos') }}">Eventos</a>
                </li>
                <li class="{{ Request::is('blog/*') ? 'active' : ''  }}">
                    <a href="{{ url('blog') }}">Blog</a>
                </li>
                <li class="{{ Request::is('contato') ? 'active' : ''  }}">
                    <a href="{{ url('contato') }}">Contato</a>
                </li>
            </ul>
            <!-- mainmenu close -->

        </div>
    </header>
    <!-- header close -->

    @yield('content')

</div>

@include('site.static.footer')