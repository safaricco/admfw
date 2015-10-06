@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Depoimentos</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Depoimentos', 'retorno' => 'depoimentos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Depoimentos
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/depoimentos/novo')}}">
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
                                <th> Nome </th>
                                <th> Texto </th>
                                <th> Código Vídeo </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($depoimentos as $depoimento)
                                    <tr>  
                                        <td> {{ $depoimento->nome }} </td>
                                        <td> {!! $depoimento->texto !!} </td>
                                        <td> {{ $depoimento->video }} </td>
                                        <td>
                                            <a href="{{ url('admin/depoimentos/editar/' . $depoimento->id_depoimento) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/depoimentos/destroy/' . $depoimento->id_depoimento) }}"><i class="fa fa-trash"></i>  Excluir </a>
                                            @if ($depoimento->status == 1)
                                                <a href="{{ url('/admin/depoimentos/status/0/' . $depoimento->id_depoimento) }}"><i class="fa fa-remove"></i> Desativar</a>
                                            @else
                                                <a href="{{ url('/admin/depoimentos/status/1/' . $depoimento->id_depoimento) }}"><i class="fa fa-remove"></i> Ativar</a>
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