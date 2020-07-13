<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Vehiculos Controller.
 */
class Vehiculos extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Vehiculos_model');
	}

	# GET /vehiculos
	function index() {
		$data['vehiculos'] = $this->Vehiculos_model->find();
		$data['content'] = '/vehiculos/index';
		$data['titulo'] = "Vehiculos";
		$this->load->view('/includes/template', $data);
	}

	# GET /vehiculos/create
	function create() {
		$data['titulo'] = "Nuevo Vehículo";
		$data['tipo_vehiculo'] = $this->Vehiculos_model->getTipoVehiculo();
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$data['content'] = '/vehiculos/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /vehiculos/edit/1
	function edit() {
		$id = $this->uri->segment(3);
		$data['titulo'] = "Editar Vehículo";
		$data['vehiculos'] = $this->Vehiculos_model->find($id);
		$data['tipo_vehiculo'] = $this->Vehiculos_model->getTipoVehiculo();
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$data['content'] = '/vehiculos/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /vehiculos/destroy/1
	function destroy() {
		$id = $this->uri->segment(3);
		$data['vehiculos'] = $this->Vehiculos_model->destroy($id);
		redirect('/vehiculos/index', 'refresh');
	}

	# POST /vehiculos/save
	function save() 
	{
		$this->form_validation->set_rules('dominio', 'Dominio', 'required');
		$this->form_validation->set_rules('titular', 'Titular', 'required');
		$this->form_validation->set_rules('marca', 'Marca', 'required');
		$this->form_validation->set_rules('tipo', 'Tipo', 'required');
		$this->form_validation->set_rules('modelo', 'Modelo', 'required');
		$this->form_validation->set_rules('tipo_documento', 'Tipo de Documento', 'required');
		$this->form_validation->set_rules('nro_documento', 'Numero de documento', 'required');
		$this->form_validation->set_rules('domicilio', 'Domicilio', 'required');
		$this->form_validation->set_rules('localidad', 'Localidad', 'required');
		$this->form_validation->set_rules('provincia', 'Provincia', 'required');
		$this->form_validation->set_rules('tipo_vehiculo', 'Tipo de Vehiculo', 'required');
		//$this->form_validation->set_rules('eje_simple', 'Cantidad de ejes simples', 'required');
		//$this->form_validation->set_rules('eje_doble', 'Cantidad de ejes dobles', 'required');
		if ($this->form_validation->run()) 
		{
			$data[] = array();
			$data['id'] = $this->input->post('id', TRUE);
			$data['dominio'] = $this->input->post('dominio', TRUE);
			$data['titular'] = $this->input->post('titular', TRUE);
			$data['marca'] = $this->input->post('marca', TRUE);
			$data['tipo'] = $this->input->post('tipo', TRUE);
			$data['modelo'] = $this->input->post('modelo', TRUE);
			$data['tipo_documento'] = $this->input->post('tipo_documento', TRUE);
			$data['nro_documento'] = $this->input->post('nro_documento', TRUE);
			$data['domicilio'] = $this->input->post('domicilio', TRUE);
			$data['localidad'] = $this->input->post('localidad', TRUE);
			$data['provincia'] = $this->input->post('provincia', TRUE);
			$data['tipo_vehiculo'] = $this->input->post('tipo_vehiculo', TRUE);
			$data['eje_simple'] = $this->input->post('eje_simple', TRUE);
			$data['eje_doble'] = $this->input->post('eje_doble', TRUE);
			$data['frio'] = $this->input->post('frio', TRUE);
			$this->Vehiculos_model->save($data);
			redirect('/vehiculos/index', 'refresh');
		}
		$data['titulo'] = "Nuevo Vehiculo";
		$data['vehiculos'] = $this->rebuild();
		$data['tipo_vehiculo'] = $this->Vehiculos_model->getTipoVehiculo();
		$data['provincias'] = $this->Vehiculos_model->getProvincia();
		$data['content'] = '/vehiculos/create';
		$this->load->view('/includes/template', $data);
	}

	function rebuild() {
		$object = new Vehiculos_model();
		$object->id = $this->input->post('id', TRUE);
		$object->dominio = $this->input->post('dominio', TRUE);
		$object->titular = $this->input->post('titular', TRUE);
		$object->marca = $this->input->post('marca', TRUE);
		$object->tipo = $this->input->post('tipo', TRUE);
		$object->modelo = $this->input->post('modelo', TRUE);
		$object->tipo_documento = $this->input->post('tipo_documento', TRUE);
		$object->nro_documento = $this->input->post('nro_documento', TRUE);
		$object->domicilio = $this->input->post('domicilio', TRUE);
		$object->localidad = $this->input->post('localidad', TRUE);
		$object->provincia = $this->input->post('provincia', TRUE);
		$object->tipo_vehiculo = $this->input->post('tipo_vehiculo', TRUE);
		$object->eje_simple = $this->input->post('eje_simple', TRUE);
		$object->eje_doble = $this->input->post('eje_doble', TRUE);
		$object->frio = $this->input->post('frio', TRUE);
		return $object;
	}
}

?>
