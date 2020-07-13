<h2>Deudas por Fechas</h2>
<?php echo form_open(); ?>
<div class="row">
	<div class="form-group col-md-4" id="empresas">
		<label for="razon_social">Empresa:</label><br/>
		<select required="" name="empresa" id="empresa" class="form-control select2">
			<option value="">Seleccione una empresa</option>
			<?php foreach ($empresas as $empresa){ ?>
				<option value="<?= $empresa->id?>"><?= $empresa->nombre?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group col-md-4" id="desde">
		<label for="razon_social">Desde:</label><br/>
		<input type="date" class="form-control" name="desde"/>
	</div>
	<div class="form-group col-md-4" id="hasta">
		<label for="domicilio">Hasta:</label><br/>
		<input type="date" class="form-control" name="hasta" />
	</div>
</div>
<button class="btn btn-primary" id="boton" type="submit">Enviar</button>
<?php echo form_close();?>
<?php if(!empty($deudas)){ ?>
<hr>
<table class="table">
	<thead>
		<tr>
			<th>Período</th>
			<th>Producto</th>
			<th>Cant. U.M.</th>
			<th>Tasa</th>
			<th>Importe</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($deudas as $i => $d) { ?>
			<?php if($i < 1){ ?>
			<tr>
				<td rowspan="<?php echo count($deudas)?>"><?php echo date('d/m/Y',strtotime($this->input->post('desde')))?> - <?php echo date('d/m/Y',strtotime($this->input->post('hasta')))?></td>
				<td><?php echo $d->concepto?></td>
				<td><?php echo $d->cantidad?></td>
				<td><?php echo $d->monto_impuesto?></td>
				<td><?php echo $d->importe?></td>
			</tr>
			<?php }else{?>
			<tr>
				<td><?php echo $d->concepto?></td>
				<td><?php echo $d->cantidad?></td>
				<td><?php echo $d->monto_impuesto?></td>
				<td><?php echo $d->importe?></td>
			</tr>
		<?php } }?>
		<tr>
			<td rowspan="5"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Abasto</b></td>
			<td></td>
			<td>(Art.9)</td>
			<td><b>$<?php echo number_format((float)array_sum(array_column($deudas,'importe')), 3, '.', '')?></b></td>
			
		</tr>
		<tr>
			<td><b>Infraestructura</b></td>
			<td></td>
			<td>(Art.115)</td>
			<td><b>$<?php echo array_sum(array_column($deudas,'importe'))*0.08?></b></td>
			
		</tr>
		<tr>
			<td><b>Gastos Administrativos</b></td>
			<td></td>
			<td>(Art.114)</td>
			<td><b>$20</b></td>
			
		</tr>
		<tr>
			<td><b>Total</b></td>
			<td></td>
			<td></td>
			<td><b>$<?php echo array_sum(array_column($deudas,'importe'))+(array_sum(array_column($deudas,'importe'))*0.08)+20?></b></td>
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
		#noprint,#empresas,#boton,#imprimir,#desde,#hasta
		{
		  display: none !important;
		}
	}
</style>
