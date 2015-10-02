@extends('admin.static.site')

@section('title', 'Usuários')

    @section('content')

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">

                <div class="row">

                    <div class="col-md-12 ">

                        <center>
                            <img src="{{ asset('assets/admin/sem-permissao-r.png') }}" alt="sem-permissão">
                            <h1>Acesso negado !!</h1>
                            <p>{{ $tipo }} sem permissão</p>
                        </center>

                    </div>
                </div>
            </div>
        </div>

    @endsection