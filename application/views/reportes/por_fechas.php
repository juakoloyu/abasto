<h2>Ingreso por Fechas</h2>
<?php echo form_open(); ?>
<div class="row" id="noprint">
	<div class="form-group col-md-6">
		<label for="razon_social">Desde:</label><br/>
		<input type="date" class="form-control" name="desde"/>
	</div>
	<div class="form-group col-md-6">
		<label for="domicilio">Hasta:</label><br/>
		<input type="date" class="form-control" name="hasta" />
	</div>
</div>
<button class="btn btn-primary" id="boton" type="submit">Enviar</button>
<?php echo form_close();?>

<?php if(!empty($pagos)){ ?>
<table class="table datatable">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Empresa</th>
			<th>Recibo</th>
			<th>Monto</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($pagos as $p) { ?>
			<tr>
				<td><?php echo date('d/m/Y',strtotime($p->fecha_generacion))?></td>
				<td><?php echo $p->razon_social ?></td>
				<td><?php echo $p->numero_recibo ?></td>
				<td>$ <?php echo $p->total ?></td>
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th style="color: black;">Total</th>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td style="color: black;">$ <?php echo number_format((float)array_sum(array_column($pagos,'total')), 3, '.', '')?></td>
		</tr>
	</tfoot>
</table>
<button class="btn btn-danger" id="imprimir" onclick="javascript:window.print()"><i class="fas fa-print"></i> Imprimir</button>
<?php } ?>	
<style type="text/css">
	@media print 
	{
		#noprint,#empresa,#boton,#imprimir,#DataTables_Table_0_length,#DataTables_Table_0_filter,#DataTables_Table_0_paginate,#DataTables_Table_0_info
		{
		  display: none !important;
		}
	}
</style>