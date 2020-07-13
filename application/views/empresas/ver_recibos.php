<h3>Recibos <?php if(empty($recibos)){}else{ echo "-" .$recibos[0]->empresa;}?></h3>
<?php if ( $this->session->flashdata('ControllerMessage') != '' ) 
    {?>
    <?php echo $this->session->flashdata('ControllerMessage'); ?>
  <?php } ?>
<table class="table datatable">
	<thead>
	<tr>
		<th>Nro Ingreso</th>
		<th>Tipo</th>
		<th>Fecha</th>
		<th>Razon Social</th>
		<th>Domicilio</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($recibos as $r) { ?>
	<tr>
		<td><?php echo $r->numero_recibo ?></td>
		<?php if($r->tipo_impuesto == 1){ ?>
			<td>Productos Alimenticios</td>
		<?php }elseif($r->tipo_impuesto == 2){ ?>
			<td>Derecho de Piso</td>
		<?php } ?>
		<td><?php echo date('d/m/Y',strtotime($r->fecha_generacion))?></td>
		<td><?php echo $r->razon_social ?></td>
		<td><?php echo $r->domicilio ?></td>
		<?php if($r->tipo_impuesto == 1){ ?>
			<td><a class="btn btn-primary" target="_blank" href="<?php echo base_url('comprobante/comprobanteAlimentos/'.$r->id)?>">Imprimir</a></td>
		<?php }elseif($r->tipo_impuesto == 2){ ?>
			<td><a class="btn btn-primary" target="_blank" href="<?php echo base_url('comprobante/comprobanteDerechoPiso/'.$r->id)?>">Imprimir</a></td>
	</tr>
	<?php }} ?>
	</tbody>
</table>