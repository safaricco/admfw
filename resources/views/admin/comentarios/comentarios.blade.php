@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="modal-resposta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Respondendo comentário</h4>
                        </div>
                        <form action="{{ url('admin/comentarios/responder') }}" role="form" method="post">

                            {!! csrf_field() !!}
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Id comentario</label>
                                            <input type="text" id="id_comentario" name="id_comentario" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">IdNoticia</label>
                                            <input type="text" id="id_noticia" name="id_noticia" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="texto" id="summernote_1">{{ old('texto') }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn blue">Responder e aprovar</button>
                                <button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->


            <div class="page-head">
                <div class="page-title">
                    <h1>Comentários</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Comentários', 'retorno' => 'comentarios/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Listando Comentários
                            </div>
                        </div>
                        <div class="portlet-body">
                            {{--<div class="table-toolbar">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<a href="{{url('admin/noticias/novo')}}">--}}
                                                {{--<button id="sample_editable_1_new" class="btn green">--}}
                                                    {{--Novo <i class="fa fa-plus"></i>--}}
                                                {{--</button>--}}
                                            {{--</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<div class="btn-group pull-right">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                            <thead>
                            <tr>
                                <th class="col-md-1"> Status </th>
                                <th class="col-md-2"> Nome / E-mail </th>
                                <th class="col-md-3"> Texto </th>
                                <th class="col-md-1"> Data </th>
                                <th class="col-md-3"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($comentarios as $comentario)

                                    <tr>
                                        @foreach($statusComentario as $stat)
                                            @if($stat->id_status_comentario == $comentario->id_status_comentario)
                                                <td> {{ $stat->nome }}</td>
                                            @endif
                                        @endforeach

                                        <td> {{ $comentario->nome }} <br> {{ $comentario->email }}</td>

                                        <td> {!! str_limit($comentario->texto,380) !!} </td>

                                        <td> {{date('d/m/Y', strtotime($comentario->created_at))}} </td>

                                        <td>
                                            <a href="" data-toggle="modal"  title="Responder"
                                               data-idnoticia="{{ $comentario->id_noticia }}"
                                               data-idcomentario="{{ $comentario->id_comentario }}"
                                               class="responder btn btn-md btn-info"><i class="fa fa-reply"></i></a>

                                            @if ($comentario->id_status_comentario != 2)
                                                <a href="{{ url('admin/comentarios/status/2/' . $comentario->id_comentario) }}" title="Aprovar" class="btn btn-md btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                                            @endif

                                            @if ($comentario->id_status_comentario != 3)
                                                <a href="{{ url('admin/comentarios/status/3/' . $comentario->id_comentario) }}" title="Rejeitar" class="btn btn-md btn-warning"><i class="fa fa-thumbs-o-down"></i></a>
                                            @endif

                                            @if ($comentario->id_status_comentario != 5)
                                                <a href="{{ url('admin/comentarios/status/5/' . $comentario->id_comentario) }}" title="Span" class="btn btn-md btn-danger"><i class="fa fa-ban"></i></a>
                                            @endif

                                            @if ($comentario->id_status_comentario != 4)
                                                <a href="{{ url('admin/comentarios/status/4/' . $comentario->id_comentario) }}" title="Mover para lixeira" class="btn btn-md btn-default"><i class="fa fa-trash"></i></a>
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