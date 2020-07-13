$(document).ready(function() {
	$(document).on('click', '.modalopen', function(event) {
		event.preventDefault();
		//Guardamos en una variable el input cantidad de la fila
		inputCantidad = $(this).closest('tr').find('.cantidad');
		
		//Reiniciamos el select2 del modal
		$('.selectAjaxProductos').val("").trigger("change");
		//Limpiamos la tabla del modal
		$("#tbodyProductos > tr").not("#productosCalculadora").remove();
		//Ocultamos el resultado del modal
		$("#productosCalculadora").hide();
	});	
});