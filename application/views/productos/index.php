	<h2>Productos</h2>
	<table class="table productos">
		<thead>
		<tr>
			<th>Empresa</th>
			<th>Peso</th>
			<th>Descripción</th>
			<th>Codigo</th>
			<th>Acción</th>
		</tr>
		</thead>
		<tbody>
			<tr>
		        <td>Cargando...</td>
		    </tr>
		</tbody>
	</table>
	
	<?= anchor('/productos/create','Crear','class="btn btn-primary"'); ?>

<script>
	$(document).ready(function() {
		$('.productos').dataTable({
		    "serverSide": true,
		    "responsive": true,
		    "ajax": "<?= base_url('productos/DatatableAjax')?>"
		});
	});
</script>