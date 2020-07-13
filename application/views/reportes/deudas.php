	<h2>Deudas de Abasto</h2>
	<table class="table datatable">
		<thead>
		<tr>
			<th>Razon social</th>
			<th>CUIT</th>
			<th>Monto</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($deudas as $d) { ?>
		<tr>
			<td><?php echo $d->razon_social?></td>
			<td><?php echo $d->cuit?></td>
			<td><?php echo round($d->importe,2)?></td>
		</tr><?php } ?>
		</tbody>
	</table>
<button class="btn btn-danger" id="imprimir" onclick="javascript:window.print()"><i class="fas fa-print"></i> Imprimir</button>
<style type="text/css">
	@media print 
	{
		#noprint,#empresa,#boton,#imprimir,#DataTables_Table_0_length,#DataTables_Table_0_filter,#DataTables_Table_0_paginate,#DataTables_Table_0_info
		{
		  display: none !important;
		}
	}
</style>