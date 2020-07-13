	<h2>Impuestos</h2>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Concepto</th>
				<th>Sp</th>
				<th>Otro_municipio</th>
				<th>Otra_provincia</th>
				<th>Tipo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($impuestos as $object) { ?>
				<tr>
					<td><?=$object->id ?></td>
					<td><?= $object->concepto ?></td>
					<td><?= $object->sp ?></td>
					<td><?= $object->otro_municipio ?></td>
					<td><?= $object->otra_provincia ?></td>
					<td>
						<?php if($object->tipo==1) echo 'Producto Alimenticio' ?>
						<?php if($object->tipo==2) echo 'Derecho de Piso' ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<? anchor('/impuestos/create','Create','class="btn btn-primary"'); ?>

<script>
	$(document).ready(function() {
		$(".table").DataTable();
	});
</script>