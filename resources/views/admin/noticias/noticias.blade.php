@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Notícias</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Notícias', 'retorno' => 'noticias/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Listando Notícias
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/noticias/novo')}}">
                                                <button id="sample_editable_1_new" class="btn green">
                                                    Novo <i class="fa fa-plus"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group pull-right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th> Cód. Sub. </th>
                                <th> Titulo </th>
                                <th> Texto </th>
                                <th> Destaque </th>
                                <th> Data </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($noticias as $noticia)    
                                    <tr>
                                        <td> {{$noticia->id_subcategoria}} </td>
                                        <td> {{$noticia->titulo}} </td>
                                        <td> {!! str_limit($noticia->texto,380) !!} </td>
                                        <td> {{$noticia->destaque}} </td>
                                        <td> {{date('d/m/Y', strtotime($noticia->data))}} </td>
                                        <td>
                                            <a href="{{ url('admin/noticias/editar/' . $noticia->id_noticia) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/noticias/destroy/' . $noticia->id_noticia) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($noticia->status == 1)
                                                <a href="{{ url('/admin/noticias/status/0/' . $noticia->id_noticia) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/noticias/status/1/' . $noticia->id_noticia) }}"><i class="fa fa-remove"></i> Ativar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
         </div>
    </div>

@stop