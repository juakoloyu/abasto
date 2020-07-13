	<h2>Vehículos</h2>
	<table class="table datatable">
		<thead>
		<tr>
			<th>#</th>
			<th>Dominio</th>
			<th>Propietario</th>
			<th>Marca</th>
			<th>Tipo</th>
			<th>Modelo</th>
			<th></th>
			<!--
			<th></th>
			-->
		</tr>
		</thead>
		<tbody>
		<?php foreach ($vehiculos as $object) { ?>
		<tr>
			<td><?=$object->id ?></td>
			<td><?= $object->dominio ?></td>
			<td><?= $object->titular ?></td>
			<td><?= $object->marca ?></td>
			<td><?= $object->tipo ?></td>
			<td><?= $object->modelo ?></td>
			<td width="80"><?= anchor('/vehiculos/edit/'.$object->id, 'Editar','class="btn btn-warning"'); ?></td>
			<!--
			<td width="80"><?= anchor('/vehiculos/destroy/'.$object->id, 'Eliminar','class="btn btn-danger"'); ?></td>
			-->
		</tr><?php } ?>
		</tbody>
	</table>
	
	<?= anchor('/vehiculos/create','Crear','class="btn btn-primary"'); ?>

