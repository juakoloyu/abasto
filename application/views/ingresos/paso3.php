<div class="tab-pane" id="paso3">
	<div class="row justify-content-center">
		<div class="col-lg-10 text-center">		
		
			<?php if ($tipo_impuesto=='derecho_piso'){ ## INGRESO DERECHO DE PISO?>

				<?php $this->load->view('ingresos/paso3_derecho_de_piso') ?>

			<?php }else{ ## PRODUCTOS ALIMENTICIOS?>

				<?php $contribuyentes = $liquidaciones[0]->contribuyentes ?>
				<?php if ($contribuyentes =='multiples'){ #Mostramos cada liquidacion?>
					<?php $this->load->view('ingresos/paso3_alimenticios_contribuyentes_multiples') ?>
				<?php } else { ?>
					<?php $this->load->view('ingresos/paso3_alimenticios_contribuyentes_multiples') ?>
				<?php } ?>
				<?php $this->load->view('ingresos/paso3_modal') ?>

			<?php } ?>
		</div>
	</div>
</div>

<div class="card-footer col-md-12">
	<div class="pull-right">
		<a style="display: none" id="finalizarIngreso" href="<?php echo base_url('ingresos') ?>" class="btn btn-next btn-fill btn-primary btn-wd">Finalizar Ingreso</a>
    </div>
	<div class="clearfix"></div>
</div>



<script>
	var resultados;
	$(document).ready(function() {
		var inputCantidad;
		$(".progress-bar").css('width', '83.33%');
		$(".item_paso1").addClass('active');
		$(".item_paso2").addClass('active');
		$(".item_paso3").addClass('active');
		$("#paso3").addClass('active');

		$("#cancelar").click(function(event) {
			$(".listasLiquidaciones").show();
			$("#contenido").hide();
			$(".foot,.detalle").hide();
		});

		$(".cargar").click(function(event) {
			var liquidacion_id = $(this).closest('tr').attr('id');
			$.ajax({
				url: '<?php echo base_url('ingresos/getDetalleMultiples') ?>',
				type: 'POST',
				data: {liquidacion_id: liquidacion_id},
			})
			.done(function(data) {
				$("#contenido").show();
				$("#contenido").html(data);
				$("#liquidacion_id").attr('value',liquidacion_id);
				$(".listasLiquidaciones").hide();
				$(".foot,.detalle,#tabla").show();
			})
			.fail(function() {
				console.log("error");
			});
			
		});
	});
</script>
<script src="<?php echo base_url('assets/javascript/paso3/cambio_input_cantidad.js') ?>"></script>
<script src="<?php echo base_url('assets/javascript/paso3/anadir_items_btn.js') ?>"></script>
<script src="<?php echo base_url('assets/javascript/paso3/modal_agregar_quitar_producto.js') ?>"></script>
<script src="<?php echo base_url('assets/javascript/paso3/sumarTabla.js') ?>"></script>
<script src="<?php echo base_url('assets/javascript/paso3/agregarSuma.js') ?>"></script>
