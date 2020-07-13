<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
        <h6 class="title title-up">Añadir items</h6>
      </div>
      <div class="modal-body">
      	<table class="table">
      		<thead>
      			<tr>
      				<th colspan="2" width="60%">
						<select name="alimento_id" class="selectAjaxProductos" style="width:100%">
							<option readonly="" value="" selected="selected">Buscar producto...</option>
						</select>
      				</th>
      				<th><input min='0' type="number" placeholder="Unidades" id="cantidad_prod" class="form-control mt-2"/></th>
      				<th>
						<a id="agregarProducto" href="javascript:void(0)" class="btn btn-sm btn-primary">Agregar</a>
      				</th>
      			</tr>
      			<tr>
      				<th>Producto</th>
      				<th>Cantidad</th>
      				<th>Peso</th>
      				<th>Subtotal</th>
      			</tr>
      		</thead>
      		<tbody id="tbodyProductos">
      			<tr style="display: none" id="productosCalculadora">
      				<td colspan="3"><b>Total</b></td>
      				<td id="total"></td>
      				<td></td>
      			</tr>
      		</tbody>
      	</table>
      </div>
      <div class="modal-footer mt-4">
        <button style="display: none" type="button" class="btn btn-primary agregarSuma2" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL DE LA CALCULADORA -->
<div class="modal fade" id="calcu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
        <h6 class="title title-up">Sumar Valores</h6>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="text" placeholder="Ingrese un numero" id="valorInput" class="form-control col-sm-6">
          <button id="suma" class="btn btn-sm ml-2">Sumar</button>
        </div>
        <div class="text-left">
          <br>
          <ul id="valoresAsumar"></ul>
          <hr>
          Total = <span id="total2"></span>
        </div>
      </div>
      <div class="modal-footer mt-4">
        <button style="display: none" type="button" id="agregarCalcu" class="btn btn-warning" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>

<script>
  //SCRIPT VALIDO PARA LA CALCULADORA
  $(document).ready(function() {
    var valorInput,table_row;
    var sumaTotal;
    $(document).on('click', '.abrirCalcu', function(event) {
      table_row=$(this).closest('tr');
    });

    $(document).on('click', '#suma', function(event) {
      event.preventDefault();
      sumaTotal=0;
      valorInput = $("#valorInput").val();
      if (valorInput>0) 
      {
        //Cargamos en la lista:
        $("#valoresAsumar").append("<li class='valorI'>"+valorInput+"</li>");
        //Limpiamos input:
        $("#valorInput").val('');
        //Sumamos los valores de la lista:
        $(".valorI").each(function(index, el) {
            valorLista = $(el).text();
            valorLista = parseFloat(valorLista); 
            sumaTotal += valorLista;
        });
        $("#total2").text(sumaTotal);
        if (sumaTotal>0) 
        {
          $("#agregarCalcu").show();
        }else{
          $("#agregarCalcu").hide();
        }
        $("#aceptar").click(function(event) {
          $("#valorInput").val('');
        });
      }else{
        alert("Debe ingresar un valor numerico. Los decimales se ingresan con punto: Ej: 10.5");
      }    
    });
    $("#agregarCalcu").click(function(event) {
      $("#valoresAsumar").html('');
      $("#total2").text('');
      $(table_row).find('.cantidad').val(sumaTotal).keyup();
      sumaTotal=0;
    });

  });
</script>
