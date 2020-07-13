
  <script src="<?php echo base_url('assets/black/assets/js/core/popper.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/perfect-scrollbar.jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/moment.min.js') ?>"></script>
  
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="<?php echo base_url('assets/black/assets/js/plugins/bootstrap-switch.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/sweetalert2.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/jquery.tablesorter.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/jquery.validate.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/jquery.bootstrap-wizard.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/bootstrap-datetimepicker.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/bootstrap-switch.js') ?>"></script>


  <script src="<?php echo base_url('assets/black/assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/bootstrap-tagsinput.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/jasny-bootstrap.min.js') ?>"></script>
  
  <script src="<?php echo base_url('assets/black/assets/js/plugins/jquery-jvectormap.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/nouislider.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/plugins/bootstrap-notify.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/js/black-dashboard.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/demo/demo.js') ?>"></script>
  <script src="<?php echo base_url('assets/black/assets/demo/jquery.sharrre.js') ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.4-beta.12/jquery.dataTables.yadcf.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script>
    $(document).ready(function() {

        if ($(".datatable").length>0) {
          $(".datatable").each(function(index, el) {
            $(el).DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
          });
        }

      $('.alternar').click(function(event) {
        setTimeout(function() {
            guardarBody();
          }, 2000);
      });
      function guardarBody(){
        var body_class = $('body').attr('class');
        console.log(body_class);
        	$.ajax({
        		url: '<?php echo base_url('auth/guardarBody') ?>',
        		type: 'POST',
        		data: {body: body_class},
        	})
          .done(function(data) {
            console.log(data);
          })
          .fail(function() {
            console.log("error");
          })
          ;        	
        }

    });
  </script>
