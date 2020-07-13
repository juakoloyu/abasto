<table width="100%">
	<tbody>
		<tr>
			<td width="33.33%" style="text-align: center;">
				<img width="100px" height="147px" src="<?php echo base_url()?>public/escudo.png"><br>
			    <h5 class="titulo">MUNICIPALIDAD</h5>
			    <p>-de-</p>
			    <p>Presidencia Roque Saenz Peña</p>
			</td>
			<td width="33.33%">
				<table width="100%" border="1" align="center">
					<tr style="text-align: center;">
						<th>Día</th>
						<th>Mes</th>
						<th>Año</th>
						<th>Hora</th>
					</tr>
					<tr  style="text-align: center;">
						<td><?php echo date('d',strtotime($derecho_piso[0]->fecha))?></td>
						<td><?php echo date('m',strtotime($derecho_piso[0]->fecha))?></td>
						<td><?php echo date('Y',strtotime($derecho_piso[0]->fecha))?></td>
						<td><?php echo date('H:i',strtotime($derecho_piso[0]->fecha))?></td>
					</tr>
				</table>
			</td>
			<td width="33.33%" style="text-align: center;">
				<h5>SUBSECRETARIA DE SALUD CIUDADANA</h5>
				<h5>Y SEGURIDAD ALIMENTARIA</h5>
				<h5>SECCIÓN INTRODUCCIÓN</h5>
				<span>Nº: <?php echo $derecho_piso[0]->numero_ingreso?></span>
			</td>
		</tr>
	</tbody>
</table>
<h3 style="text-align: center;"><u>AUTORIZACIÓN DERECHO DE PISO</u></h3>
<div id="cuerpo">
	<table width="100%" border="1">
		<thead>
			<tr style="text-align: center;">
				<th colspan="2">CÉDULA IDENTIFICACIÓN DEL AUTOMOTOR</th>
			</tr>
			<tr style="text-align: center;">
				<th colspan="2">TITULAR (Apellido y Nombre / Razón Social)</th>
			</tr>
			<tr  style="text-align: center;">
				<td colspan="2"><?php echo $derecho_piso[0]->titular?></td>
			</tr>
			<tr  style="text-align: center;">
				<th>Tipo Documento</th>
				<th>Número</th>
			</tr>
			<tr style="text-align: center;">
				<td><?php echo $derecho_piso[0]->tipo_documento?></td>
				<td><?php echo $derecho_piso[0]->documento?></td>
			</tr>
			<tr style="text-align: center;">
				<th>Dominio</th>
				<th>Marca</th>
			</tr>
			<tr style="text-align: center;">
				<td><?php echo $derecho_piso[0]->dominio?></td>
				<td><?php echo $derecho_piso[0]->marca?></td>
			</tr>
			<tr style="text-align: center;">
				<th>Modelo</th>
				<th>Tipo</th>
			</tr>
			<tr style="text-align: center;">
				<td><?php echo $derecho_piso[0]->modelo?></td>
				<td><?php echo $derecho_piso[0]->tipo_vehiculo?></td>
			</tr>
			<tr style="text-align: center;">
				<th colspan="2">Domicilio Particular</th>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2"><?php echo $derecho_piso[0]->domicilio?></td>
			</tr>
			<tr style="text-align: center;">
				<th>Localidad</th>
				<th>Provincia</th>
			</tr>
			<tr style="text-align: center;">
				<td><?php echo $derecho_piso[0]->localidad?></td>
				<td><?php echo $derecho_piso[0]->provincia?></td>
			</tr>
		</thead>
	</table>
	<br>
	<table width="100%" border="1">
		<thead>
			<tr style="text-align: center;">
				<th  colspan="2">LICENCIA DEL CONDUCTOR</th>
			</tr>
			<tr style="text-align: center;">
				<th colspan="2">Apellido y Nombre</th>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2"><?php echo $derecho_piso[0]->apellido_nombre_conductor?></td>
			</tr>
			<tr  style="text-align: center;">
				<th width="50%">Tipo Documento</th>
				<th width="50%">Número</th>
			</tr>
			<tr style="text-align: center;">
				<td width="50%"><?php echo $derecho_piso[0]->tipo_documento_conductor?></td>
				<td width="50%"><?php echo $derecho_piso[0]->documento_conductor?></td>
			</tr>
			<tr width="50%" style="text-align: center;">
				<th>Licencia Categoría</th>
				<th>Licencia Nº</th>
			</tr>
			<tr style="text-align: center;">
				<td width="50%"><?php echo $derecho_piso[0]->cat_licencia?></td>
				<td width="50%"><?php echo $derecho_piso[0]->licencia_conductor?></td>
			</tr>
		</thead>
	</table>
	<br>
	<p>DESTINO O CONSIGNADO: <?php echo $derecho_piso[0]->destino?></p>
	<br>
	<p>OBJETOS TRANSPORTADOS: <?php echo $derecho_piso[0]->objetos_transportados?></p>
	<br>
	<p>DIAS DE PERMANENCIA EN LA CIUDAD: <?php echo $derecho_piso[0]->dias?> días</p>
	<p><b>SE LE HACE SABER:</b> Que deberá adoptar las máximas precauciones para evitar anormalidades en el tránsito en general. El recurrente se hace responsable en lo civil y penal por los daños ocasionados contra terceros. <b>QUEDA Ud. DEBIDAMENTE NOTIFICADO.</b></p>
	<br><br><br><br><br><br><br><br><br><br>
	<table width="100%">
		<tr style="text-align: center;">
			<td>……………………………………………………………</td>
			<td>……………………………………………………………</td>
		</tr>
		<tr style="text-align: center;">
			<td>Funcionario Municipal </td>
			<td>Transportista</td>
		</tr>
	</table>
</div>
<style type="text/css">

	table { 
		text-indent: 0.5em;
		border-color: black;
		color: black;
	 }

	.titulo{
    margin-bottom: 5px;
	}

	#cuerpo { 
		text-indent: 1em;
		border-color: black;
		color: black;
		font-size: large;
	}

	th {
    background-color: rgb(138, 180, 248);
    color: black;
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
