@extends('admin.static.site')

@section('title', 'Dashboard')

    @section('content')
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">


                <!-- BEGIN PAGE HEAD -->
                <div class="page-head">
                    <!-- BEGIN PAGE TITLE -->
                    <div class="page-title">
                        <h1>Dashboard </h1>
                    </div>
                    <!-- END PAGE TITLE -->

                </div>
                <!-- END PAGE HEAD -->
                <!-- BEGIN PAGE BREADCRUMB -->
                @include('admin.static.breadcrumb', ['active' => 'Dashboard', 'retorno' => 'dashboard'])
                <!-- END PAGE BREADCRUMB -->
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat blue-madison">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    {{$sites or ''}}
                                </div>
                                <div class="desc">
                                    Sites gerados
                                </div>
                            </div>
                            <a class="more" href="javascript:;">
                                Saiba mais <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat red-intense">
                            <div class="visual">
                                <i class="fa fa-picture-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    {{$layouts or ''}}
                                </div>
                                <div class="desc">
                                    Layouts criados
                                </div>
                            </div>
                            <a class="more" href="javascript:;">
                                Saiba mais <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat green-haze">
                            <div class="visual">
                                <i class="fa fa-university"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    {{$empresas or ''}}
                                </div>
                                <div class="desc">
                                    Empresas Filiadas
                                </div>
                            </div>
                            <a class="more" href="javascript:;">
                                Saiba mais <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat purple-plum">
                            <div class="visual">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    {{$usuarios or ''}}
                                </div>
                                <div class="desc">
                                    {{utf8_encode('Usu�rios')}} cadastrados
                                </div>
                            </div>
                            <a class="more" href="javascript:;">
                                Saiba mais <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END DASHBOARD STATS -->

            </div>
        </div>
        <!-- END CONTENT -->
    @endsection