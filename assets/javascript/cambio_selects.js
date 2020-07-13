$(document).ready(function() {
	
	$("#tipo_tributo").change(function(event) {
		var tipo_tributo = $(this).val();
		if (tipo_tributo==1) {
			//Si es prod alimenticio
			$("#div_consignado,#dias_permanencia,#objetos_transportados").hide();

			//Mostramos divs && Inputs
			$("#div_tipo_empresa,#senasa,#proc_estanc,#div_responsable,#tipo_empresa,#empresa_prov,#mat_num,#prec_num").show();
			//Agregamos campos requeridos
			$("select")
				.each(function(index, el) {
					console.log($(el).prop('required',true));
				});

			$("#destino_consignado").val("");
		}else if (tipo_tributo==2) {
			//Si es derecho de piso
			$("#objetos_transportados").show();
			$("#dias_permanencia").show();
			$("#select_responsable").val('unico').change();

			//Ocultamos divs && Inputs
			$("#div_tipo_empresa,#div_responsable,#senasa,#proc_estanc,#empresa_prov,#tipo_empresa,#mat_num,#prec_num").hide();
			//Quitamos Required a los inputs
			$("select[name='empresa_proveedora'],select[name='tipo_empresa']")
				.each(function(index, el) {
					console.log($(el).prop('required',false));
				});

			$("#div_consignado").show();
			$("#destino_consignado").val("");
		}
		$("#importe").attr('value',0);
		reiniciarValores();
	});

	$("#tipo_empresa").change(function(event) {
		
		var tipo_empresa = $(this).val();

		if (tipo_empresa==1) {
			$(".local").prop('readonly', false);
			$(".otra_loc").prop('readonly', true);
			$(".otra_prov").prop('readonly', true);
		}
		else if (tipo_empresa==2)
		{
			$(".local").prop('readonly', true);
			$(".otra_loc").prop('readonly', false);
			$(".otra_prov").prop('readonly', true);
		}
		else if (tipo_empresa==3)
		{
			$(".local").prop('readonly', true);
			$(".otra_loc").prop('readonly', true);
			$(".otra_prov").prop('readonly', false);
		}

		reiniciarValores();
	});

	function reiniciarValores()
	{
		//Seteamos en 0
		var inputs = $(".cantidad:visible");
		if (inputs.length>0) 
		{
			inputs.each(function(index, el) 
			{
				if ($(el).val() > 0) 
				{
					//Seteamos en 0 el input
					$(el).val(0);		
					//Ejecuta cambio_input_cantidad.js
					$(el).keyup();
				}
			});
		}

		var tipo_empresa=$("#tipo_empresa").val();
		/*Si es local removemos los tributos obligatorios desde afuera: 'Pescados,camaron,etc'*/
		if (tipo_empresa=='1') 
		{
			$(".local").each(function(index, el) {
				if ($(el).val()=='') {
					$(el).closest('tr').hide();
				}		
			});
		}else{
			$(".local").each(function(index, el) {
				$(el).closest('tr').show();	
			});
		}
	}
});