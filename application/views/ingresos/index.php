	<div class="input-group col-md-2">
    	<div class="input-group-prepend">
	        <div class="input-group-text">
	        	<i class="far fa-calendar-alt"></i>
	        </div>
        </div>
        <input type="date" class="form-control" id="fecha">
    </div>
 

 <table border="0" class="table" id="datatable" width="100%">
	<thead>
        <tr>
        	<th>N°</th>
            <th>Fecha</th>
            <th>Destinos</th>
            <th>Vehículos</th>
            <th>Tipo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <tbody>
	</tbody>
</table>

<script>
$(document).ready(function() {
	var fecha;
	$("#fecha").change(function(event) {
		fecha = $(this).val(); 
			table.search(fecha).draw();
	});

	$(document).on('click', '.eliminar', function() {
		return confirm("Estas seguro?");
	});
	// DataTable
	var table = $('#datatable').DataTable( 
	{
		"serverSide": true,
	    "responsive": true,
	    "ajax":{
			    "url": "<?php echo base_url('ingresos/serverBuscadorAjax') ?>",
			    "dataType": "json",
			    "type": "POST"
			},
	    "columns": [
	    			{"data": "id"},
		          	{"data": "fecha"},
		        	{"data": "destinos"},
		        	{"data": "vehiculos" },
		        	{"data": "tipo" },
		         	{"data": "accion"},
		       ],
		"order": [[ 0, "desc" ]],
	    language: 
	    {
			"decimal": "",
		    "emptyTable": "No hay información",
		    "info": "Mostrando _START_ a _END_ de un total de _TOTAL_ Entradas",
		    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
		    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
		    "infoPostFix": "",
		    "thousands": ",",
		    "lengthMenu": "Mostrar _MENU_ Entradas",
		    "loadingRecords": "Cargando...",
		    "processing": "Procesando...",
		    "search": "Buscar:",
		    "zeroRecords": "No hay resultados encontrados",
		    "paginate": 
		    {
			    "first": "Primero",
			    "last": "Ultimo",
			    "next": "Siguiente",
			    "previous": "Anterior"
	       	}
	    }
	});

	
});
</script>
