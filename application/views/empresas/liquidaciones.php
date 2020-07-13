<h2><?php echo $empresas->nombre ?></h2>
<hr>
<h3>Productos Alimenticios</h3>
<form id="p_alimentos">
<table class="table datatable">
	<thead>
	<tr>
		<th>Fecha</th>
		<th>Estado</th>
		<th>Contribuyente</th>
		<th>Monto</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($alimentos as $al) { ?>
	<tr>
		<td><?php echo $al->fecha ?></td>
		<td>
			<?php if($al->estado_pago == "debe"){ ?>
				<span class="badge badge-danger">Debe</span>
			<?php }elseif($al->estado_pago == "pago"){ ?>
				<span class="badge badge-success">Pagado</span>
			<?php } ?>
		</td>
		<td><?php echo $al->contribuyentes ?></td>
		<td>$ <?php echo $al->importe?></td>
		<?php if($al->no_liquidable == 1){ ?>
			<td style="width: 15%" align="center">
				<span class="badge badge-primary">No Liquidable</span>
			</td>
		<?php }else{ ?>
			<?php if($al->completa == 1){ ?>
				<td style="width: 15%" align="center">
					<?php if($al->estado_pago == "debe"){ ?>
						<input type="checkbox" class="alimentos" name="recibo[]" value="<?php echo $al->id_ingreso?>">
					<?php }elseif($al->estado_pago == "pago"){ ?>
						<span class="badge badge-success">Pagado</span>
					<?php } ?>
				</td>
			<?php }else{ ?>
			<td style="width: 15%">
				<a class="btn btn-danger btn-block" href="<?php echo base_url('ingresos/nuevoIngreso/'.$al->id_ingreso)?>">Completar Ingreso</a>
			</td>
		</tr>
		<?php }} ?>
	<?php } ?>
	</tbody>
</table>
<input type="hidden" name="id" value="<?php echo $this->uri->segment(3);?>">
<input type="hidden" name="responsable" value="<?php echo $this->uri->segment(3);?>">
<?php if(!empty($alimentos)){?>
	<a href="javascript:void(0)" onclick="pagar_alimentos()" id="btn-pagar" class="btn btn-primary">PAGAR</a>
<?php } ?>
</form>

<hr>
<h3>Derecho de Piso</h3>
<table class="table datatable">
	<thead>
	<tr>
		<th>Fecha</th>
		<th>Estado</th>
		<th>Contribuyente</th>
		<th>Monto</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($derecho_piso as $dp) { ?>
	<tr>
		<td><?php echo $dp->fecha ?></td>
		<td>
			<?php if($dp->estado_pago == "debe"){ ?>
				<span class="badge badge-danger">Debe</span>
			<?php }elseif($dp->estado_pago == "pago"){ ?>
				<span class="badge badge-success">Pagado</span>
			<?php } ?>
		</td>
		<td><?php echo $dp->contribuyentes ?></td>
		<td>$ <?php echo number_format((float)($dp->importe*0.08)+($dp->importe)+20, 3, '.', '')?></td>
		<?php if($dp->completa == 1){ ?>
				<td style="width: 15%">
					<?php if($dp->estado_pago == "debe"){ ?>
						<button  onclick="pagar(<?php echo $dp->id_ingreso;?>,<?php echo $this->uri->segment(3);?>)" class="btn btn-primary btn-block">PAGAR</button>
					<?php }elseif($dp->estado_pago == "pago"){ ?>
						<span class="badge badge-success">Pagado</span>
					<?php } ?>
				</td>
		<?php }else{ ?>
		<td style="width: 15%">
			<a class="btn btn-danger btn-block" href="<?php echo base_url('ingresos/nuevoIngreso/'.$dp->id_ingreso)?>">Completar Ingreso</a>
		</td>
	</tr>
	<?php }} ?>
	</tbody>
</table>

<script type="text/javascript">
	$("#btn-pagar").attr( "disabled", true );
 
	$('.alimentos').on( 'click', function() {
		var numberOfChecked = $('input:checkbox:checked').length;
	    if( $(this).is(':checked') ){
	     	console.log(numberOfChecked);
		    if(numberOfChecked > 0)
		    {
		    	$("#btn-pagar").attr( "disabled", false );
		    }
	    } else {
	     	console.log(numberOfChecked);
	     	if(numberOfChecked == 0)
		    {
		    	$("#btn-pagar").attr( "disabled", true );
		    }
	    }
	});

	function pagar_alimentos(){
		Swal.fire({
		        title: "Ingrese su contraseña",
		        input: "password",
		        showCancelButton: true,
		        confirmButtonText: "Enviar",
		        cancelButtonText: "Cancelar",
		    }).then(resultado => {
		        if (resultado.value) {
		            let nombre = resultado.value;
		            var formData = new FormData($("#p_alimentos")[0]);
		            formData.append('pass',nombre);
		            $.ajax({
			          	type : 'POST',
			          	url : '<?php echo base_url();?>empresas/generarReciboAlimentos',
			          	//dataType : 'post',
			          	data: formData,
		                processData: false,
		                contentType: false,
			          	success : function(data)
			          	{
			          		obj = JSON.parse(data);
			            	if (obj.result == "ok")
            				{
            					window.open('<?php echo base_url();?>comprobante/comprobanteAlimentos/'+obj.id, '_blank');
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
      }
	function pagar(id,responsable_id){
		//alert(id);
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
		            		id: id,
		            		responsable: responsable_id
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
     }
</script>
