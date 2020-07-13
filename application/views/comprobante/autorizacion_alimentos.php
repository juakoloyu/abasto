<table width="100%">
	<tbody>
		<tr>
			<td width="50%" style="text-align: center;">
				<img width="100px" height="147px" src="<?php echo base_url()?>public/escudo.png"><br>
			    <h5 class="titulo">MUNICIPALIDAD</h5>
			    <p>-de-</p>
			    <p>Presidencia Roque Saenz Peña</p>
			</td>
			<td width="50%" style="text-align: center;">
				<h5>Nº <?php echo $alimentos[0]->numero_ingreso?></h5>
				<h5>SUBSECRETARIA DE SALUD CIUDADANA</h5>
				<h5>Y SEGURIDAD ALIMENTARIA</h5>
			</td>
		</tr>
	</tbody>
</table>
<div align="center">
	<h1>Inspecciones Bromatológicas</h1>
</div>
<div class="row">
	<div class="col-md-12" id="cuerpo">
		<p>Pcia. Roque Sáenz Peña, <?php echo date('d',strtotime($alimentos[0]->fecha))?> de <?php echo $meses[date('m',strtotime($alimentos[0]->fecha))-1]?> de <?php echo date('Y',strtotime($alimentos[0]->fecha))?></p>
		<p>Negocio o Industria: <?php echo $alimentos[0]->empresa_proveedora?></p>
		<table width="100%">
			<tbody>
				<tr>
					<td width="50%">
						<p>Propietario: <?php echo $alimentos[0]->propietario?></p>
					</td>
					<td width="50%">
						<p>Dirección: <?php echo $alimentos[0]->direccion?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p>En el día de la fecha el Inspector Municipal que suscribe ha practicado la inspección reglamentaria en el establecimiento, verificando:</p>
		<br>
		<table width="100%" border="1">
			<tbody>
				<!--
					<p><?php echo $alimentos[0]->observaciones?></p>
				-->
				<?php foreach($alimentos as $a) { ?>
						<tr>
							<td colspan="2" style="border-right-style: hidden;border-left-style: hidden;text-align: justify;">
								<?php echo $a->empresa_destino?> - Nº Comprobante de respaldo: <?php echo $a->nro_factura?>
							</td>
						</tr>
				<?php } ?>
						<tr>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								<br>
							</td>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								<br>
							</td>
						</tr>
						<tr>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								<br>
							</td>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								
							</td>
						</tr>
						<tr>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								Mat Nº: <?php echo $alimentos[0]->mat_n?>
							</td>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								Proc. Est. Nº: <?php echo $alimentos[0]->proc_estancia?>
							</td>
						</tr>
						<tr>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								Prec. Nº: <?php echo $alimentos[0]->prec_n?>
							</td>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								SENASA Nº: <?php echo $alimentos[0]->senasa?>
							</td>
						</tr>
						<tr>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								Tpte: <?php echo $alimentos[0]->patente?>
							</td>
							<td width="50%" style="border-right-style: hidden;border-left-style: hidden;">
								Hora: <?php echo date('H:i',strtotime($alimentos[0]->fecha))?>
							</td>
						</tr>
			</tbody>
		</table>
	</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<table width="100%">
	<tr style="text-align: center;">
		<td>……………………………………………………………</td>
		<td>……………………………………………………………</th>
	</tr>
	<tr style="text-align: center;">
		<td>FIRMA DEL INSPECTOR</td>
		<td>FIRMA DEL PROPIETARIO</td>
	</tr>
</table>
<style type="text/css">

	table { 
		text-indent: 1em;
		border-color: black;
		color: black;
	}

	#cuerpo { 
		text-indent: 1em;
		border-color: black;
		color: black;
		font-size: large;
	}

	.titulo{
    margin-bottom: 2px;
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
	$(document).ready(function() {
		setTimeout(
		   function(){
			if (window.print) {
			 window.print(); window.close(); 
			} }, 2000);
	});
</script>