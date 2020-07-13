<?php if ($this->session->flashdata('ok')){?> 
	<div class="alert alert-primary">
		<?= $this->session->flashdata('ok'); ?>
	</div>
<?php } ?>
<?php if($error){?>
	<div class="alert alert-danger">
		<?php echo $error?>
	</div>
<?php } ?>
	<?php echo form_open(); ?>
		<div class="row">
				<div class="col-md-4">
					<b>Nombre</b>
					<input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo set_value('nombre') ?>">
					<?php echo form_error('nombre') ?>
				</div>
				<div class="col-md-4">
					<b>Apellido</b>
					<input type="text" name="apellido" class="form-control" placeholder="Apellido" value="<?php echo set_value('apellido') ?>">
					<?php echo form_error('apellido') ?>
				</div>
				<div class="col-md-4">
					<b>DNI</b>
					<input type="text" name="dni" class="form-control" placeholder="DNI" value="<?php echo set_value('dni') ?>">
					<?php echo form_error('dni') ?>
				</div>
		</div>
		<div class="row mt-2">
				<div class="col-md-4">
					<b>Contraseña</b>
					<input type="password" name="password" class="form-control" placeholder="Contraseña" value="<?php echo set_value('password') ?>">
					<?php echo form_error('password') ?>
				</div>
				<div class="col-md-4">
                    <b>Repetir Contraseña</b>
					<input type="password" name="password_conf" class="form-control" placeholder="Repetir contraseña" value="<?php echo set_value('password_conf') ?>">
					<?php echo form_error('password_conf') ?>

				</div>
		</div>

		<input type="submit" value="Registrar Inspector" class="btn btn-success mt-2">

	<?php  echo form_close(); ?>