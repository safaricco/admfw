@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Módulos </h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Módulos', 'retorno' => 'configuracoes/modulos/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Listando Módulos
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                            <thead>
                            <tr>
                                <th> Nome </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($modulos as $modulo)

                                    @if ($modulo->status == 1)

                                        <tr class="success">
                                            <td> {{ $modulo->nome }} </td>
                                            <td><a href="{{ url('/admin/configuracoes/modulos/status/0/' . $modulo->id_funcao) }}"><i class="fa fa-ban"></i> Desativar</a></td>
                                        </tr>

                                    @else

                                        <tr class="danger">
                                            <td> {{ $modulo->nome }} </td>
                                            <td><a href="{{ url('/admin/configuracoes/modulos/status/1/' . $modulo->id_funcao) }}"><i class="fa fa-check-circle-o"></i> Ativar</a></td>
                                        </tr>

                                    @endif

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