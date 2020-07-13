$(document).ready(function() {
	$(".selectAjaxImpuestos").select2({
		ajax: {
			url: baseUrl+'/ingresos/buscarImpuestos',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
			},
			processResults: function (data) {
				console.log(data);
				//data trae los resultados
				return {
					results: $.map(data, function(obj) {
						return { id: obj.id, text: obj.concepto };
					})
				};
			},
			cache: true
		},
		minimumInputLength: 1
	});
});