<!-- ############## SI ESTA CREADO EL INGRESO ############## -->
	<input type="hidden" name="ingreso_id" value="<?= $ingreso->ingreso_id?>">
	<?php if ($ingreso->contribuyentes=='unico') { ?>
	<input type="hidden" name="responsable_id" value="<?= $ingreso->responsable_id ?>">
	<?php } ?>
	<div class="row">
		<div class="form-group col-md-4">
			<input type="hidden" value="<?php echo $ingreso->tipo_empresa?>" id="tipo_empresa_cargada">
			<input type="hidden" value="<?php echo $ingreso->tipo_impuesto?>" id="tipo_tributo_cargado">
			<!-- MOSTRAR TIPO DE EMPRESA CARGADA: LOCAL, OTRA LOC, OTRA PROV -->
			<b>Tipo de empresa</b>
			<h3><?php
					if ($ingreso->tipo_empresa == 1){
						echo "Empresa Local";
					} elseif ($ingreso->tipo_empresa == 2){
						echo "Empresa de otra Localidad";
					} elseif ($ingreso->tipo_empresa == 3){
						echo "Empresa de otra Provincia";}
				?>
			</h3>
		</div>
		<div class="form-group col-md-4">
			<b>Tipo de tributo</b>
			<h3><?php if ($ingreso->tipo_impuesto == 1){
					echo "Productos alimenticios";
				}elseif ($ingreso->tipo_impuesto == 2){
					echo "Derecho de Piso";}?>
			</h3>
		</div>
		<div class="form-group col-md-4">
			<b>Contribuyentes</b>
			<h3><?php echo $ingreso->contribuyentes ?></h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<?php if ($ingreso->contribuyentes=='unico'){ ?>
			
			<?php } ?>
		</div>
		<div class="col-md-3">
			
			<?php if ($ingreso->contribuyentes=='unico'){ ?>
				<b>Responsable del Pago:</b><br>
				<?php echo $ingreso->nombre ?><br>
			<?php } ?>
			<b>Liquidaciones:</b><br>
				<ul>
				<?php foreach ($empresas_asignadas as $empresa){ ?>
					<li>
						<?php echo $empresa->nombre ?>
						<a onclick="return confirm('Estas seguro? Se eliminará la liquidacion con su Detalle')" rel="tooltip" class="btn btn-danger btn-link btn-sm btn-icon" data-original-title="Borrar liquidación" title="" href="<?php echo base_url('ingresos/eliminarLiquidacion/'.$ingreso->ingreso_id.'/'.$empresa->id) ?>"><i class="tim-icons icon-simple-remove"></i></a>
						
					</li>
				<?php } ?>
				</ul>
		</div>
	</div>
	
	<hr>
	<div class="row">
		<div class="col-sm-4">
			<b>Empresa de destino del Pago</b>
					<select required="" style="width: 100%" name="empresa_id" class="select2">
						<option value="" disabled="" selected="">Busque una empresa</option>
						<?php foreach ($empresas as $empresa){ ?>
							<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
						<?php } ?>
					</select>
		</div>
		
	</div>
	<hr>
	<input type="submit" value="Guardar y añadir otra" class="btn btn-primary btn-sm"/>