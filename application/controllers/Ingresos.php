<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Ingresos extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Ingresos_model');
		require  'vendor/autoload.php';
	}

	function index() 
	{
		$data['titulo'] = 'Ingresos';
		$data['content'] = '/ingresos/index';
		$this->load->view('/includes/template', $data);
	}

	function nuevoIngreso($ingreso_id = NULL) 
	{
		$data['titulo'] = 'Nuevo Ingreso';

		if ($ingreso_id) {
			$data['titulo'] = 'Ingreso #'.$ingreso_id;
			$data['ingreso'] = $this->Ingresos_model->getIngreso($ingreso_id);
			$data['empresas_asignadas'] = $this->Ingresos_model->getEmpresasDelIngreso($ingreso_id);
		}
		$data['transportistas'] = $this->Transportistas_model->find();
		$data['empresas'] = $this->Empresas_model->find();
		$data['impuestos'] = $this->Ingresos_model->getImpuestos();
		$tipos_vehiculos = $this->db->select('id,tipo')->get('tipo_vehiculo')->result();
		foreach ($tipos_vehiculos as $tipo) {
			$tipos[$tipo->id] = $tipo->tipo;
		}
		$data['tipos_vehiculos'] = $tipos;
		if ($ingreso_id != NULL) 
		{
			$data['impuestos'] = $this->Ingresos_model->getImpuestosWhere($ingreso_id);
			# Si estamos visualizando un ingreso cargado pasamos la sig. URL para el POST del form
			$data['urlPost'] = 'ingresos/paso2';

			# Verificamos si es unico responsable y traemos el N° de Factura + El responsable:
			$data['responsable'] = $this->Ingresos_model->getResponsable($ingreso_id);
		}else
		{
			# Si estamos por cargar un ingreso:
			$data['urlPost'] = 'ingresos/save';
		}
		$data['content'] = '/ingresos/nuevo_ingreso';
		$this->load->view('/includes/template', $data);
	}

	function quitarResponsable($ingreso_id)
	{
		$this->Ingresos_model->quitarResponsable($ingreso_id);
		redirect('ingresos/nuevoIngreso/'.$ingreso_id);
	}

	//POST
	#Para la creación del ingreso con la 1° Liquidacion
	function save()
	{	
		$this->form_validation->set_rules('transportista_id', 'Transportista', 'required');
		if ($this->form_validation->run()) 
		{	
			
			//CONTRIBUYENTE UNICO O MULTIPLES
			$contribuyentes = $this->input->post('contribuyentes');
			//EMPRESA DE LA LIQUIDACION (EMPRESA DESTINO DE LA MERCADERIA)
			$empresa_id = $this->input->post('empresa_id');
			$ingreso = array(
				'tipo_empresa' => $this->input->post('tipo_empresa'),
				'tipo_impuesto' => $this->input->post('tipo_impuesto'),
				'vehiculo_id' => $this->input->post('vehiculo'),
				'contribuyentes' => $contribuyentes,
				'objetos_transportados' => $this->input->post('objetos_transportados'),
				'dias_permanencia' => $this->input->post('dias_permanencia'),
				'empresa_proveedora' => $this->input->post('empresa_proveedora'),
				'destino_consignado' => $this->input->post('destino_consignado'),
				'senasa' => $this->input->post('senasa'),
				'proc_estanc' => $this->input->post('proc_estanc'),
				'mat_n' => $this->input->post('mat_num'),
				'prec_n' => $this->input->post('prec_num'),
				'transportista_id' => $this->input->post('transportista_id'),
				'fecha' => date('Y-m-d H:i:s')
			);
			
			$this->db->trans_start();
				//Insertamos INGRESO
				$this->db->insert('ingresos',$ingreso);
				$ingreso_id = $this->db->insert_id();

			$this->db->trans_complete();
		}
		redirect('ingresos/nuevoIngreso/'.$ingreso_id);
	}

	//POST
	function paso2()
	{
		
		$responsable_id = $this->input->post('responsable_id');
		$empresa_id = $this->input->post('empresa_id');
		$factura = $this->input->post('factura');
		
		$this->db->trans_start();
			$ingreso_id = $this->input->post('ingreso_id');
			$ingreso_liquidaciones = array(
				'ingreso_id' => $ingreso_id, 
				'empresa_id' => $empresa_id, 
				'nro_factura'=> $factura,
				'responsable_id' => $responsable_id); 
			$this->db->insert('ingresos_liquidaciones',$ingreso_liquidaciones);
			$ingreso_liquidacion_id = $this->db->insert_id();
			
			
			//Si se está cargando un Derecho de piso
			if ($this->input->post('tipo_impuesto')==2) 
			{
				$impuestos_vehiculo = $this->Ingresos_model->getVehiculoIngreso($ingreso_id);

				if ($impuestos_vehiculo[0]->concepto!='') 
				{ #Si trae concepto significa que trae el concepto de la tabla MultiEjes
					if (count($impuestos_vehiculo==2)) 
					{
						# Validamos que traiga un multieje (eje simple y doble)
						
						unset($impuestos_vehiculo[0]->eje_doble);
						unset($impuestos_vehiculo[1]->eje_simple);

						$ingreso_liquidacion_detalle = array(
							        array(
							                'ingreso_liquidacion_id' => $ingreso_liquidacion_id,
							                'impuesto_id' => $impuestos_vehiculo[0]->impuesto_id, 
											'cantidad' => $impuestos_vehiculo[0]->eje_simple,
											'monto_impuesto' => $impuestos_vehiculo[0]->monto,
											'importe' => $impuestos_vehiculo[0]->eje_simple*$impuestos_vehiculo[0]->monto,
											'id_multiejes' => $impuestos_vehiculo[0]->id_multieje
							        ),
							        array(
							                'ingreso_liquidacion_id' => $ingreso_liquidacion_id,
							                'impuesto_id' => $impuestos_vehiculo[1]->impuesto_id,
							                'cantidad' => $impuestos_vehiculo[1]->eje_doble,
							                'monto_impuesto' => $impuestos_vehiculo[1]->monto,
											'importe' => $impuestos_vehiculo[1]->eje_doble*$impuestos_vehiculo[1]->monto,
											'id_multiejes' => $impuestos_vehiculo[1]->id_multieje
							        )
							);
					}else{
						print_r("Verificar error1001");exit();
					}
				}else 
				{	

					if (count($impuestos_vehiculo)==1) 
					{
						#Validamos que sea un solo impuesto
						$ingreso_liquidacion_detalle = array(
							        array(
							                'ingreso_liquidacion_id' => $ingreso_liquidacion_id, 
							                'impuesto_id' => $impuestos_vehiculo[0]->impuesto_id,
											'cantidad' => $impuestos_vehiculo[0]->eje_simple,
											'monto_impuesto' => $impuestos_vehiculo[0]->monto,
											'importe' => $impuestos_vehiculo[0]->eje_simple*$impuestos_vehiculo[0]->monto
							        ));
					}else{
						print_r("Verificar error1002");exit();
					}
				}
				
				$this->db->insert_batch('ingresos_liquidaciones_detalle',$ingreso_liquidacion_detalle);
			}
			else
			{
				//Sp, otra loc, otra prov:
				$tipo_empresa = $this->input->post('tipo_empresa');
				#Ejecutamos un store procedure 
				$this->db->query("CALL sp_detalle_liquidacion_alimenticios($ingreso_liquidacion_id,$tipo_empresa)");
			}
		$this->db->trans_complete();
		redirect('ingresos/nuevoIngreso/'.$ingreso_id);
	}

	function liquidacion_alimenticios($ingreso_id)
	{
		$data['titulo'] = 'Cargar Liquidación';
		$data['tipo_impuesto'] = 'alimenticios';
		$data['liquidaciones'] = $this->Ingresos_model->getLiquidaciones($ingreso_id);
		
		/*Si las liquidaciones son de Unico Responsable
		if ($data['liquidaciones'][0]->contribuyentes=='unico') {
			$ingresos_liquidaciones = array();
			foreach ($data['liquidaciones'] as $liq) {
				$ingresos_liquidaciones[] = $liq->ingreso_liquidacion_id;
			}
			print_r($data['liquidaciones']);exit();
			$ingresos_liquidaciones = implode(",", $ingresos_liquidaciones);

			$data['liquidacion'] = $this->Ingresos_model->getIngresoLiquidacion($ingresos_liquidaciones);
		}*/
		//Impuestos IDs de la carga: Leche, Helado, etc (10,6,...)
		$data['impuestos_cargados']= $this->Ingresos_model->getImpuestosDelIngreso($ingreso_id);
		$data['paso3'] = TRUE;
		
		$data['content'] = '/ingresos/nuevo_ingreso';
		$this->load->view('/includes/template', $data);
	}

	function liquidacion_derecho_piso($ingreso_id)
	{
		$data['titulo'] = 'Liquidación Derecho de Piso';
		$data['liquidaciones'] = $this->Ingresos_model->getILD_derecho_piso($ingreso_id);
		$data['tipo_impuesto'] = 'derecho_piso';
		//$data['impuestos'] = $this->Ingresos_model->getImpuestosDerechoPiso();
		$data['paso3'] = TRUE;
		$data['content'] = '/ingresos/nuevo_ingreso';
		$this->load->view('/includes/template', $data);
	}

	function getDetalleMultiples()
	{
		$liquidacion_id = $this->input->post('liquidacion_id');
		$detalles = $this->Ingresos_model->getIngresoLiquidacion($liquidacion_id);
		$html="";
		foreach ($detalles as $detalle) {
			$html .= "
				<tr>
					<td hidden><input readonly type='hidden' name='detalle_id[]' value='".$detalle->detalle_id."'></td>
					<td>".$detalle->concepto."</td>
					<td><input min=0 name='cantidad[]' step='any' type='number' class='form-control cantidad'></td>
					<td><input placeholder='exento' readonly name='monto[]' value='".$detalle->impuesto."' type='text' class='form-control'></td>
					<td><input readonly name='importe[]' type='text' class='form-control importe'></td>
					<td><a href='javascript:void(0)' class='btn btn-success animation-on-hover btn-sm modalopen' data-toggle='modal' data-target='#myModal'>Añadir items</a></td>
					<td><a href='javascript:void(0)' class='abrirCalcu btn btn-success animation-on-hover btn-sm modalopen' data-toggle='modal' data-target='#calcu'><i class='fas fa-calculator'></i></a></td>
				</tr>
					";
		}
		$html .= "
				<tr><td colspan='2'></td><td>Total</td><td><input readonly id='importe' type='text' class='form-control'></td></tr>
					";
		echo $html;
	}

	
	//SAVE PASO 3: Solo alimenticios ya que D.P no se carga nada
	function updateLiquidacion()
	{

		$detalles = $_POST;
		$ingreso_liquidacion_id = $_POST['liquidacion_id'];	
		$ingreso_id = $_POST['ingreso_id'];

		$batch = array();
			foreach ($detalles['detalle_id'] as $key => $value) 
			{
				$data = array(
					'id' => $this->input->post('detalle_id')[$key],
					'cantidad' => $this->input->post('cantidad')[$key],
					'monto_impuesto' => $this->input->post('monto')[$key],
					'importe' => $this->input->post('importe')[$key],
				);
				$batch[] = $data;
			}
			$this->db->trans_start();
			$this->db->update_batch('ingresos_liquidaciones_detalle', $batch, 'id');

			if ($this->input->post('contribuyentes')=='unico') {
				//Si es responsable unico actualizamos todas las liquidaciones en simultaneo
				$this->db->update('ingresos_liquidaciones',array('completa' => 1), array('ingreso_id' => $ingreso_id));
			}
			else{
				//Si es multiples responsables actualizamos individualmente
				$this->db->update('ingresos_liquidaciones',array('completa' => 1), array('id' => $ingreso_liquidacion_id));	
			}
			//Eliminamos los registros con cantidad 0
			$this->db
					->where('cantidad',0)
					->where('ingreso_liquidacion_id',$ingreso_liquidacion_id)
					->delete('ingresos_liquidaciones_detalle');

			$this->db->trans_complete();
		redirect('ingresos/liquidacion_alimenticios/'.$ingreso_id);
	}

	function eliminarLiquidacion($ingreso_id,$empresa_id)
	{
		$this->Ingresos_model->eliminarLiquidacion($ingreso_id,$empresa_id);
		redirect('ingresos/nuevoIngreso/'.$ingreso_id);
	}

	function eliminarFactura()
	{
		$ingreso_liquidacion_id = $this->input->post('ingreso_liquidacion_id');
		//pasamos {ingreso_liquidacion_id : 10,30,1} a solo 10,30,1
		$ingreso_liquidacion_id = json_decode($ingreso_liquidacion_id)->ingreso_liquidacion_id;
		$this->Ingresos_model->eliminarFactura($ingreso_liquidacion_id); 
	}

	public function buscarProductos()
    {
    	$term = $_GET[ "q" ];
        $productos = $this->Ingresos_model->getProductos($term);
        echo json_encode($productos);
    }

    public function buscarImpuestos()
    {
    	$term = $_GET[ "q" ];
        $tributos = $this->Ingresos_model->buscarImpuestos($term);
        echo json_encode($tributos);
    }

    public function buscarVehiculos()
    {
    	$term = $_GET[ "q" ];
        $vehiculos = $this->Ingresos_model->buscarVehiculos($term);
        echo json_encode($vehiculos);
    }

    public function setNoLiquidable($ingreso_id)
    {
    	$this->db->update('ingresos',array('no_liquidable' => 1), array('id' => $ingreso_id));
    	redirect('ingresos/nuevoIngreso/'.$ingreso_id);
    }

    public function getImpuestoIngreso()
    {
    	$ingreso_id = $_POST['impuesto_id'];
    	$this->Ingresos_model->getImpuesto($ingreso_id);

    }

    public function serverBuscadorAjax()
	{
		$columns = array( 
					0 => 'id',
		          	1 => 'fecha',
		        	2 => 'destinos',
		        	3 => 'dominio',
		        	4 => 'tipo_impuesto',
		        	5 => 'completa',
		        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Ingresos_model->allingresos_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $ingresos = $this->Ingresos_model->allingresos($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $ingresos =  $this->Ingresos_model->ingresos_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Ingresos_model->ingresos_search_count($search);
        }

        $data = array();
        if(!empty($ingresos))
        {
            foreach ($ingresos as $ingreso)
            {
            	$nestedData['id'] = 'No especificado';
            	if ($ingreso->a_ingreso) 
            	{
            		$nestedData['id'] = $ingreso->a_ingreso;
            	}
            	elseif ($ingreso->d_ingreso) 
            	{
            		$nestedData['id'] = $ingreso->d_ingreso;
            	}
                $nestedData['fecha'] = $ingreso->fecha;
                $nestedData['destinos'] = $ingreso->destinos;
                $nestedData['vehiculos'] = $ingreso->dominio;
                if ($ingreso->tipo_impuesto==1) {
                	$nestedData['tipo'] = 'Productos alimenticios';
                	if ($ingreso->completa==2) {
                		$nestedData['tipo'] .= ' (No liquidable)';
                	}
                }else{
                	$nestedData['tipo'] = 'Derecho de piso';
                }
                if ($ingreso->completa==0) 
                {
                	if($ingreso->derecho_id || $ingreso->alimento_id)
                	{
                		$nestedData['accion'] = '<a class="btn btn-sm ml-2" href="'.base_url('ingresos/nuevoIngreso/'.$ingreso->id).'"><i class="far fa-edit"></i> Completar Ingreso</a>';
                	}
                	else
                	{
                		$nestedData['accion'] = '<a class="btn btn-sm btn-danger eliminar" href="'.base_url('ingresos/delete/'.$ingreso->id).'"><i class="far fa-trash-alt"></i> Eliminar</a> <a class="btn btn-sm ml-2" href="'.base_url('ingresos/nuevoIngreso/'.$ingreso->id).'"><i class="far fa-edit"></i> Completar Ingreso</a>';
                	}
                }
                else
                {
                	$nestedData['accion'] = 'Completo <i class="far fa-check-square text-success"></i>';
                }
                #El valor 2 corresponde a ingresos NO liquidables:
                if ($ingreso->derecho_id && $ingreso->completa!=2) 
            	{
            		$nestedData['accion'] .= '<a target="_blank" class="ml-2 btn btn-sm btn-warning" href="'.base_url('comprobante/autorizacionDerechoPiso/'.$ingreso->derecho_id).'"><i class="fas fa-print"></i> Imprimir</a>';
            	}
            	elseif ($ingreso->alimento_id && $ingreso->completa!=2) 
            	{
            		$nestedData['accion'] .= '<a target="_blank" class="ml-2 btn btn-sm btn-warning" href="'.base_url('comprobante/autorizacionAlimentos/'.$ingreso->alimento_id).'"><i class="fas fa-print"></i> Imprimir</a>';
            	}

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	function delete($ingreso_id)
	{
		$this->db->delete('ingresos', array('id' => $ingreso_id));
		redirect('ingresos');
	}

	function ajaxVehiculoUpdate()
	{
		//$vehiculo_id = $this->input->post('id');
		$datos = $this->input->post('datosVehiculo');

		$this->db->where('id', $datos['id']);
		$this->db->update('vehiculos', $datos);
		echo json_encode($datos);	
	}
}