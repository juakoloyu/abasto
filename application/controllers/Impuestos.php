<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Impuestos Controller.
 */
class Impuestos extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Impuestos_model');
	}

	# GET /impuestos
	function index() {
		$data['titulo'] = "Impuestos";
		$data['impuestos'] = $this->Impuestos_model->find();
		$data['content'] = '/impuestos/index';
		$this->load->view('/includes/template', $data);
	}

	# GET /impuestos/create
	/*
	function create() {
		$data['content'] = '/impuestos/create';
		$this->load->view('/includes/template', $data);
	}
	*/

	# GET /impuestos/edit/1
	function edit() {
		$data['titulo'] = "Editar impuesto";
		$id = $this->uri->segment(3);
		$data['impuestos'] = $this->Impuestos_model->find($id);
		$data['content'] = '/impuestos/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /impuestos/destroy/1
	/*
	function destroy() {
		$id = $this->uri->segment(3);
		$data['impuestos'] = $this->Impuestos_model->destroy($id);
		redirect('/impuestos/index', 'refresh');
	}
	*/

	# POST /impuestos/save
	function save() {
		$data['titulo'] = "Editar impuesto";
		$this->form_validation->set_rules('concepto', 'Concepto', 'required');
		$this->form_validation->set_rules('sp', 'Sp', 'required');
		$this->form_validation->set_rules('otro_municipio', 'Otro_municipio', 'required');
		$this->form_validation->set_rules('otra_provincia', 'Otra_provincia', 'required');
		$this->form_validation->set_rules('tipo', 'Tipo', 'required');

		if ($this->form_validation->run()) {

			$data[] = array();
			$data['id'] = $this->input->post('id', TRUE);
			$data['concepto'] = $this->input->post('concepto', TRUE);
			$data['sp'] = $this->input->post('sp', TRUE);
			$data['otro_municipio'] = $this->input->post('otro_municipio', TRUE);
			$data['otra_provincia'] = $this->input->post('otra_provincia', TRUE);
			$data['tipo'] = $this->input->post('tipo', TRUE);
			$this->Impuestos_model->save($data);
			redirect('/impuestos/index', 'refresh');
		}
		$data['impuestos'] =	$this->rebuild();
		$data['content'] = '/impuestos/create';
		$this->load->view('/includes/template', $data);
	}

	function rebuild() {
		$object = new Impuestos_model();
		$object->id = $this->input->post('id', TRUE);
		$object->concepto = $this->input->post('concepto', TRUE);
		$object->sp = $this->input->post('sp', TRUE);
		$object->otro_municipio = $this->input->post('otro_municipio', TRUE);
		$object->otra_provincia = $this->input->post('otra_provincia', TRUE);
		$object->tipo = $this->input->post('tipo', TRUE);
		return $object;
	}
}

?>
