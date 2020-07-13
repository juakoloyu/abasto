
	<div class="wizard-container">
		<div class="card card-wizard active" data-color="blue" id="wizardProfile">
	        	<div class="card-header text-center">
		            <h3 class="card-title">
		            	<?php echo $titulo ?>
		            </h3>
		            <div class="wizard-navigation">
			            <div class="progress-with-circle">
			            	<div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="2" style="width: 16.6667%;"></div>
		           		</div>
			            <ul class="nav nav-pills">
			            	<li class="nav-item" style="width: 33.3333%;">
				                <a class="nav-link item_paso1" href="#paso1" data-toggle="tab">
				                <i class="tim-icons icon-delivery-fast"></i>
				                <p>Ingreso</p>
				            	</a>
			                </li>
			                <li class="nav-item" style="width: 33.3333%;">
				                <a class="nav-link item_paso2" href="#paso2" data-toggle="tab">
					                <i class="fas fa-store"></i>
					                <p>Destinatarios</p>
				                </a>
			                </li>
			                <li class="nav-item" style="width: 33.3333%;">
			                	<a class="nav-link item_paso3" href="#paso3" data-toggle="tab">
			                    <i class="fas fa-tasks"></i>
			                    <p>Liquidaciones</p>
			                 	</a>
							</li>
			            </ul>
		            </div>
	            </div>
				<?php $ingreso_id = $this->uri->segment(3) ?>
	            <div class="card-body">
		            <div class="tab-content">
		            		
							<!-- ############## SI NO ESTÁ CREADO EL INGRESO: Paso 1 Creación del ingreso ############## -->
							<?php if (!isset($ingreso_id)){ //SI ESTAMOS VIENDO UN INGRESO YA CREADO?>
								<?php $this->load->view('ingresos/paso1') ?>
							<?php }  
		               
							############## SI ESTA CREADO EL INGRESO: PASO 2 Creacion de Liquidación ############## -->
							else if (isset($ingreso_id) && !isset($paso3)){ //SI ESTAMOS VIENDO UN INGRESO YA CREADO?>
								<?php $this->load->view('ingresos/paso2') ?>
		
						<?php } #CIERRO SI ESTA DEFINIDO EL INGRESO

						############## SI ESTA CREADO EL INGRESO: PASO 3 Completar Liquidación ############## -->
						else if (isset($ingreso_id) && isset($paso3)){ ?>
							<?php $this->load->view('ingresos/paso3') ?>
						<?php } ?>
	                </div>
                </div>
            </div>
          </div>




<script type="text/javascript">
//Defino base URL para usarla en los scripts
var baseUrl = '<?= base_url()?>';
</script>

<script src="<?php echo base_url('assets/javascript/cambio_selects.js') ?>"></script>

<script src="<?php echo base_url('assets/javascript/anadir_liquidacion.js') ?>"></script>
<script>
	$(document).ready(function() {
		$(".select2").select2({    
		  language: {
		    noResults: function() {
		      return "No hay resultado";        
		    },
		    searching: function() {
		      return "Buscando..";
		    }
		  }
		});
	});
</script>
<script src="<?php echo base_url('assets/javascript/select2AjaxProductos.js')?>"></script>
<script src="<?php echo base_url('assets/javascript/select2AjaxImpuestos.js')?>"></script>
<script src="<?php echo base_url('assets/javascript/select2AjaxVehiculos.js')?>"></script>