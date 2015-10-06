@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Programas</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Programas', 'retorno' => 'programas/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Programas
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/programas/novo')}}">
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
                                <th> Titulo </th>
                                <th> Texto </th>
                                <th> Código Vídeo </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($programas as $programa)    
                                    <tr>  
                                        <td> {{$programa->titulo}} </td>
                                        <td> {{$programa->texto}} </td>
                                        <td> {{$programa->codigo}} </td>
                                        <td>
                                            <a href="{{ url('admin/programas/editar/' . $programa->id_programa) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/programas/destroy/' . $programa->id_programa) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($programa->status == 1)
                                                <a href="{{ url('/admin/programas/status/0/' . $programa->id_programa) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/programas/status/1/' . $programa->id_programa) }}"><i class="fa fa-remove"></i> Ativar</a>
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