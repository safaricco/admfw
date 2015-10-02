@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Patrocinadores</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Patrocinadores', 'retorno' => 'patrocinadores/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Patrocinadores
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/patrocinadores/novo')}}">
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
                                <th> Endereço </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($patrocinadores as $patrocinador)    
                                    <tr>  
                                        <td> {{$patrocinador->titulo}} </td>
                                        <td> {{$patrocinador->texto}} </td>
                                        <td> {{$patrocinador->endereco}} </td>
                                        <td>
                                            <a href="{{ url('admin/patrocinadores/editar/' . $patrocinador->id) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/patrocinadores/destroy/' . $patrocinador->id) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($patrocinador->status == 1)
                                                <a href="{{ url('/admin/patrocinadores/status/0/' . $patrocinador->id_patrocinador) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/patrocinadores/status/1/' . $patrocinador->id_patrocinador) }}"><i class="fa fa-remove"></i> Ativar</a>
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