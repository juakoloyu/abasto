<div class="col-md-12" id="tabla">
<?php if (!$liquidacion[0]->completa){ #Si la liquidacion no está completa/cargada?>
<?php echo form_open('ingresos/updateLiquidacion') ?>
	<input type='hidden' name='ingreso_id' value='<?= $this->uri->segment(3)?>'>
	<input type='hidden' id="liquidacion_id" name='liquidacion_id' value='<?= $liquidacion[0]->ingreso_liquidacion_id?>'>
	<input type="hidden" name="contribuyentes" value="unico">
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
			<?php foreach ($liquidacion as $liq){ ?>
			<tr>
				<td hidden><input type='hidden' name='detalle_id[]' value="<?= $liq->detalle_id?>"></td>
				<td><?= $liq->concepto?></td>
				<td><input name='cantidad[]' type='text' class='form-control cantidad'></td>
				<td><input readonly name='monto[]' value="<?= $liq->impuesto ?>" placeholder="Exento" type='text' class='form-control'></td>
				<td><input readonly="" name='importe[]' type='text' class='form-control importe'></td>
				<?php if ($liquidaciones && $liquidaciones[0]->tipo_impuesto==1){ #Si es tipo alimenticio?>
				<td><a href="javascript:void(0)" class="btn btn-success animation-on-hover btn-sm modalopen" data-toggle="modal" data-target="#myModal">Añadir items</a></td>
				<?php } ?>
			</tr>
			<?php } ?>
			<tr><td colspan='2'></td><td>Total</td><td><input readonly id='importe' type='text' class='form-control'></td></tr>
		</tbody>
	</table>
	<input type="submit" class="btn btn-sm" value="Guardar Liquidacion">
<?php echo form_close()?>
<?php } else {?>
	<table class="table">
		<thead>
			<tr>
			<th>#</th>
			<th>Empresa responsable</th>
			<th>Empresa destino</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($liquidaciones as $liquidacion){ ?>
			<tr>
				<td><?php echo $liquidacion->ingreso_liquidacion_id ?></td>
				<td><?php echo $liquidacion->responsable ?></td>
				<td><?php echo $liquidacion->destino ?></td>
				<td>
					<?php if ($liquidacion->completa==1){ ?>
						<i class="text-primary fas fa-check"></i>
					<?php } ?> 
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php if($liquidaciones[0]->tipo_impuesto == 2){ ?>
		<button id="pagar" class="btn btn-primary btn-block">PAGAR</button>
	<?php } ?>
<?php } ?>
</div>


<script type="text/javascript">
	$('#pagar').click(function(){
		Swal.fire({
		        title: "Ingrese su contraseña",
		        input: "password",
		        showCancelButton: true,
		        confirmButtonText: "Guardar",
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
		            	id: <?php echo $this->uri->segment(3)?>
			          },
			          success : function(data)
			          {
			          	obj = JSON.parse(data);
			            if (obj.result == "ok")
            			{
            				window.open('<?php echo base_url();?>comprobante/comprobanteDerechoPiso/'.$this->uri->segment(3), '_blank');
            			}
			          },
			        });
		        }
		    });
      });
</script>
