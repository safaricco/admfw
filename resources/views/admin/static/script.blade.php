<script src="{{asset('assets/admin/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->


<script type="text/javascript" src="{{asset('assets/admin/global/plugins/select2/select2.min.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>--}}
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/jquery-mixitup/jquery.mixitup.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/bootstrap-markdown/lib/markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/bootstrap-summernote/summernote.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>


<script src="{{asset('assets/admin/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/admin/pages/scripts/form-samples.js')}}"></script>
<script src="{{asset('assets/admin/admin/pages/scripts/portfolio.js')}}"></script>
<script src="{{asset('assets/admin/admin/pages/scripts/components-editors.js')}}"></script>
<script src="{{asset('assets/admin/admin/pages/scripts/profile.js')}}"></script>
<script src="{{asset('assets/admin/admin/pages/scripts/table-advanced.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    $(document).ready(function() {

        $('.responder').on('click', function () {
            var id_comentario   = $(this).data('idcomentario');
            var id_noticia      = $(this).data('idnoticia');

            $(".modal-body #id_comentario") .val(id_comentario);
            $(".modal-body #id_noticia")    .val(id_noticia);
            $('#modal-resposta')           .modal('show');

        });

        $('.deletefoto').on('click', function () {

            var Id  = $(this).val();
            var url = $(this).data('url');

            console.log('id : ' + Id);
            console.log('url: ' + url);

            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ URL::to('/') }}"+url,
                data: {"id": Id},

                success: function(data){
                    $('.showok').show();
                    $('#image'+Id).fadeOut();
                },
                error: function(erro){
                    $('.textomsg').html('Erro ao apagar imagem!');
                    $('.msgerro').show();
                }
            });
        });
    });
</script>

<script>
    jQuery(document).ready(function() {
        setTimeout(function() {

            $('.alert').fadeOut();

        }, 3000);

        // initiate layout and plugins
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features

        @if(Request::is('*/listar'))
            TableAdvanced.init();
        @endif
        ComponentsEditors.init();
        FormSamples.init();
        Profile.init();
        Portfolio.init();
    });
</script>