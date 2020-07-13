<div class="table-responsive">
<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>	
			<th>Apellido</th>
			<th>DNI</th>
			<th>Contraseña</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($usuarios as $usuario){ ?>
			<tr id="<?php echo $usuario->id ?>">
				<td><input readonly class="form-control nombre" type="text" name="nombre" value="<?php echo $usuario->nombre ?>"></td>
				<td><input readonly class="form-control apellido" type="text" name="apellido" value="<?php echo $usuario->apellido ?>"></td>
				<td><input readonly class="form-control dni" type="text" name="dni" value="<?php echo $usuario->dni ?>"></td>
				<td><input readonly class="form-control password" type="password" name="contraseña" placeholder="Ingrese contraseña si desea cambiarla"></td>
				<td>
					<div class="btn-group-vertical">
						<a class="btn btn-sm btn-warning editar" href="javascript:void(0)"><i class="fas fa-user-edit"></i> Editar</a>
						<a class="btn btn-sm btn-danger borrar" href="javascript:void(0)"><i class="fas fa-user-minus"></i> Borrar</a>
						<a style="display: none" class="btn btn-sm btn-success guardar" href="javascript:void(0)"><i class="fas fa-user-check"></i> Guardar</a>
						<a style="display: none" class="btn btn-sm btn-info cancelar" href="javascript:void(0)"><i class="fas fa-user-minus"></i> Cancelar</a>
					</div>
				</td>
			</tr>
		<?php } ?>
		<tr></tr>
	</tbody>
</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var tr;
		var nombre,apellido,dni;
		$(".editar,.guardar,.borrar,cancelar").click(function(event) {
			tr = $(this).closest('tr');
		});
		$(".editar").click(function(event) {
			$('.editar,.borrar').hide();
			$('.guardar,.cancelar').show();
			tr.find('input').each(function(index, el) {
				$(el).prop('readonly',false);
			});
			nombre = $(tr).find('.nombre').val();
			apellido = $(tr).find('.apellido').val();
			dni = $(tr).find('.dni').val();
		});
		$(".guardar").click(function(event) {
			password = $(tr).find('.password').val();
			var postData = {
				user_id: tr.attr('id'),
				nombre: $(tr).find('.nombre').val(),
				apellido: $(tr).find('.apellido').val(),
				dni: $(tr).find('.dni').val()
			};
			//Si se modificó el password anexamos al json
			if (password) {
				postData.password = password;	
			}
			$('.editar,.borrar').show();
			$('.guardar,.cancelar').hide();
			tr.find('input').each(function(index, el) {
				$(el).prop('readonly',true);
			});
			$.ajax({
				url: '<?php echo base_url('auth/update_user') ?>',
				type: 'POST',
				data: postData
			})
			.done(function() {
			})
			.fail(function() {
				console.log("error");
			});
			
		});
		$(".cancelar").click(function(event) {
			$('.editar,.borrar').show();
			$('.guardar,.cancelar').hide();
			tr.find('input').each(function(index, el) {
				$(el).prop('readonly',true);
			});
			$(tr).find('.nombre').val(nombre);
			$(tr).find('.apellido').val(apellido);
			$(tr).find('.dni').val(dni);
			$(tr).find('.password').val('');
		});
		$(".borrar").click(function(event) {
			var user_id = tr.attr('id');

			$.ajax({
				url: '<?php echo base_url('auth/delete_logico') ?>',
				type: 'POST',
				data: {user_id: user_id},
			})
			.done(function() {
				$(tr).remove();
			})
			.fail(function() {
				console.log("error");
			});
		});
	});
</script>



