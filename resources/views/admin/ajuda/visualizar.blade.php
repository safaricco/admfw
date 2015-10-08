@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Ajuda</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Ajuda', 'retorno' => 'ajuda/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>{{ $dados->titulo }}
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                    {{--<h2 class="margin-bottom-20"> {{ $dados->titulo }} </h2>--}}
                                    {{--<h3 class="form-section">Descrição</h3>--}}
                                    <div class="row">
                                        <div class="col-md-12">

                                            {!! $dados->texto !!}
                                        </div>

                                    </div>
                                    <!--/row-->

                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
        </div>
    </div>

@stop