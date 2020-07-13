<table width="100%">
	<thead>
		<tr>
			<th width="60%" style="text-align: center;">
			    <img width="67px" height="100px" src="<?php echo base_url()?>public/escudo.png"><br>
			    <h5 class="titulo">MUNICIPIO DE</h5>
			    <h4 class="titulo">PRESIDENCIA ROQUE SAENZ PEÑA</h3>
			    <h5><i>SUBSECRETARIA DE LA SALUD CIUDADANA<br>Y SEGURIDAD ALIMENTARIA</i></h4>

			</th>
			<th width="40%" style="text-align: center;">
				<!--
				<h5>"1816 BICENTENARIO DE LA <br> INDEPENDENCIA NACIONAL 2016"</h5>-->
				<h4 class="titulo">RECIBO OFICIAL DE PAGO</h4>
				<h5 class="titulo">REINSPECCIÓN - ABASTO - INTRODUCCIÓN</h5>
				<h5>Recibo Nº <?php echo $cabecera->numero_recibo?></h5>
				<table width="100%" border="1">
					<thead >
						<th width="33%" style="text-align: center;"><?php echo date('d',strtotime($cabecera->fecha_generacion))?></th>
						<th width="33%" style="text-align: center;"><?php echo date('m',strtotime($cabecera->fecha_generacion))?></th>
						<th width="33%" style="text-align: center;"><?php echo date('Y',strtotime($cabecera->fecha_generacion))?></th>
					</thead>
				</table>
				<table width="100%">
					<thead >
						<th width="33%" style="text-align: center;">Día</th>
						<th width="33%" style="text-align: center;">Mes</th>
						<th width="33%" style="text-align: center;">Año</th>
					</thead>
				</table>
			</th>
		</tr>
	</thead>
</table>
<h3 style="text-align: center;">INTRODUCCIÓN DE PRODUCTOS ALIMENTICIOS<br><u>DERECHO SOBRE EL ABASTO GENERAL</u></h3>
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="2%" rowspan="3"> <span class="texto-vertical">Datos</span></th>
			<th width="48%">
				<div class="cell">
			        <span>CUIT</span>
			        <p class="abajo"><?php echo $cabecera->cuit?></p>
			    </div>
			</th>
			<th width="50%">
				<div class="cell">
			        <span>Propietario</span>
			        <p class="abajo"><?php echo $cabecera->propietario?></p>
			    </div>
			</th>
		</tr>	
		<tr>
			<th colspan="7" style="vertical-align: top;">
				<div class="cell">
			        <span>Razón Social</span>
			        <p class="abajo"><?php echo $cabecera->razon_social?></p>
			    </div>
			</th>
		</tr>
		<tr>
			<td>Si es gran contribuyente, marque "X"</td>
			<td colspan="4"><b>Domicilio:</b> <?php echo $cabecera->domicilio?></td>
		</tr>
	</thead>
</table>
<br>
<table width="100%" border="1">
	<thead>
		<tr>
			<th style="border-top-style: hidden;border-left-style: hidden;"></th>
			<th style="border-top-style: hidden;border-left-style: hidden;"><?php if(empty($cabecera->telefono)){}else{echo $cabecera->telefono.' /';} ?> <?php echo $cabecera->email?><br><p style="border-bottom: 1px dotted #000;"></p>
			</th>
			<th style="text-align: center;">Kg./Lts./Uds.</th>
			<th style="text-align: center;">Coef.</th>
			<th style="text-align: center;">Importe</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($datos_liquidacion as $i => $dl){ ?>
			<?php if($i < 1){ ?>
					<tr>
						<td width="2%" rowspan="<?php echo count($datos_liquidacion)?>"> <span class="texto-vertical">PAGOS</span></td>
						<td width="68%"><?php echo $dl->concepto?></td>
						<td style="text-align: center;"><?php echo $dl->unidades?></td>
						<td style="text-align: center;"><?php echo $dl->coeficiente?></td>
						<td style="text-align: center;"><?php echo $dl->importe?></td>
					</tr>
					<?php } else{ ?>
					<tr>
						<td width="68%"><?php echo $dl->concepto?></td>
						<td style="text-align: center;"><?php echo $dl->unidades?></td>
						<td style="text-align: center;"><?php echo $dl->coeficiente?></td>
						<td style="text-align: center;"><?php echo $dl->importe?></td>
					</tr>
				<?php } ?>
			<?php } ?>
			<tr>
				<td style="border-bottom-style: hidden;border-left-style: hidden;"></td>
				<td width="68%">GASTOS ADMINISTRATIVOS / INFRAESTRUCTURA 8%</td>
				<td style="text-align: center;">20</td>
				<td style="text-align: center;">8%</td>
				<td style="text-align: center;"><?php echo $suma*0.08?></td>
			</tr>
			<tr>
				<td style="border-bottom-style: hidden;border-left-style: hidden;"></td>
				<td style="border-bottom-style: hidden;border-left-style: hidden;"></td>
				<td style="text-align: center;"><h4 class="titulo">PAGO TOTAL $</h4></td>
				<td style="text-align: center;" colspan="2"><h4 class="titulo"><?php echo $cabecera->total ?></h4></td>
			</tr>
	</tbody>
</table>
<div class="firma">
  	<h4 style="text-align: center;">ESPACIO EXCLUSIVO PARA EL<br>SELLO DE CAJA</h4>
</div>

<style type="text/css">
	table { 
		text-indent: 1em;
		border-color: black;
		color: black;
		font-size: medium;
	}
	.firma {
	    border-style: solid; border-width: 1px;
	  	height: 150px;
	  	border-color: black;
	  	width: 71.8%;
	  	position: relative;
	  	top: -33px;
	}

	.texto-vertical {
	writing-mode: vertical-lr;
	transform: rotate(180deg);
	}

	.cell {
    padding-bottom:40px;
    position:relative;
	}
	.cell .abajo {
	    vertical-align: bottom;
	    position:absolute;
	    bottom:0px;
	}
	table { 
		text-indent: 0.5em;
		border-color: black;
		color: black;
	 }

	.titulo{
    margin-bottom: 5px;
	}

	.main-panel {
    position: absolute;
    float: right;
    width: 100%;
    min-height: 100vh;
    border-top: 0px solid #BA0021;
    background: linear-gradient(#1e1e2f,#1e1e24);
	}

	.main-panel>.content {
    padding: 10px 30px 30px 280px;
		}

	@media print {
		#noprint,#searchModal,footer{
		  display: none !important;
		}
</style>

<script type="text/javascript">
	setTimeout(
	   function(){
		if (window.print) {
		 window.print(); window.close(); 
		} }, 2000);
</script>
