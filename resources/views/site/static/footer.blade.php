<footer>
    <div class="container">
        <div class="row">
            <div class="span4">
                <h3>Um pouco sobre mim</h3>
                {!! $sobre->texto !!}
            </div>

            <div class="span4">
                <div class="widget widget_recent_post">
                    <h3>Facebook</h3>
                    <div class="fb-page" data-href="https://www.facebook.com/1536002303309831" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
                        <div class="fb-xfbml-parse-ignore">
                            <blockquote cite="https://www.facebook.com/1536002303309831">
                                <a href="https://www.facebook.com/1536002303309831">Terapêutica Nutricional</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span4">
                <h3>Contato</h3>
                <div class="widget widget-address">
                    <address>
                        <ul>
                            <li><span><strong><i class="icon-map-marker"></i>:</strong>Rua Barão do Rio Branco - E, 449, Centro, Chapecó/SC</span></li>
                            <li><span><strong><i class="icon-phone"></i>:</strong>+55 (49) 3329 3672 </span></li>
                            <li><span><strong><i class="icon-envelope"></i>:</strong><a href="mailto:contato@alcirmarques.com.br">Contate-nos</a></span></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="subfooter">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <a href="http://safaricomunicacao.com">Safari Comunicação</a> | &copy; Copyright 2015 - Alcir Marques
                </div>
                <div class="span6">
                    <nav>
                        <ul>
                            <li><a href="{{ url('admin/login') }}">Acesso Restrito</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</footer>

@include('site.static.script')

</body>
</html>