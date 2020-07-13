	<h1>Crear</h1>
	<?= form_open('empresas/save','role="form"'); ?><?php if(validation_errors() != NULL && validation_errors() != '') { ?>
		<div class="alert alert-danger" role="alert">
			<?= validation_errors();?>
		</div><?php } ?>
		<div class="row">
		<input type="hidden" name="id" value="<?= isset($empresas)?$empresas->id:''?>"/>
		<div class="form-group col-md-6">
			<label for="razon_social">Razón social:</label><br/>
			<input type="text" class="form-control" name="razon_social" placeholder="Ingresar Razón Social" value="<?= isset($empresas)?$empresas->razon_social:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="domicilio">Domicilio:</label><br/>
			<input type="text" class="form-control" name="domicilio" placeholder="Ingresar Domicilio" value="<?= isset($empresas)?$empresas->domicilio:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="cuit">CUIT:</label><br/>
			<input type="number" class="form-control" name="cuit" placeholder="Ingresar CUIT" value="<?= isset($empresas)?$empresas->cuit:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="propietario">Propietario:</label><br/>
			<input type="text" class="form-control" name="propietario" placeholder="Ingresar Apellido y Nombre del Propietario" value="<?= isset($empresas)?$empresas->propietario:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="ciudad">Ciudad:</label><br/>
			<input type="text" class="form-control" name="ciudad" placeholder="Ingresar ciudad" value="<?= isset($empresas)?$empresas->ciudad:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="provincia">Provincia:</label><br/>
				<select type="text" class="form-control" name="provincia">
					<option selected value="" disabled>Seleccione una opción</option>
					<?php foreach($provincias as $p){ ?>
						<?php if(empty($empresas)){ ?>
							<option value="<?php echo $p->id ?>"<?php echo set_select('provincia',$p->id);?>><?php echo $p->nombre ?></option>
						<?php }else{ ?>
							<?php if($p->id == $empresas->provincia){?>
								<option selected value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
							<?php }else{ ?>
								<option value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
							<?php } ?>
					<?php }} ?>
				</select>
		</div>
		<div class="form-group col-md-6">
			<label for="email">Email:</label><br/>
			<input type="text" class="form-control" name="email" placeholder="Ingresar correo electrónico" value="<?= isset($empresas)?$empresas->email:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="telefono">Teléfono:</label><br/>
			<input type="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" name="telefono" placeholder="Ingresar telefono" value="<?= isset($empresas)?$empresas->telefono:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="pagina_web">Página Web:</label><br/>
			<input type="text" class="form-control" name="pagina_web" placeholder="Ingresar página web" value="<?= isset($empresas)?$empresas->pagina_web:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="gerente">Gerente:</label><br/>
			<input type="text" class="form-control" name="gerente" placeholder="Ingresar gerente" value="<?= isset($empresas)?$empresas->gerente:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="encargado">Encargado:</label><br/>
			<input type="text" class="form-control" name="encargado" placeholder="Ingresar encargado" value="<?= isset($empresas)?$empresas->encargado:''?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="encargado">Sector de Impuestos:</label><br/>
			<input type="text" class="form-control" name="sector_impuestos" placeholder="Ingresar Sector de Impuestos" value="<?= isset($empresas)?$empresas->sector_impuestos:''?>"/>
		</div>
		<input type="submit" value="Guardar" class="btn btn-primary"/>
		<?= anchor('empresas/index','Atrás','class="btn btn-link"'); ?>
		</div>
	</form>
	
