$(document).ready(function() {
	
	$(".selectAjaxProductos").select2({
		ajax: {
			url: baseUrl+'/ingresos/buscarProductos',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data) {
				resultados = data;
				//data trae los resultados
				return {
					results: $.map(data, function(obj) {
						return { id: obj.id, text: obj.descripcion };
					})
				};
			},
			cache: true
		},
		minimumInputLength: 1
	});
});