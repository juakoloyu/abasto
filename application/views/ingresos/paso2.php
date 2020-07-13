<?php echo form_open($urlPost) ?>
<div class="tab-pane" id="paso2">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<input type="hidden" value="<?php echo $ingreso_id = $this->uri->segment(3) ?>" name="ingreso_id">
			<div class="row">
				<?php if ($ingreso->tipo_impuesto==1){ ?>
					<?php $this->load->view('ingresos/paso2_productos_alimenticios'); ?>
				<?php } ?>
			    <?php if ($ingreso->tipo_impuesto==2){ ?>
		    		<?php $this->load->view('ingresos/paso2_derecho_de_piso'); ?>
		    	<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo form_close() ?>


<div class="card-footer">
	<div class="pull-right">
		<?php if ($ingreso->tipo_impuesto==1){ ?>
			<?php if (!empty($empresas_asignadas)){ ?>
				<?php if ($ingreso->no_liquidable==0) { ?>
					<a onclick="return confirm('Estás seguro? Esta acción es irreversible y no se podrá cargar una liquidación para este ingreso.')" href="<?php echo base_url('ingresos/setNoLiquidable/'.$ingreso_id) ?>" class="btn btn-next btn-fill btn-danger btn-wd">
					Sin Liquidación <i class="fas fa-exclamation-circle"></i>
					</a>
					<a href="<?php echo base_url('ingresos/liquidacion_alimenticios/'.$ingreso_id) ?>" class="btn btn-next btn-fill btn-warning btn-wd">
					Cargar Liquidación <i class="far fa-arrow-alt-circle-right"></i>
					</a>
				<?php } ?>
				<?php if($ingreso->completo==0){ ?>
					<a align="justify-content-center" id="imprimir" href="javascript:void(0);" class="btn btn-info">Imprimir <i class="fas fa-print"></i>
					</a>
				<?php } ?>	
			<?php } ?>
		<?php } ?>
		<?php if ($ingreso->tipo_impuesto==2 && !empty($responsable)){ ?>
			<a href="<?php echo base_url('ingresos/liquidacion_derecho_piso/'.$ingreso_id) ?>" class="btn btn-next btn-fill btn-info btn-wd">
				Ver Liquidación <i class="far fa-arrow-alt-circle-right"></i>
			</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	$(".progress-bar").css('width', '50%');
	$(".item_paso1").addClass('active');
	$(".item_paso3").removeClass('active');
	$(".item_paso2").addClass('active');
	$("#paso2").addClass('active');
	$(".borrarFactura").click(function(event) {
		var tr = $(this).closest('tr');
		var ingreso_liquidacion_id = tr.attr('id');
		ingreso_liquidacion_id = JSON.stringify({ingreso_liquidacion_id});
		
		$.ajax({
			url: '<?php echo base_url('ingresos/eliminarFactura/') ?>',
			type: 'POST',
			data: {ingreso_liquidacion_id: ingreso_liquidacion_id},
		})
		.done(function(data) {
			$(tr).remove();
			console.log((data));
			if ($('tbody tr').length==0) 
			{
				location.reload();
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

});

	function eliminar(id)
	{
		$("#div_"+id).remove();
		$("#btn_"+id).remove();
	}

	$('#imprimir').click(function(){
		if (confirm('¿Está seguro que desea imprimir el formulario de ingreso? Una vez realizado esto, no podrá modificar los datos del paso 2.')) {
        
			$.ajax({
	          	type : 'POST',
	          	url : '<?php echo base_url();?>comprobante/generarIngresoAlimentos',
	          	//dataType : 'post',
	          	data: {
	        		id: <?php echo $this->uri->segment(3)?>,
	          	},
	          	success : function(data)
	          	{
	          		obj = JSON.parse(data);
	            	if (obj.result == "ok")
					{
						window.open('<?php echo base_url();?>comprobante/autorizacionAlimentos/'+obj.id, '_blank');
						location.reload();
					}
	         	 },
	        });
	    }
	});
</script>
