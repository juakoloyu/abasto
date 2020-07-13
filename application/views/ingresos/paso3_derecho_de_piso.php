<div class="col-md-12" id="tabla">
<?php echo form_open('') ?>
	<input type='hidden' name='ingreso_id' value='<?= $this->uri->segment(3)?>'>
	<input type='hidden' id="liquidacion_id" name='liquidacion_id' value='<?= $liquidaciones[0]->ingreso_liquidacion_id?>'>
	
	<table class="table">
		<thead>
			<tr>
				<th>Tributo</th>
				<th>Cantidad</th>
				<th>Impuesto</th>
				<th>Importe</th>
				</tr>
		</thead>
							
		<tbody>
			<?php foreach ($liquidaciones as $liq){ ?>

			<tr>
				<td hidden><input type='hidden' name='detalle_id[]' value="<?= $liq->detalle_id?>"></td>
				<td><?= $liq->concepto ?></td>
				<td><input name='cantidad[]' readonly="" value="<?= $liq->cantidad?>" type='text' class='form-control cantidad'></td>
				<td><input readonly name='monto[]' value="<?= $liq->monto_impuesto?>" placeholder="Impuesto" type='text' class='form-control'></td>
				<td><input readonly="" name='importe[]' value="<?= $liq->importe?>" type='text' class='form-control importe'></td>
			</tr>
			<?php } ?>
			<tr><td colspan='2'></td><td>Total</td><td><input readonly id='importe' type='text' class='form-control'></td></tr>
		</tbody>
	</table>

	
<?php echo form_close()?>
<?php if($liquidaciones[0]->estado_pago == 'pago'){?>
	<div class="alert alert-success" role="alert">
        <i class="tim-icons icon-coins"></i> Pagado
    </div>
<?php }else{ ?>
		<div class="card-footer">
		<?php  if($liquidaciones[0]->completo == 0){?>
			<a align="justify-content-center" id="imprimir" href="javascript:void(0);" class="btn btn-danger">Imprimir Ingreso <i class="fas fa-print"></i></a>
		<?php }else{ ?>
			<a id="pagar" href="javascript:void(0);" class="btn btn-primary btn-block">PAGAR</a>
		</div>
		<?php } ?>
<?php } ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var suma = 0;
		$(".importe").each(function(index, el) {
			suma += parseInt($(el).val());
		});
		$("#importe").val(suma);


		$('#pagar').click(function(){
		Swal.fire({
		        title: "Ingrese su contraseña",
		        input: "password",
		        showCancelButton: true,
		        confirmButtonText: "Enviar",
		        cancelButtonText: "Cancelar",
		    }).then(resultado => {
		        if (resultado.value) {
		            let nombre = resultado.value;
		            $.ajax({
			          	type : 'POST',
			          	url : '<?php echo base_url();?>empresas/pagar',
			          	//dataType : 'post',
			          	data: {
			            	pass: nombre,
		            		id: <?php echo $this->uri->segment(3)?>,
		            		responsable: <?php echo $liquidaciones[0]->responsable_id?>
			          	},
			          	success : function(data)
			          	{
			          		obj = JSON.parse(data);
			            	if (obj.result == "ok")
            				{
            					window.open('<?php echo base_url();?>comprobante/comprobanteDerechoPiso/'+obj.id, '_blank');
            					location.reload();
            				}
            				else if(obj.error == "error")
            				{
            					Swal.fire({
					                type: 'error',
					                title: 'Contraseña Incorrecta',
					                showConfirmButton: true
					            });
            				}
			         	 },
			        });
		        }
		    });
      	});		
	});

	$('#imprimir').click(function(){
		if (confirm('¿Está seguro que desea imprimir el formulario de ingreso? Una vez realizado esto, no podrá modificar los datos del paso 2.')) {
        
			$.ajax({
	          	type : 'POST',
	          	url : '<?php echo base_url();?>comprobante/generarIngresoDerechoP',
	          	//dataType : 'post',
	          	data: {
	        		id: <?php echo $this->uri->segment(3)?>,
	          	},
	          	success : function(data)
	          	{
	          		obj = JSON.parse(data);
	            	if (obj.result == "ok")
					{
						window.open('<?php echo base_url();?>comprobante/autorizacionDerechoPiso/'+obj.id, '_blank');
						location.reload();
					}
	         	 },
	        });
	    }
	});
</script>
