//El monto del total del modal lo agrega en el Input de cantidad
$(".agregarSuma").click(function(event) {
	var total = $("#total").text();
	$(inputCantidad).val(total);
	$(".cantidad").keyup();
});

//El monto del total del modal lo agrega en el Input de cantidad
$(".agregarSuma2").click(function(event) {
	var total = $("#total2").text();
	$(inputCantidad).val(total);
	$(".cantidad").keyup();
});