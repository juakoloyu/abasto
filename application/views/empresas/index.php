	<h2>Empresas</h2>
	<table class="table datatable">
		<thead>
		<tr>
			<th>Nombre</th>
			<th>CUIT</th>
			<th>Domicilio</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($empresas as $object) { ?>
		<tr>
			<td><?= $object->nombre ?></td>
			<td><?= $object->cuit ?></td>
			<td><?= $object->domicilio ?></td>
			<td width="80"><?= anchor('/empresas/edit/'.$object->id, 'Editar','class="btn btn-warning"'); ?></td>
			<td width="80"><a class="btn btn-primary" href="<?php echo base_url('empresas/verLiquidaciones/'.$object->id.'')?>">Liquidaciones</a></td>
			<td width="80"><a class="btn btn-info" href="<?php echo base_url('empresas/verRecibos/'.$object->id.'')?>">Recibos</a></td>
		</tr><?php } ?>
		</tbody>
	</table>
	
	<?= anchor('/empresas/create','Crear','class="btn btn-primary"'); ?>
