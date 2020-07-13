	<h1><?php echo $titulo ?></h1>
	<?= form_open('impuestos/save','role="form"'); ?><?php if(validation_errors() != NULL && validation_errors() != '') { ?>
		<div class="alert alert-danger"><?= validation_errors(); ?></div><?php } ?>
		<input type="hidden" name="id" value="<?= isset($impuestos)?$impuestos->id:''?>"/>
		
		<div class="form-group">
			<label for="concepto">Concepto:</label><br/>
			<input readonly="" type="text" class="form-control" name="concepto" placeholder="Ingresar Concepto" value="<?= isset($impuestos)?$impuestos->concepto:''?>"/>
			
		</div>
		<div class="form-group">
			<label for="sp">Sp:</label><br/>
			<input type="text" class="form-control" name="sp" placeholder="Ingresar impuesto de S.P" value="<?= isset($impuestos)?$impuestos->sp:''?>"/>
			
		</div>
		<div class="form-group">
			<label for="otro_municipio">Otro_municipio:</label><br/>
			<input type="text" class="form-control" name="otro_municipio" placeholder="Ingresar impuesto p/ otras localidades" value="<?= isset($impuestos)?$impuestos->otro_municipio:''?>"/>
			
		</div>
		<div class="form-group">
			<label for="otra_provincia">Otra_provincia:</label><br/>
			<input type="text" class="form-control" name="otra_provincia" placeholder="Ingresar impuesto para otras provincias" value="<?= isset($impuestos)?$impuestos->otra_provincia:''?>"/>
			
		</div>
		
		<input type="hidden" class="form-control" name="tipo" placeholder="Ingresar Tipo" value="<?= isset($impuestos)?$impuestos->tipo:''?>"/>
		
		<input type="submit" value="Guardar" class="btn btn-primary"/>
		<?= anchor('impuestos/index','Atrás','class="btn btn-link"'); ?>
	</form>

