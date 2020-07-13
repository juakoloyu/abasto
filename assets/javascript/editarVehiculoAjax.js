$(document).ready(function() {
		var titular,tipo,dominio,ejes_simples,ejes_dobles;
		var tr,datosVehiculo;
		$(".editar").click(function(event) {
			$(".editar,.confirmar").hide();
			$(".cancelar,.actualizar").show();
			tr = $(this).closest('tr');
			$(tr).find('input,select').each(function(index, el) {
				$(el).attr('readonly',false);
			});
			$(tr).find('select').each(function(index, el) {
				$(el).attr('disabled',false);
			});
			setDatosVehiculo();			
		});
		$(".cancelar").click(function(event) {
			$("#titular").val(datosVehiculo.titular);
			$("#tipo").val(datosVehiculo.tipo_vehiculo);
			$("#dominio").val(datosVehiculo.dominio);
			$("#ejes_simples").val(datosVehiculo.eje_simple);
			$("#ejes_dobles").val(datosVehiculo.eje_doble);
			$(tr).find('input').each(function(index, el) {
				$(el).attr('readonly',true);
			});
			$(tr).find('select').each(function(index, el) {
					$(el).attr('disabled',true);
				});
			$(".editar,.confirmar").show();
			$(".cancelar,.actualizar").hide();
		});
		$(".actualizar").click(function(event) {
			setDatosVehiculo();
			$.ajax({
				url: baseUrl+'/ingresos/ajaxVehiculoUpdate',
				type: 'POST',
				data: {datosVehiculo: datosVehiculo}
			})
			.done(function(data) {
				$(".editar,.confirmar").show();
				$(".cancelar,.actualizar").hide();
				$(tr).find('input').each(function(index, el) {
					$(el).attr('readonly',true);
				});
				$(tr).find('select').each(function(index, el) {
					$(el).attr('disabled',true);
				});
			})
			.fail(function() {
				console.log("error");
			});
			
		});

		$("#tipo").change(function(event) {
			
			//Si es camion activamos la segunda columna
			if ($(this).val()=='1') 
			{
				$("#td_eje_doble,#th_eje_doble").show();
			}else{
				//seteamos el eje doble en 0
				$("#ejes_dobles").val(0);

				$("#td_eje_doble,#th_eje_doble").hide();
			}
		});

		function setDatosVehiculo()
		{
			datosVehiculo = {
				titular: $("#titular").val(),
				tipo_vehiculo: $("#tipo option:selected").val(),
				dominio: $("#dominio").val(),
				eje_simple: $("#ejes_simples").val(),
				eje_doble: $("#ejes_dobles").val(),
				id: vehiculo_id
			}
		}
	});