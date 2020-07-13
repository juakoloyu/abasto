$(document).ready(function() {
	$(document).on('keyup', '.cantidad', function(event) {
		event.preventDefault();

		//Seleccionamos fila
		var tr = $(this).closest('tr');
		
		var importe_fila = 1;
		// ####MULTIPLICACION DE LA FILA####
		tr.find(':input:visible:not(.importe)').each(function(index, el) {
			el = parseFloat(el.value);
			if (el>0) 
			{
				importe_fila =  el * importe_fila;
			}else{
				importe_fila=0;
			}			
		});

		//Y lo asignamos a la columna Importe
		importe_fila = parseFloat(importe_fila).toFixed(2);

		tr.find('.importe').attr('value',importe_fila);


		// ####SUMA DE LA COLUMNA####
		total = 0;
		$(".importe").each(function(index, el) {
			el = parseFloat(el.value);
			if (el>0) 
			{
				total += el;
			}		
		});
		total = parseFloat(total).toFixed(2);
		$("#importe").attr('value',total);
	});
});