<?php echo form_open($urlPost) ?>
<div class="tab-pane show active" id="paso1">
<div class="row justify-content-center">
	<div class="col-sm-5">
	    		
	    <div class="mt-1 mb-2">
		    <b>Tipo de tributo</b>
			<select required="" type="text" class="selectpicker form-control" name="tipo_impuesto" id="tipo_tributo">
				<option disabled="" value="" selected="">Seleccione una opción</option>
				<option value="1">Productos alimenticios</option>
				<option value="2">Derecho de Piso</option>
			</select>
		</div>
		
		<!-- MOSTRAR TIPO DE EMPRESA CARGADA: LOCAL, OTRA LOC, OTRA PROV -->
		<div class="mt-1 mb-2" style="display: none" id="div_tipo_empresa">
			<b>Tipo de empresa</b>
			<select required="" type="text" class="selectpicker form-control" name="tipo_empresa" id="tipo_empresa">
				<option value="" disabled="" selected="">Seleccione una opción</option>
				<option value="1">Empresa Local</option>
				<option value="2">Otra localidad de la Pcia.</option>
				<option value="3">Otra Provincia</option>
			</select><br>
		</div>

		<div class="mt-1 mb-2">
			<b>Vehiculo</b><br>
			<select name="vehiculo" required="" class="selectAjaxVehiculos" style="width: 100%">
				<option disabled="" value="" selected="">Ingrese el dominio o titular del vehiculo</option>
			</select>
		</div>
		
		<div class="mt-1 mb-2">
			<b>Transportista</b><br>
			<select required="" name="transportista_id" class="select2 form-control" style="width: 100%">
				<option disabled="" value="" selected="">Nombre, Apellido o DNI del transportista</option>
				<?php foreach ($transportistas as $transportista){ ?>
				<option value="<?= $transportista->id?>"><?= $transportista->nombre.' - '.$transportista->documento?></option>
				<?php } ?>
			</select>
		</div>

		<div class="mt-1 mb-2" id="dias_permanencia" style="display: none">
			<b>Días de permanencia en la localidad</b>
			<input type="number" placeholder="Días de permanencia" name="dias_permanencia" class="form-control">
		</div>
		<div class="mt-1 mb-2" id="senasa" style="display: none">
			<b>N° Senasa</b>
			<input type="number" placeholder="Senasa N°" name="senasa" class="form-control">
		</div>
		<div class="mt-1 mb-2" id="proc_estanc" style="display: none">
			<b>Proc. Estanc.</b>
			<input type="number" placeholder="Proc. Estanc" name="proc_estanc" class="form-control">
		</div>
    </div>

    <div class="col-sm-5">
    	<div class="mt-1 mb-2" id="mat_num" style="display: none">
			<b>Mat. Nº</b>
			<input type="text" placeholder="Mat. Nº" name="mat_num" class="form-control">
		</div>
		<div class="mt-1 mb-2" id="prec_num" style="display: none">
			<b>Prec. Nº</b>
			<input type="text" placeholder="Prec. Nº" name="prec_num" class="form-control">
		</div>
    	<div class="mt-1 mb-2" id="empresa_prov" style="display: none">
        	<b>Empresa Proveedora</b>
			<select required="" style="width: 100%" name="empresa_proveedora" class="select2 form-control">
				<option value="" disabled="" selected="">Busque una empresa</option>
					<?php foreach ($empresas as $empresa){ ?>
						<option value="<?php echo $empresa->id ?>"><?= $empresa->nombre?></option>
					<?php } ?>
			</select>
        </div>
    	<div class="mt-1 mb-2" id="div_responsable" style="display: none">
        	<b>Responsable del Pago</b>
			<select class="selectpicker form-control" name="contribuyentes" id="select_responsable">
				<option value="" selected="" disabled="">Elija un responsable de pago</option>
				<option value="unico">Único</option>
				<option value="multiples">Múltiples (cada empresa local se hace cargo)</option>
			</select>
        </div>
        <div class="mt-1 mb-2" id="div_consignado" style="display: none;">
        	<b>Destino o consignado</b>
			<textarea class="form-control" id="destino_consignado" name="destino_consignado"></textarea>
        </div>
        <div class="mt-1 mb-2" id="objetos_transportados" style="display: none">
        	<b>Objetos transportados</b>
			<textarea class="form-control" name="objetos_transportados"></textarea>
        </div>   
    </div>
</div>
</div>

<div class="card-footer">
	<div class="pull-right">
    	<input type="submit" class="btn btn-next btn-fill btn-info btn-wd" value="Siguiente">
    </div>
<div class="clearfix"></div>
</div>
<?php echo form_close();?>
<script>
	$(document).ready(function() {
		$(".item_paso1").addClass('active');
		$(".item_paso2").removeClass('active');
		$(".item_paso3").removeClass('active');

	});
</script>