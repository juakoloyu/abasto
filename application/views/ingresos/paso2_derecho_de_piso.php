<div class="col-md-6">
	<div class="mb-2" id="div_empresa">
		<?php if ($responsable){ ?>
			<b>Contribuyente responsable:</b>
			<?php echo $responsable->nombre ?><br>
			<input type="hidden" class="form-control" name="responsable_id" readonly="" value="<?php echo $responsable->id ?><br>">
			<?php if($ingreso->completo == 0){?>
				<a class="btn btn-sm btn-warning" href="<?= base_url('ingresos/quitarResponsable/'.$this->uri->segment(3))?>">Cambiar</a>
			<?php }else{} ?>
		<?php } else { #No está cargado el responsable ?>
			<b>Empresa responsable</b><br>
			<select required="" style="width: 100%" name="responsable_id" class="select2 form-control" id="select_empresa_responsable">
				<option value="" disabled="" selected="">Busque una empresa</option>
				<?php foreach ($empresas as $empresa){ ?>
				<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
			<?php } ?>
			</select>
			<input type="hidden" value="2" name="tipo_impuesto">
		<?php } ?>
	</div> 	
</div>
<div class="col-md-12">
	<b>Datos del Vehiculo</b>
	<table class="table">
		<thead>
			<tr>
				<th>Titular</th>
				<th>Tipo</th>
				<th>Dominio</th>
				<th width="8%">Ejes simples</th>
				<th id="th_eje_doble" width="8%">Ejes dobles</th>
				<?php if (!$responsable){ ?>
				<th width="8%"></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input readonly="" type="text" class="form-control" id="titular" name="titular" value="<?= $ingreso->titular?>"></td>
				<td>
					<?php echo form_dropdown('tipo', $tipos_vehiculos, isset($ingreso)?$ingreso->tipo_vehiculo :'', 'class="form-control" disabled id="tipo"'); ?>
				</td>
				<td><input readonly="" type="text" class="form-control" id="dominio" name="dominio" value="<?= $ingreso->dominio?>"></td>
				<td><input onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly="" type="number" min="0" class="form-control" id="ejes_simples" name="ejes_simples" value="<?= $ingreso->eje_simple?>"></td>
				<td id="td_eje_doble"><input onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly="" type="number" class="form-control" id="ejes_dobles" name="ejes_dobles" value="<?= $ingreso->eje_doble?>"></td>
				<?php if (!$responsable){ ?>
				<td class="text-right">
					<a href="javascript:void(0)" class="btn btn-sm btn-warning editar">Editar</a>
					<a rel="tooltip" class="actualizar btn btn-info btn-link btn-sm btn-icon btn-simple" data-original-title="Actualizar" title="" href="javascript:void(0)" style="display: none"><i class="far fa-save"></i></i></a>
					<a rel="tooltip" class="cancelar btn btn-danger btn-link btn-sm btn-icon btn-simple" data-original-title="Cancelar" title="" href="javascript:void(0)" style="display: none">
						<i class="tim-icons icon-simple-remove"></i>
					</a>
				</td>	
				<?php } ?>			
			</tr>
		</tbody>
	</table>
</div>
<?php if (!$responsable){ ?>
<input type="submit" class="btn btn-sm mt-2 confirmar" value="Confirmar"/>
<?php } ?>
<script>
	var vehiculo_id = '<?= $ingreso->vehiculo_id?>';
	$(document).ready(function() {
		var tipo_vehic = '<?= $ingreso->tipo_vehiculo?>';
		if (tipo_vehic!=1) 
		{
			//Si no es camion ocultamo los ejes dobles
			$("#th_eje_doble,#td_eje_doble").hide();
		}
	});
</script>
<script src="<?= base_url('assets/javascript/editarVehiculoAjax.js')?>"></script>