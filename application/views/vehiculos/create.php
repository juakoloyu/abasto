	<h1>Crear</h1>
	<?= form_open('vehiculos/save','role="form"'); ?><?php if(validation_errors() != NULL && validation_errors() != '') { ?>
		<div class="alert alert-danger"><?= validation_errors(); ?></div><?php } ?>
		<input type="hidden" name="id" value="<?= isset($vehiculos)?$vehiculos->id:''?>"/>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="dominio">Dominio:</label><br/>
				<input type="text" class="form-control" name="dominio" placeholder="Ingresar Dominio" value="<?= isset($vehiculos)?$vehiculos->dominio:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="titular">Propietario:</label><br/>
				<input type="text" class="form-control" name="titular" placeholder="Ingresar Propietario" value="<?= isset($vehiculos)?$vehiculos->titular:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="tipo_documento">Tipo de Documento:</label><br/>
				<input type="text" class="form-control" name="tipo_documento" placeholder="Ingresar Tipo de Documento" value="<?= isset($vehiculos)?$vehiculos->tipo_documento:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="nro_documento">Nro de Documento:</label><br/>
				<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" name="nro_documento" placeholder="Ingresar Nro de Documento" value="<?= isset($vehiculos)?$vehiculos->nro_documento:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="domicilio">Domicilio:</label><br/>
				<input type="text" class="form-control" name="domicilio" placeholder="Ingresar Domicilio" value="<?= isset($vehiculos)?$vehiculos->domicilio:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="marca">Marca:</label><br/>
				<input type="text" class="form-control" name="marca" placeholder="Ingresar Marca" value="<?= isset($vehiculos)?$vehiculos->marca:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="tipo">Tipo:</label><br/>
				<input type="text" class="form-control" name="tipo" placeholder="Ej: Chasis c/Cabina" value="<?= isset($vehiculos)?$vehiculos->tipo:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="modelo">Modelo:</label><br/>
				<input type="text" class="form-control" name="modelo" placeholder="Ingresar Modelo" value="<?= isset($vehiculos)?$vehiculos->modelo:''?>"/>
			</div>
			<div class="form-group col-md-6">
				<label for="localidad">Localidad:</label><br/>
				<input type="text" class="form-control" name="localidad" placeholder="Ingresar Localidad" value="<?= isset($vehiculos)?$vehiculos->localidad:''?>"/>
			</div>

			<div class="form-group col-md-6">
				<label for="provincia">Provincia:</label><br/>
				<select type="text" class="form-control" name="provincia">
					<option selected value="" disabled>Seleccione una opción</option>
					<?php foreach($provincias as $p){ ?>
						<?php if(empty($vehiculos)){ ?>
							<option value="<?php echo $p->id ?>"<?php echo set_select('provincia',$p->id);?>><?php echo $p->nombre ?></option>
						<?php }else{ ?>
							<?php if($p->id == $vehiculos->provincia){?>
								<option selected value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
							<?php }else{ ?>
								<option value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
							<?php } ?>
					<?php }} ?>
				</select>
			</div>
			<div class="form-group col-md-12">
				<label for="frio">Con equipo de frío:</label><br/>
				<select type="text" class="form-control" name="frio">
					<option selected value="" disabled>Seleccione una opción</option>
					<?php if(empty($vehiculos)){?>
						<option value="si">Si</option>
						<option value="no">No</option>
					<?php }else{ ?>
						<?php if($vehiculos->frio == 'si'){?>
							<option selected value="si">Si</option>
							<option value="no">No</option>
						<?php }else{ ?>
							<option selected value="si">Si</option>
							<option selected value="no">No</option>
						<?php }} ?>
				</select>
			</div>
			<div class="form-group col-md-12">
				<label for="tipo_vehiculo">Tipo de vehiculo:</label><br/>
				<select type="text" class="form-control" name="tipo_vehiculo" id="tipo_vehiculo">
					<option selected value="" disabled>Seleccione una opción</option>
					<?php foreach($tipo_vehiculo as $tp){ ?>
						<?php if(empty($vehiculos)){?>
							<option value="<?php echo $tp->id ?>"<?php echo set_select('tipo_vehiculo',$tp->id);?>><?php echo $tp->tipo ?></option>
						<?php }else{ ?>
							<?php if($tp->id == $vehiculos->tipo_vehiculo){?>
								<option selected value="<?php echo $tp->id ?>"><?php echo $tp->tipo ?></option>
							<?php }else{ ?>
								<option value="<?php echo $tp->id ?>"><?php echo $tp->tipo ?></option>
							<?php } ?>
					<?php }} ?>
				</select>
			</div>
			<div class="col-md-12"  id="target" style="display: none;">
				<div class="row">
					<div class="form-group col-md-6" id="div_ejes_simples">
						<label for="eje_simple">Cantidad ejes simples:</label><br/>
						<input type="text" class="form-control" id="eje_simple" name="eje_simple" placeholder="Ingresar Cantidad ejes simples" value="<?= isset($vehiculos)?$vehiculos->eje_simple:''?>"/>
					</div>
					<div class="form-group col-md-6" id="div_ejes_dobles">
						<label for="eje_doble">Cantidad ejes dobles:</label><br/>
						<input type="text" class="form-control" id="eje_doble" name="eje_doble" placeholder="Ingresar Cantidad ejes dobles" value="<?= isset($vehiculos)?$vehiculos->eje_doble:''?>"/>
					</div>
				</div>
			</div>
		</div>
		<input type="submit" value="Guardar" class="btn btn-primary"/>
		<?= anchor('vehiculos/index','Atrás','class="btn btn-link"'); ?>
	</form>

<script type="text/javascript">
	$('#tipo_vehiculo').change(function(){
        if($('#tipo_vehiculo').val() == 1)
        {
          $('#target').show();
          $("#eje_doble").prop( "disabled", false );
          $("#eje_simple").prop( "disabled", false );
          $('#div_ejes_dobles').show();
          $('#div_ejes_simples').show();
          $('#eje_doble').val('');
          $('#eje_simple').val('');

        }
        else if($('#tipo_vehiculo').val() == 7)
        {
          $('#target').show();
          $("#eje_simple").prop( "disabled", false );
          $("#eje_doble").prop( "disabled", true );
          $('#div_ejes_dobles').hide();
          $('#eje_doble').val('');
          $('#eje_simple').val('');
        }
        else
        {
          $('#target').hide();
          $("#eje_simple").prop( "disabled", true );
          $("#eje_doble").prop( "disabled", true );
          $('#eje_doble').val('');
          $('#eje_simple').val('');
        }
     });

	if($('#tipo_vehiculo').val() == 1 || $('#tipo_vehiculo').val() == 7)
    {
      $('#target').show();
      $("#eje_doble").prop( "disabled", false );
      $("#eje_simple").prop( "disabled", false );
    }
    else
    {
      $('#target').hide();
      $("#eje_simple").prop( "disabled", true );
      $("#eje_doble").prop( "disabled", true );
    }
</script>

