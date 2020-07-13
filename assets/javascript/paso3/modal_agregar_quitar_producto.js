$(document).ready(function() {
	$("#agregarProducto").click(function(event) {

			var producto = $(".selectAjaxProductos").select2('data')[0].text;
			var producto_id = $(".selectAjaxProductos").select2('data')[0].id;
			var cantidad = $("#cantidad_prod").val();
			var peso;
			var subtotal;
			$.each(resultados, function(index, el) {
			    if (el.id == producto_id) {
			        if (el.peso<=0) 
			        {
			        	alert("Este producto no tiene cargado el peso.");
			        }else{
			        	peso = el.peso;	
			        	cantidad = parseFloat(cantidad);
			        	peso = parseFloat(peso);
			        	subtotal = peso*cantidad;
			        	subtotal = parseFloat(subtotal);
			        }			        
			    }
			});
			
			if ($(".selectAjaxProductos").val()> 0 && cantidad > 0) 
			{
				$("#productosCalculadora").before("\
					<tr>\
						<td>"+producto+"</td>\
						<td class='cant'>"+cantidad.toFixed(1)+"</td>\
						<td class='peso'>"+peso.toFixed(2)+"</td>\
						<td class='subtotal'>"+subtotal.toFixed(2)+"</td>\
						<td><a class='quitarProd btn btn-danger btn-link btn-sm' href='javascript:void(0)'><i class='tim-icons icon-simple-remove'></i></a>\
						</td>\
					</tr>");
				sumarCantidades();
				//Reiniciamos select2 & input cantidad
				$('.selectAjaxProductos').val("").trigger("change");
				$("#cantidad_prod").val("");
			}
		});

	$(document).on('click', '.quitarProd', function(event) {
		event.preventDefault();
		$(this).closest('tr').remove();
		sumarCantidades();
	});

	function sumarCantidades()
	{
		var suma = 0;
		var num;
		$(".subtotal").each(function(index, el) {
			num = $(el).text();
			num = parseFloat(num); 
			suma += num;
		});
		if (suma>0) 
		{
			$("#productosCalculadora,.agregarSuma").show();
			$("#total").text(suma.toFixed(1));
		}else{
			$("#productosCalculadora,.agregarSuma").hide();
		}
		
	}
});