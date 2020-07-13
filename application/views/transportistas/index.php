	<h2>Transportistas</h2>
	<table class="table datatable">
		<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Tipo_doc</th>
			<th>Documento</th>
			<th>Cat_licencia</th>
			<th>Licencia</th>
			<th></th>
			<!--
			<th></th>-->
		</tr>
		</thead>
		<tbody>
		<?php foreach ($transportistas as $object) { ?>
		<tr>
			<td><?=$object->id ?></td>
			<td><?= $object->nombre ?></td>
			<td><?= $object->tipo_doc ?></td>
			<td><?= $object->documento ?></td>
			<td><?= $object->cat_licencia ?></td>
			<td><?= $object->licencia ?></td>
			<td width="80"><?= anchor('/transportistas/edit/'.$object->id, 'Editar','class="btn btn-warning"'); ?></td>
			<!--
			<td width="80"><?= anchor('/transportistas/destroy/'.$object->id, 'Eliminar','class="btn btn-danger"'); ?></td>-->
		</tr><?php } ?>
		</tbody>
	</table>
	
	<?= anchor('/transportistas/create','Crear','class="btn btn-primary"'); ?>
