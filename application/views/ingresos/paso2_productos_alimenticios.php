<input type="hidden" name="tipo_empresa" value="<?=$ingreso->tipo_empresa?>" >
<div class="col-sm-5">
	<div class="mb-2">
		<b>Empresa de Destino</b>
		<div class="mt-1">
			<select required="" style="width: 100%" name="empresa_id" class="select2 form-control">
				<option value="" disabled="" selected="">Busque una empresa</option>
				<?php foreach ($empresas as $empresa){ ?>
				<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="mb-2">
		<b>N° DE COMP. DE RESPALDO</b>
		<div class="mt-1">
			<input type="text" name="factura" placeholder="N° factura" class="form-control">
		</div>
	</div>
	
	<div class="mb-2 mt-2" id="div_empresa">
	    <?php if ($responsable){ ?>
	        <?php if ($ingreso->contribuyentes=='unico'){?>
				<b>Empresa única responsable:</b>
				<?php echo $responsable->nombre ?><br>
				<input type="hidden" class="form-control" name="responsable_id" readonly="" value="<?php echo $responsable->id ?><br>">
	        <?php } else { #Multiples?>
				<b>Empresa responsable</b><br>
		        <select required="" style="width: 100%" name="responsable_id" class="select2 form-control" id="select_empresa_responsable">
					<option value="" disabled="" selected="">Busque una empresa</option>
					<?php foreach ($empresas as $empresa){ ?>
					<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
					<?php } ?>
				</select>
			<?php } ?>
		<?php } else { #No está cargado el responsable ?>
			<b>Empresa responsable</b><br>
			<select required="" style="width: 100%" name="responsable_id" class="select2 form-control" id="select_empresa_responsable">
				<option value="" disabled="" selected="">Busque una empresa</option>
				<?php foreach ($empresas as $empresa){ ?>
					<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
				<?php } ?>
			</select>
		<?php } ?>
    </div>
    <?php if($ingreso->completo == 0){?> 
		<input type="submit" class="btn btn-sm" value="Agregar"/>
	<?php } ?> 
</div>
<div class="col-md-7"> 
	<?php if (!empty($empresas_asignadas)){ ?>
		<b>Empresas de destino</b><br>
		<table class="table">
		<thead>
			<tr>
				<th>Empresa</th>
				<th>N° de comp. de respaldo</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach ($empresas_asignadas as $empresa){ ?>
			<tr id="<?= $empresa->ingreso_liquidacion_id?>">
				<td><?php echo $empresa->nombre ?></td>
				<td><?php echo $empresa->nro_factura ?></td>
				<td>
					<a rel="tooltip" class="btn btn-danger btn-link btn-sm borrarFactura" data-original-title="Borrar Factura" title="" href="javascript:void(0)">
						<i class="tim-icons icon-simple-remove"></i>
					</a>
				</td>
			</tr>
		 	<?php } ?>
		 	</table>
	<?php } ?>
</div>  