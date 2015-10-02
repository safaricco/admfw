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
                                <i class="fa fa-gift"></i> Configuração do analytics
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" action="{{ url($route) }}" method="post" >

                                @if ($put) @include('admin.static.field-put') @endif

                                {!! csrf_field() !!}

                                <div class="form-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Código do analytics</label>
                                                <input name="codigo" type="text" class="form-control" placeholder="EX: UA-ASD123DSDA" value="{{ $dados->codigo or old('codigo') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Salvar</button>
                                    <button type="reset" class="btn default">Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
         </div>
    </div>

@stop