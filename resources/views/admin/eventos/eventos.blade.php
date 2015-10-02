@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Eventos</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Eventos', 'retorno' => 'eventos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Eventos
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/eventos/novo')}}">
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
                                @foreach($eventos as $evento)    
                                    <tr>  
                                        <td> {{$evento->titulo}} </td>
                                        <td> {{str_limit($evento->texto, 200)}} </td>
                                        <td> {{date('d/m/Y', strtotime($evento->data))}} </td>
                                        <td>
                                            <a href="{{ url('admin/eventos/editar/' . $evento->id_evento) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/eventos/destroy/' . $evento->id_evento) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($evento->status == 1)
                                                <a href="{{ url('/admin/eventos/status/0/' . $evento->id_evento) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/eventos/status/1/' . $evento->id_evento) }}"><i class="fa fa-remove"></i> Ativar</a>
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