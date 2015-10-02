@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i> Listando Sobre
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('admin/sobre/novo')}}">
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
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($sobre as $sob)    
                                    <tr>  
                                        <td> {{$sob->titulo}} </td>
                                        <td> {{$sob->texto}} </td>
                                        <td>
                                            <a href="{{ url('admin/sobre/editar/' . $sob->id) }}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="{{ url('admin/sobre/destroy/' . $sob->id) }}"><i class="fa fa-trash"></i>  Excluir </a>
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