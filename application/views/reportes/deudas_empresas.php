<h2>Deudas por Empresa: <?php if(!empty($deudas)){echo $deudas[0]->responsable. ' - CUIT: '. $deudas[0]->cuit_responsable;}?></h2>
<?php echo form_open(); ?>
<div class="row" id="noprint">
	<div class="form-group col-md-6">
		<select required="" name="empresa" class="form-control select2" id="empresa">
			<option value="">Seleccione una empresa</option>
			<?php foreach ($empresas as $empresa){ ?>
				<option value="<?= $empresa->id?>"><?= $empresa->nombre?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-12">
		<button class="btn btn-primary" type="submit">Buscar</button>
	</div>
</div>
<?php echo form_close();?>

<?php if(!empty($deudas)){ ?>
<hr>
<table class="table">
	<thead>
	<tr>
		<th>Nro ingreso</th>
		<th>Fecha</th>
		<th>Consignado</th>
		<th>Nro comprobante de respaldo</th>
		<th>Producto</th>
		<th>Tasa</th>
		<th>Kg</th>
		<th>Importe</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($deudas as $d) { ?>
	<tr>
		<td><?php echo $d->numero_ingreso?></td>
		<td><?php echo date('d/m/Y',strtotime($d->fecha))?></td>
		<td><?php echo $d->consignado?></td>
		<td><?php echo $d->nro_factura?></td>
		<td><?php echo $d->producto?></td>
		<td><?php echo $d->monto_impuesto?></td>
		<td><?php echo $d->cantidad?></td>
		<td><?php echo $d->importe?></td>
	</tr>
	<?php } ?>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Abasto</b></td>
		<td>(Art.9)</td>
		<td><b>$<?php echo number_format((float)array_sum(array_column($deudas,'importe')), 3, '.', '')?></b></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Infraestructura</b></td>
		<td>(Art.115)</td>
		<td><b>$<?php echo array_sum(array_column($deudas,'importe'))*0.08?></b></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Gastos Administrativos</b></td>
		<td>(Art.114)</td>
		<td><b>$20</b></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Total</b></td>
		<td></td>
		<td><b>$<?php echo array_sum(array_column($deudas,'importe'))+(array_sum(array_column($deudas,'importe'))*0.08)+20?></b></td>
		<td></td>
	</tr>
	</tbody>
</table>
<button class="btn btn-danger" id="imprimir" onclick="javascript:window.print()"><i class="fas fa-print"></i> Imprimir</button>
<?php } ?>
<br>
<?php if($error) echo '<div class="alert alert-danger ml-2 mr-2">'. $error .'</div>'; ?>
<style type="text/css">
	@media print 
	{
		#noprint,#empresa,#boton,#imprimir
		{
		  display: none !important;
		}
	}
</style>	
<script>
	$(document).ready(function() {
		$(".select2").select2({    
		  language: {
		    noResults: function() {
		      return "No hay resultado";        
		    },
		    searching: function() {
		      return "Buscando..";
		    }
		  }
		});
	});
</script>
