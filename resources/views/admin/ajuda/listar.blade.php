@extends('admin.static.site')

@section('title', 'Ajuda')

@section('content')
        <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">


        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Ajuda </h1>
            </div>
            <!-- END PAGE TITLE -->

        </div>
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE BREADCRUMB -->
        @include('admin.static.breadcrumb', ['active' => 'Ajuda', 'retorno' => ''])
                <!-- END PAGE BREADCRUMB -->


        <div class="row">
            <div class="col-lg-12">

                <h3>Itens de ajuda</h3>

                <div class="tiles">

                    @foreach($ajuda as $item)

                        <a href="{{ url('admin/help/visualizar/'.$item->id_ajuda) }}">
                            <div class="tile bg-blue">
                                <div class="tile-body">
                                    <i class="{{ $item->icone }}"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        {{ $item->titulo }}
                                    </div>
                                </div>
                            </div>
                        </a>

                    @endforeach
                    
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
@endsection