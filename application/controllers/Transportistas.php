<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Transportistas Controller.
 */
class Transportistas extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Transportistas_model');
	}

	# GET /transportistas
	function index() {
		$data['titulo'] = "Transportistas";
		$data['transportistas'] = $this->Transportistas_model->find();
		$data['content'] = '/transportistas/index';
		$this->load->view('/includes/template', $data);
	}

	# GET /transportistas/create
	function create() {
		$data['titulo'] = "Nuevo transportista";
		$data['content'] = '/transportistas/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /transportistas/edit/1
	function edit() {
		$id = $this->uri->segment(3);
		$data['titulo'] = "Editar transportista";
		$data['transportistas'] = $this->Transportistas_model->find($id);
		$data['content'] = '/transportistas/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /transportistas/destroy/1
	function destroy() {
		$id = $this->uri->segment(3);
		$data['transportistas'] = $this->Transportistas_model->destroy($id);
		redirect('/transportistas/index', 'refresh');
	}

	# POST /transportistas/save
	function save() {
		
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('tipo_doc', 'Tipo_doc', 'required');
		$this->form_validation->set_rules('documento', 'Documento', 'required');
		$this->form_validation->set_rules('cat_licencia', 'Cat_licencia', 'required');
		$this->form_validation->set_rules('licencia', 'Licencia', 'required');

		if ($this->form_validation->run()) {

			$data[] = array();
			$data['id'] = $this->input->post('id', TRUE);
			$data['nombre'] = $this->input->post('nombre', TRUE);
			$data['tipo_doc'] = $this->input->post('tipo_doc', TRUE);
			$data['documento'] = $this->input->post('documento', TRUE);
			$data['cat_licencia'] = $this->input->post('cat_licencia', TRUE);
			$data['licencia'] = $this->input->post('licencia', TRUE);
			$this->Transportistas_model->save($data);
			redirect('/transportistas/index', 'refresh');
		}
		$data['titulo'] = "Nuevo transportista";
		$data['transportistas'] =	$this->rebuild();
		$data['content'] = '/transportistas/create';
		$this->load->view('/includes/template', $data);
	}

	function rebuild() {
		$object = new Transportistas_model();
		$object->id = $this->input->post('id', TRUE);
		$object->nombre = $this->input->post('nombre', TRUE);
		$object->tipo_doc = $this->input->post('tipo_doc', TRUE);
		$object->documento = $this->input->post('documento', TRUE);
		$object->cat_licencia = $this->input->post('cat_licencia', TRUE);
		$object->licencia = $this->input->post('licencia', TRUE);
		return $object;
	}
}

?>
