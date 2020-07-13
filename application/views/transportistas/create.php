	<h1><?=$titulo?></h1>
	<?= form_open('transportistas/save','role="form"'); ?><?php if(validation_errors() != NULL && validation_errors() != '') { ?>
		<div class="alert alert-danger"><?= validation_errors(); ?></div><?php } ?>
		<input type="hidden" name="id" value="<?= isset($transportistas)?$transportistas->id:''?>"/>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="nombre">Nombre y Apellido:</label><br/>
				<input type="text" class="form-control" name="nombre" placeholder="Ingresar Nombre y Apellido" value="<?= isset($transportistas)?$transportistas->nombre:''?>"/>	
			</div>
			<div class="form-group col-md-6">
				<label for="tipo_doc">Tipo_doc:</label><br/>
				<input type="text" class="form-control" name="tipo_doc" placeholder="Ingresar Tipo_doc" value="<?= isset($transportistas)?$transportistas->tipo_doc:''?>"/>
				
			</div>
			<div class="form-group col-md-6">
				<label for="documento">Documento:</label><br/>
				<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" id="dni" class="form-control" name="documento" placeholder="Ingresar Documento (sin puntos)" value="<?= isset($transportistas)?$transportistas->documento:''?>"/>
				
			</div>
			<div class="form-group col-md-6">
				<label for="cat_licencia">Cat_licencia:</label><br/>
				<input type="text" class="form-control" name="cat_licencia" placeholder="Ingresar Cat_licencia" value="<?= isset($transportistas)?$transportistas->cat_licencia:''?>"/>
				
			</div>
			<div class="form-group col-md-6">
				<label for="licencia">Licencia:</label><br/>
				<input type="text" class="form-control" name="licencia" placeholder="Ingresar Licencia" value="<?= isset($transportistas)?$transportistas->licencia:''?>"/>
				
			</div>
		</div>
		<input type="submit" value="Guardar" class="btn btn-success"/>
		<?= anchor('transportistas/index','Atrás','class="btn btn-link"'); ?>
	</form>
