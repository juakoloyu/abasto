<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * empresas Controller.
 */
class Empresas extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	# GET /empresas
	function index() {
		$data['empresas'] = $this->Empresas_model->find();
		$data['titulo'] = 'Empresas';
		$data['content'] = '/empresas/index';
		$this->load->view('/includes/template', $data);
	}

	# GET /empresas/create
	function create() {
		$data['titulo'] = 'Nueva Empresa';
		$data['content'] = '/empresas/create';
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$this->load->view('/includes/template', $data);
	}

	# GET /empresas/edit/1
	function edit() {
		$data['titulo'] = 'Editar Empresa';
		$id = $this->uri->segment(3);
		$data['empresas'] = $this->Empresas_model->find($id);
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$data['content'] = '/empresas/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /empresas/destroy/1
	function destroy() 
	{
		$id = $this->uri->segment(3);
		$data['empresas'] = $this->Empresas_model->destroy($id);
		redirect('/empresas/index', 'refresh');
	}

	# POST /empresas/save
	function save() 
	{
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$this->form_validation->set_rules('razon_social', 'Razon Social', 'required');
		$this->form_validation->set_rules('domicilio', 'Domicilio', 'required');
		$this->form_validation->set_rules('cuit', 'Cuit', 'required');
		$this->form_validation->set_rules('ciudad', 'Ciudad', 'required');
		$this->form_validation->set_rules('provincia', 'Provincia', 'required');
		if ($this->form_validation->run()) {
			$data[] = array();
			$data['id'] = $this->input->post('id', TRUE);
			$data['nombre'] = $this->input->post('razon_social', TRUE);
			$data['domicilio'] = $this->input->post('domicilio', TRUE);
			$data['cuit'] = $this->input->post('cuit', TRUE);
			$data['razon_social'] = $this->input->post('razon_social', TRUE);
			$data['ciudad'] = $this->input->post('ciudad', TRUE);
			$data['propietario'] = $this->input->post('propietario', TRUE);
			$data['provincia'] = $this->input->post('provincia', TRUE);
			$data['telefono'] = $this->input->post('telefono', TRUE);
			$data['email'] = $this->input->post('email', TRUE);
			$data['pagina_web'] = $this->input->post('pagina_web', TRUE);
			$data['gerente'] = $this->input->post('gerente', TRUE);
			$data['encargado'] = $this->input->post('encargado', TRUE);
			$data['sector_impuestos'] = $this->input->post('sector_impuestos', TRUE);
			$this->Empresas_model->save($data);
			redirect('/empresas/index', 'refresh');
		}
		$data['titulo'] = 'Nueva Empresa';
		$data['empresas'] =	$this->rebuild();
		$data['content'] = '/empresas/create';
		$this->load->view('/includes/template', $data);
	}

	function rebuild() 
	{
		$object = new Empresas_model();
		$object->id = $this->input->post('id', TRUE);
		$object->domicilio = $this->input->post('domicilio', TRUE);
		$object->cuit = $this->input->post('cuit', TRUE);
		$object->razon_social = $this->input->post('razon_social', TRUE);
		$object->propietario = $this->input->post('propietario', TRUE);
		$object->ciudad = $this->input->post('ciudad', TRUE);
		$object->provincia = $this->input->post('provincia', TRUE);
		$object->telefono = $this->input->post('telefono', TRUE);
		$object->email = $this->input->post('email', TRUE);
		$object->pagina_web = $this->input->post('pagina_web', TRUE);
		$object->gerente = $this->input->post('gerente', TRUE);
		$object->encargado = $this->input->post('encargado', TRUE);
		$object->sector_impuestos = $this->input->post('sector_impuestos', TRUE);
		return $object;
	}

	function verLiquidaciones() 
	{
		$data['titulo'] = 'Liquidaciones';
		$data['empresas'] = $this->Empresas_model->find($this->uri->segment(3));
		$data['alimentos'] = $this->Empresas_model->alimentos($this->uri->segment(3));
		$data['derecho_piso'] = $this->Empresas_model->derecho_piso($this->uri->segment(3));
		$data['content'] = '/empresas/liquidaciones';
		$this->load->view('/includes/template', $data);
	}

	function verRecibos() 
	{
		$data['titulo'] = 'Recibos';
		$data['recibos'] = $this->Empresas_model->getRecibos($this->uri->segment(3));
		$data['content'] = '/empresas/ver_recibos';
		$this->load->view('/includes/template', $data);
	}

	function generarReciboAlimentos()
	{
		$pass = $this->Authme_model->get_user(user()->id);
		if(md5($this->input->post('pass',TRUE)) == $pass->password)
		{
			$insertar = array();
			$datos = $this->Empresas_model->getDatosAlimentos($this->input->post('recibo',TRUE),$this->input->post('responsable',TRUE));
			$recibo = $this->Empresas_model->getDatosRecibo(1);
			$data['suma'] = array_sum(array_column($datos,'importe'));
			if (empty($recibo)) {
				$numero_recibo = date('y').'0000';
			}
			else
			{
				$numero_recibo = date('y').substr($recibo->numero_recibo,2)+1;
			}
			$cabecera = array(
				'id_ingreso' => $datos[0]->id_ingreso,
				'empresa' => $datos[0]->empresa,
				'id_empresa' => $datos[0]->empresa_id,
				'tipo_impuesto' => $datos[0]->tipo_impuesto,
				'propietario' => $datos[0]->propietario,
				'razon_social' => $datos[0]->razon_social,
				'cuit' => $datos[0]->cuit,
				'telefono' => $datos[0]->telefono,
				'email' => $datos[0]->email,
				'domicilio' => $datos[0]->domicilio,
				'fecha_generacion' => date('Y-m-d'),
				'numero_recibo' => $numero_recibo,
				'total' => ($data['suma']*0.08)+($data['suma'])+20
			);
			$this->db->trans_start();
			$id = $this->Empresas_model->addCabecera($cabecera);
			foreach ($datos as $i => $d) 
			{
				$detalles = array(
					'id_recibo' => $id,
					'id_impuesto' => $d->id_impuesto,
					'nombre' => $d->concepto,
					'unidades' => $d->cantidad,
					'coeficiente' => $d->monto_impuesto,
					'importe' => $d->importe,
				);
				array_push($insertar, $detalles);
			}
			foreach ($this->input->post('recibo',TRUE) as $r) 
			{
				$this->db->update('ingresos_liquidaciones',array('estado_pago' => 'pago'), array('ingreso_id' => $r,'responsable_id' => $this->input->post('responsable',TRUE)));
			}
			if($this->db->insert_batch('recibos_detalles', $insertar))
			{
				echo json_encode(array("result"=>"ok","id"=>$id));
			}
			$this->db->trans_complete();
		}
		else
		{
			echo json_encode(array("error"=>"error"));
		}
	}

	function pagar()
	{
		$pass = $this->Authme_model->get_user(user()->id);
		if(md5($this->input->post('pass',TRUE)) == $pass->password)
		{
			$insertar = array();
			$datos = $this->Empresas_model->getDatosDerecho($this->input->post('id',TRUE));
			$recibo = $this->Empresas_model->getDatosRecibo(2);
			$data['suma'] = array_sum(array_column($datos,'importe'));
			if (empty($recibo)) {
				$numero_recibo = date('y').'0000';
			}
			else{
				$numero_recibo = date('y').substr($recibo->numero_recibo,2)+1;
			}
			$cabecera = array(
				'id_ingreso' => $this->input->post('id',TRUE),
				'empresa' => $datos[0]->empresa,
				'id_empresa' => $datos[0]->empresa_id,
				'tipo_impuesto' => $datos[0]->tipo_impuesto,
				'propietario' => $datos[0]->propietario,
				'razon_social' => $datos[0]->razon_social,
				'cuit' => $datos[0]->cuit,
				'telefono' => $datos[0]->telefono,
				'email' => $datos[0]->email,
				'domicilio' => $datos[0]->domicilio,
				'fecha_generacion' => date('Y-m-d'),
				'numero_recibo' => $numero_recibo,
				'total' => ($data['suma']*0.08)+($data['suma'])+20
			);
			$this->db->trans_start();
			$id = $this->Empresas_model->addCabecera($cabecera);
			foreach ($datos as $i => $d) 
			{
				$detalles = array(
					'id_recibo' => $id,
					'id_impuesto' => $d->id_impuesto,
					'nombre' => $d->concepto,
					'unidades' => $d->cantidad,
					'coeficiente' => $d->monto_impuesto,
					'importe' => $d->importe,
					'id_multieje' => $d->id_multiejes
				);
				array_push($insertar, $detalles);
			}
			if($this->db->insert_batch('recibos_detalles', $insertar))
			{
				echo json_encode(array("result"=>"ok","id"=>$id));
			}
			$this->db->update('ingresos_liquidaciones',array('estado_pago' => 'pago'), array('ingreso_id' => $this->input->post('id',TRUE),'responsable_id' => $this->input->post('responsable',TRUE)));
			$this->db->trans_complete();
		}
		else
		{
			echo json_encode(array("error"=>"error"));
		}
	}
	
}

?>
