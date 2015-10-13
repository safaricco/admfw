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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    @include('admin.static.link')

    <link rel="shortcut icon" href="favicon.ico"/>

</head>

<body class="page-header-fixed page-quick-sidebar-over-content ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                <h3 style="margin:5px; padding:5px; color:#ffffff;">{{ $confsite->nome_site }}</h3>
{{--                <img src="{{asset('thumb/null/60/logo/' . $confsite->logo)}}" alt="logo" class="logo-default"/>--}}
            </a>
            <div class="menu-toggler sidebar-toggler hide">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="{{ url('admin/help/listar') }}" title="Ajuda" class="dropdown-toggle">
                        <i class="icon-question"></i>
                    </a>
                </li>
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="{{ url('assets/admin/admin/pages/media/sem-imagem.png') }}"/>
					    <span class="username username-hide-on-mobile">{{ Auth::user()->name }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ url('admin/configuracoes/usuarios/perfil/editar/' . Auth::user()->id) }}">
                                <i class="icon-user"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="icon-star"></i> Sobre
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/help/listar') }}" title="Ajuda">
                                <i class="icon-question"></i> Ajuda
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('auth/logout') }}">
                                <i class="icon-logout"></i> Sair </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="{{ url('auth/logout') }}" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper">
                    
                    <div class="sidebar-toggler">
                    </div>
                  
                </li>

                {{--DASHBOARD--}}
                <li class="{{ Request::is('admin/dashboard') ? 'active' : ''  }}">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="icon-speedometer"></i>
                        <span class="title"> Dashboard </span>
                        <span class="selected"></span>
                    </a>
                </li>

                {{--BANNERS--}}
                @if(Access::permissao('banners'))
                    <li class="{{ Request::is('admin/banners/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-picture"></i>
                            <span class="title"> Banners </span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/banners/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/banners/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/banners/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/banners/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{--NOTICIAS--}}
                @if(Access::permissao('notícias'))
                    <li class="{{ Request::is('admin/noticias/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-note"></i>
                            <span class="title">Notícias</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/noticias/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/noticias/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/noticias/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/noticias/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--CATEGORIAS--}}
                @if(Access::permissao('categorias'))
                    <li class="{{ Request::is('admin/categorias/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-check"></i>
                            <span class="title">Categorias</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/categorias/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/categorias/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/categorias/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/categorias/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--SUBCATEGORIAS--}}
                @if(Access::permissao('subcategorias'))
                    <li class="{{ Request::is('admin/subcategorias/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-arrow-down"></i>
                            <span class="title">Subcategorias</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/subcategorias/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/subcategorias/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/subcategorias/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/subcategorias/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--COMENTARIOS--}}
                @if(Access::permissao('comentários'))
                    <li class="{{ Request::is('admin/comentarios/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-bubbles"></i>
                            <span class="title">Comentários</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                            <span class="badge badge-warning">{{ $comments or ''}}</span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/comentarios/listar/todos') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/todos')}}"> Listar Todos</a>
                            </li>

                            <li class="{{ Request::is('admin/comentarios/listar/aguardando') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/aguardando')}}"> Aguardando <span class="badge badge-warning">{{ $comments or '' }}</span></a>
                            </li>

                            <li class="{{ Request::is('admin/comentarios/listar/aprovados') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/aprovados')}}"> Aprovados</a>
                            </li>

                            <li class="{{ Request::is('admin/comentarios/listar/rejeitados') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/rejeitados')}}"> Rejeitados</a>
                            </li>

                            <li class="{{ Request::is('admin/comentarios/listar/span') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/span')}}"> Span</a>
                            </li>

                            <li class="{{ Request::is('admin/comentarios/listar/lixo') ? 'active' : ''  }}">
                                <a href="{{url('admin/comentarios/listar/lixo')}}"> Lixeira</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--SOBRE--}}
                @if(Access::permissao('sobre'))
                    <li class="{{ Request::is('admin/sobre/*') ? 'active open' : ''  }}">
                        <a href="{{ url('admin/sobre/editar/1') }}">
                            <i class="icon-doc"></i>
                            <span class="title">Sobre</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endif

                {{--PROGRAMA--}}
                @if(Access::permissao('programas'))
                    <li class="{{ Request::is('admin/programas/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-screen-desktop"></i>
                            <span class="title">Programas</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/programas/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/programas/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/programas/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/programas/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--EQUIPE--}}
                @if(Access::permissao('equipe'))
                    <li class="{{ Request::is('admin/equipe/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-users"></i>
                            <span class="title">Equipe</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/equipe/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/equipe/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/equipe/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/equipe/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--PRODUTOS--}}
                @if(Access::permissao('produtos'))
                    <li class="{{ Request::is('admin/produtos/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-social-dropbox"></i>
                            <span class="title">Produtos</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/produtos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/produtos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/produtos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/produtos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--SERVICOS--}}
                @if(Access::permissao('servicos'))
                    <li class="{{ Request::is('admin/servicos/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-graduation"></i>
                            <span class="title">Serviços</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/servicos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/servicos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/servicos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/servicos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--IMOVEIS--}}
                @if(Access::permissao('imoveis'))
                    <li class="{{ Request::is('admin/imoveis/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-home"></i>
                            <span class="title">Imóveis</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/imoveis/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/imoveis/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/imoveis/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/imoveis/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--PATROCINADOR--}}
                @if(Access::permissao('patrocinadores'))
                    <li class="{{ Request::is('admin/patrocinadores/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-screen-tablet"></i>
                            <span class="title">Patrocinadores</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/patrocinadores/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/patrocinadores/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/patrocinadores/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/patrocinadores/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--DESTAQUES--}}
                @if(Access::permissao('destaques'))
                    <li class="{{ Request::is('admin/destaques/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-star"></i>
                            <span class="title">Destaques</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/destaques/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/destaques/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/destaques/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/destaques/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{--DICAS--}}
                @if(Access::permissao('dicas'))
                    <li class="{{ Request::is('admin/dicas/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-speech"></i>
                            <span class="title">Dicas</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/dicas/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/dicas/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/dicas/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/dicas/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--EVENTOS--}}
                @if(Access::permissao('eventos'))
                    <li class="{{ Request::is('admin/eventos/*') ? 'active' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-folder-alt"></i>
                            <span class="title">Eventos</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/eventos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/eventos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/eventos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/eventos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--DEPOIMENTOS--}}
                @if(Access::permissao('depoimentos'))
                    <li class="{{ Request::is('admin/depoimentos/*') ? 'active' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-notebook"></i>
                            <span class="title">Depoimentos</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/depoimentos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/depoimentos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/depoimentos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/depoimentos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--NEWSLETTER--}}
                @if(Access::permissao('newsletter'))
                    <li class="{{ Request::is('admin/newsletter/*') ? 'active' : ''  }}">
                        <a href="{{ url('admin/newsletter/listar') }}">
                            <i class="icon-envelope"></i>
                            <span class="title">Newsletter</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endif

                {{--GALERIA FOTOS--}}
                @if(Access::permissao('fotos'))
                    <li class="{{ Request::is('admin/fotos/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-camera"></i>
                            <span class="title">Galeria de Fotos</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/fotos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/fotos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/fotos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/fotos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--GALERIA VIDEOS--}}
                @if(Access::permissao('videos'))
                    <li class="{{ Request::is('admin/videos/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-camcorder"></i>
                            <span class="title">Galeria de Vídeos</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/videos/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/videos/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/videos/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/videos/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--AJUDA CADASTRO--}}
                @if(Access::permissao('ajuda'))
                    <li class="{{ Request::is('admin/ajuda/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-question"></i>
                            <span class="title">Ajuda Cadastro</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{ Request::is('admin/ajuda/listar') ? 'active' : ''  }}">
                                <a href="{{url('admin/ajuda/listar/')}}"> Listar </a>
                            </li>
                            <li class="{{ Request::is('admin/ajuda/novo') ? 'active' : ''  }}">
                                <a href="{{url('admin/ajuda/novo/')}}"> Novo </a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{--@if(!isset($ajuda))--}}
                    <!-- AJUDA -->
                    <li class="{{ Request::is('admin/help/*') ? 'active open' : ''  }}">
                        <a href="javascript:;">
                            <i class="icon-question"></i>
                            <span class="title">Ajuda</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">

                            @foreach($ajuda as $item)
                                <li>
                                    <a href="{{ url('admin/help/visualizar/'.$item->id_ajuda) }}"> {{ $item->titulo }} </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                {{--@endif--}}

                {{--CONFIGURACOES--}}
                <li class="{{ Request::is('admin/configuracoes/*') ? 'active open' : ''  }}">
                    <a href="javascript:;">
                        <i class="icon-wrench"></i>
                        <span class="title">Configurações</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">

                        {{--SITE--}}
                        @if(Access::permissao('site'))
                            <li class="{{ Request::is('admin/configuracoes/site') ? 'active' : ''  }}">
                                <a href="{{url('admin/configuracoes/site')}}"> Site </a>
                            </li>
                        @endif

                        {{--EMIAL--}}
                        @if(Access::permissao('email'))
                            <li class="{{ Request::is('admin/configuracoes/email') ? 'active' : ''  }}">
                                <a href="{{url('admin/configuracoes/email')}}"> E-mail </a>
                            </li>
                        @endif

                        {{--CONTATO--}}
                        @if(Access::permissao('contato'))
                            <li class="{{ Request::is('admin/configuracoes/contato') ? 'active' : ''  }}">
                                <a href="{{url('admin/configuracoes/contato/')}}"> Contato </a>
                            </li>
                        @endif

                        {{--ANALYTICS--}}
                        @if(Access::permissao('analytics'))
                            <li class="{{ Request::is('admin/configuracoes/analytics') ? 'active' : ''  }}">
                                <a href="{{url('admin/configuracoes/analytics')}}"> Analytics </a>
                            </li>
                        @endif

                         {{--USUÁRIOS --}}
                        @if(Access::permissao('usuarios'))
                            <li class="{{ Request::is('admin/configuracoes/usuarios/*') ? 'active' : ''  }}">
                                <a href="javascript:;">
                                    <span class="title">Usuarios</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="{{ Request::is('admin/configuracoes/usuarios/listar') ? 'active' : ''  }}">
                                        <a href="{{url('admin/configuracoes/usuarios/listar')}}"> Listar </a>
                                    </li>
                                    <li class="{{ Request::is('admin/configuracoes/usuarios/novo') ? 'active' : ''  }}">
                                        <a href="{{url('admin/configuracoes/usuarios/novo')}}"> Novo </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                         {{--PERFIL --}}
                        @if(Access::permissao('perfis'))
                            <li class="{{ Request::is('admin/configuracoes/perfis/*') ? 'active' : ''  }}">
                                <a href="javascript:;">
                                    <span class="title">Perfil de usuário</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="{{ Request::is('admin/configuracoes/perfis/listar') ? 'active' : ''  }}">
                                        <a href="{{url('admin/configuracoes/perfis/listar')}}"> Listar </a>
                                    </li>
                                    <li class="{{ Request::is('admin/configuracoes/perfis/novo') ? 'active' : ''  }}">
                                        <a href="{{url('admin/configuracoes/perfis/novo')}}"> Novo </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{--MODULOS --}}
                        @if(Access::permissao('funcoes'))
                            <li class="{{ Request::is('admin/configuracoes/modulos/*') ? 'active' : ''  }}">
                                <a href="{{url('admin/configuracoes/modulos/listar')}}">
                                    <span class="title">Módulos</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>



            </ul>

        </div>
    </div>


    <div class="content">
        @yield('content')
    </div>


    <div class="page-footer">
        <div class="page-footer-inner">
             2015 &copy; {{ $confsite->nome_site }}. <a href="" title="" target="_blank">safaricomunicacao.com</a>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>

        </div>
    </div>
</div>

    @include('admin.static.script')
</body>
</html>