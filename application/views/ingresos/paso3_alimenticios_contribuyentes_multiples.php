<div class="col-md-12">
	<table class="table listasLiquidaciones">
		<thead>
			<tr>
			<th>#</th>
			<th>Empresa</th>
			<th>Acción</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($liquidaciones as $liquidacion){ ?>
			<tr id="<?= $liquidacion->ingreso_liquidacion_id?>">
					<td><?php echo $liquidacion->ingreso_liquidacion_id ?></td>
					<td><?php echo $liquidacion->destino ?></td>
				<?php if ($liquidacion->completa==0){ ?>
					<td><a class="cargar btn btn-sm btn-success" href="javascript:void(0)">Cargar</a></td>
				<?php }else{ ?>
					<td><i class="text-primary fas fa-check"></i></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	<div class="" id="tabla" style="display: none">
	<?php echo form_open('ingresos/updateLiquidacion') ?>
		<input type='hidden' name='ingreso_id' value='<?= $this->uri->segment(3)?>'>
		<input type='hidden' id="liquidacion_id" name='liquidacion_id' value=''>
		<input type="hidden" name="contribuyentes" value="multiples">
		<table class="table detalle">
			<thead>
				<tr>
					<th>Tributo</th>
					<th>Cantidad</th>
					<th>Impuesto</th>
					<th>Importe</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="contenido">
			</tbody>
		</table>
		
		<div class="foot">
			<button type="submit" class="btn btn-info animation-on-hover"><i class='far fa-save'></i> Guardar</button>
			<a id="cancelar" href="javascript:void(0)" class="btn btn-primary btn-simple btn-info">Cancelar</a>
		</div>
	<?php echo form_close()?>
	</div>
</div>