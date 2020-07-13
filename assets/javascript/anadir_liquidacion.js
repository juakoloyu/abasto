$(document).ready(function() {
	$("#añadirLiquidacion").click(function(event) {
		$("#contenedor").show();
		//Si estamos en el formulario de edicion (De agregar nuevas liquidaciones)
		if ($("#tipo_empresa_cargada").length>0) {
			var tipo_empresa_cargada = $("#tipo_empresa_cargada").val();
			var tipo_tributo_cargado = $("#tipo_tributo_cargado").val();

			if (tipo_empresa_cargada==1) {
				$(".local").prop('readonly', false);			
			}
			else if (tipo_empresa_cargada==2) {
				$(".otra_loc").prop('readonly', false);
			}
			else if (tipo_empresa_cargada==3) {
				$(".otra_prov").prop('readonly', false);
			}

			if (tipo_tributo_cargado==1) {
				//Si es ingreso cargado es de Alimentos
				$(".tipo_1").show();
				$(".tipo_2").hide();
			}else if (tipo_tributo_cargado==2){
				//Si es ingreso cargado es de Derecho de Piso
				$(".tipo_1").hide();
				$(".tipo_2").show();
			}
		}		
	});
});