	<h1><?=$titulo?></h1>
	<?= form_open('productos/save','role="form"'); ?><?php if(validation_errors() != NULL && validation_errors() != '') { ?>
		<div class="alert alert-danger"><?= validation_errors(); ?></div><?php } ?>
		<input type="hidden" name="id" value="<?= isset($productos)?$productos->id:''?>"/>
		
		<div class="row">
		<div class="form-group col-4">
			<label for="codigo">Código:</label><br/>
			<input type="text" class="form-control" name="codigo" placeholder="Ingresar Codigo" value="<?= isset($productos)?$productos->codigo:''?>"/>
		</div>
		<div class="form-group col-4">
			<label for="peso">Peso (Kilogramos):</label><br/>
			<input type="number" step="0.001" class="form-control" name="peso" placeholder="Ingresar Peso" value="<?= isset($productos)?$productos->peso:''?>"/>
		</div>

		<div class="form-group col-4">
			<label for="descripcion">Descripción:</label><br/>
			<input type="text" class="form-control" name="descripcion" placeholder="Ingresar Descripcion" value="<?= isset($productos)?$productos->descripcion:''?>"/>
		</div>
		<div class="form-group col-4">
			<label for="descripcion">Impuesto:</label><br/>
			<select name="tipo_impuesto_id" class="select2 form-control" id="tipo_impuesto_id">
				<option disabled selected value="">
					Elija un tipo impuesto
				</option>
				<?php foreach ($impuestos as $impuesto){ ?>
					<?php if(empty($impuestos)){ ?>
						<option value="<?=$impuesto->id?>"<?php echo set_select('tipo_impuesto_id',$impuesto->id);?>><?=$impuesto->concepto?></option>
					<?php }else{ ?>
						<?php if($impuesto->id == $productos->tipo_impuesto_id){?>
							<option selected value="<?=$impuesto->id?>"><?php echo $impuesto->concepto ?></option>
						<?php }else{ ?>
							<option value="<?=$impuesto->id?>"><?php echo $impuesto->concepto ?></option>
						<?php } ?>
				<?php }} ?>
			</select>
		</div>
		<div class="form-group col-4">
			<label for="descripcion">Proveedor:</label>
			<br/>
			<select name="empresa" class="select2 form-control" id="empresa">
				<option disabled selected value="">
					<?php echo isset($productos)?$productos->empresa:''?>
					<?php echo isset($producto)?$producto->empresa:''?>
				</option>
				<?php foreach ($empresas as $empresa){ ?>
					<option value="<?= $empresa->nombre?>"<?php echo set_select('empresa',$empresa->nombre);?>><?= $empresa->nombre?></option>
				<?php } ?>
			</select>
		</div>
		</div>
		<input type="submit" value="Guardar" class="btn btn-primary"/>
		<?= anchor('productos/index','Atrás','class="btn btn-link"'); ?>
	</form>
<script>
	$(document).ready(function() {
		$("#tipo_impuesto_id").select2();
		$("#empresa").select2({
			tags: true
		});
	});
</script>
