@extends('site.static.site')

@section('title', 'Contato')

@section('content')

    @include('site.static.breadcrumb', ['titulo' => 'Contato', 'mensagem' => 'Entre em contato conosco e descubra o novo', 'paginabc' => 'Contato'])

    <div id="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3551.6873951899966!2d-52.615967999999995!3d-27.103150999999986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94e4b69ff536f3d9%3A0x1e73a82d7b8e503e!2sProfissional+Terapeuta!5e0!3m2!1spt-BR!2sbr!4v1432668242859"></iframe>
    </div>

    <!-- content begin -->
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="span8">
                    <h4>Entre em contato conosco</h4>
                    <br />
                    <div class="contact_form_holder">
                        <form class="row" role="form" method="post" action="{{ url('contato/enviar') }}">
                            {!! csrf_field() !!}
                            <div class="span4">
                                <label for="nome">Nome</label>
                                <input type="text" class="full" name="nome" id="nome" placeholder="Insira seu nome" required="true" autofocus/>
                            </div>

                            <div class="span4">
                                <label for="email">E-mail</label>
                                <input type="email" class="full" name="email" id="email" required="true"/>
                            </div>

                            <div class="span8">
                                <label for="mensagem">Mensagem</label>
                                <textarea rows="4" name="mensagem" id="mensagem" class="full"></textarea>
                            </div>

                            <div class="span8">
                                <p id="btnsubmit">
                                    <button type="submit" id="send"class="btn btn-large">Enviar</button>
                                </p>
                            </div>
                        </form>
                    </div>

                </div>

                <div id="sidebar" class="span3">
                    <!-- widget category -->
                    <!-- widget tags -->
                    <!-- widget text -->
                    <div class="widget widget-text">
                        <h4>Nosso endereço</h4>
                        <address>
                            Rua Barão do Rio Branco - E, 449, Sala 12, Centro, Chapecó - SC
                            <span><strong>Telefone:</strong>+55 (49) 3329 3672</span>
                            <span><strong>E-mail:</strong><a href="mailto:contato@alcirmarques.com.br">Contate-nos</a></span>
                        </address>
                    </div>

                </div>
            </div>

            <div class="map">
            </div>

        </div>
    </div>

@endsection