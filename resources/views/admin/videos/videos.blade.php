@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Vídeos</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Vídeos', 'retorno' => 'videos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Galerias
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/galerias/novo')}}">
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
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                            <thead>
                            <tr>
                                <th> Titulo </th>
                                <th> Texto </th>
                                <th> Data </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($videos as $video)
                                    <tr>  
                                        <td> {{ $video->titulo }} </td>
                                        <td> {!! $video->texto !!} </td>
                                        <td> {{ date('d/m/Y', strtotime($video->created_at)) }} </td>
                                        <td>
                                            <a href="{{ url('admin/videos/editar/' . $video->id_video) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/videos/destroy/' . $video->id_video) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($produto->status == 1)
                                                <a href="{{ url('/admin/videos/status/0/' . $video->id_video) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/videos/status/1/' . $video->id_video) }}"><i class="fa fa-remove"></i> Ativar</a>
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