@extends('admin.static.site')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>Newsletter</h1>
                </div>
            </div>
            @include('admin.static.breadcrumb', ['active' => 'Newsletter', 'retorno' => 'newsletter/listar'])
            <div class="row">
                <div class="col-md-12">

                    @include('admin.static.mensagem')

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Listando Newsletter
                            </div>
                        </div>
                        <div class="portlet-body">

                            <table class="table table-striped table-hover table-bordered" id="sample_1">
                            <thead>
                            <tr>
                                <th> Nome </th>
                                <th> E-mail </th>
                                <th> Data </th>
                                <th class="col-md-2"> Ações </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($newsletters as $news)
                                    <tr>
                                        <td> {{$news->nome}} </td>
                                        <td> {{$news->email}} </td>
                                        <td> {{date('d/m/Y', strtotime($news->created_at))}} </td>
                                        <td>
                                            <a href="{{ url('admin/newsletter/destroy/' . $news->id_newsletter) }}"class="btn btn-icon-only red" title="Excluir"><i class="fa fa-trash"></i></a>
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