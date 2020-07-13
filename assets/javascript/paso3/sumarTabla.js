$(document).ready(function() {
	function sumarCantidades()
		{
			var suma = 0;
			var num;
			$(".cant").each(function(index, el) {
				num = $(el).text();
				num = parseInt(num); 
				suma += num;
			});
			if (suma>0) 
			{
				$("#productosCalculadora,.agregarSuma").show();
				$("#total").text(suma);
			}else{
				$("#productosCalculadora,.agregarSuma").hide();
			}
			
		}
});