$(document).ready(function() {
	$(".selectAjaxVehiculos").select2({
		language: {
		    noResults: function() {
		      return "No hay resultado";        
		    },
		    searching: function() {
		      return "Buscando..";
		    },
		    inputTooShort: function () {
			    return 'Ingrese al menos 2 caracteres';
			}
		},
		ajax: {
			url: baseUrl+'/ingresos/buscarVehiculos',
			dataType: 'json',
			delay: 400,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data) {
				//data trae los resultados
				return {
					results: $.map(data, function(obj) {
						return { id: obj.id, text: obj.dominio+" - ("+obj.titular+")" };
					})
				};
			}
		},
		minimumInputLength: 2
	});
});


