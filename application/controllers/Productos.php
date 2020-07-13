<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Productos extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Productos_model');
	}

	# GET /productos
	function index() {
		$data['titulo'] = 'Productos';
		$data['productos'] = $this->Productos_model->find();
		$data['content'] = '/productos/index';
		$this->load->view('/includes/template', $data);
	}

	public function DatatableAjax()
	{
		$datatables = new Datatables(new CodeigniterAdapter);
        $datatables->query('
        	SELECT empresa,peso,descripcion,codigo,id 
        	FROM productos');
        $datatables->hide('id');
        $datatables->add('action', function ($data) {
		    return '<a class="btn btn-sm btn-info" href="'.base_url('productos/edit/'.$data['id']).'">Editar</a>';
		});
        echo $datatables->generate();
	}

	# GET /productos/create
	function create() {
		$data['titulo'] = 'Nuevo Producto';
		$data['impuestos'] = $this->db->get('impuestos')->result();
		$data['empresas'] = $this->db->get('empresas')->result();
		$data['content'] = '/productos/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /productos/edit/1
	function edit() {
		$data['titulo'] = 'Editar Producto';
		$id = $this->uri->segment(3);
		$data['productos'] = $this->Productos_model->find($id);
		$data['impuestos'] = $this->db->where("tipo",1)->get('impuestos')->result();
		$data['empresas'] = $this->db->get('empresas')->result();
		$data['content'] = '/productos/create';
		$this->load->view('/includes/template', $data);
	}

	# GET /productos/destroy/1
	function destroy() {
		$id = $this->uri->segment(3);	
		$data['productos'] = $this->Productos_model->destroy($id);
		redirect('/productos/index', 'refresh');
	}

	# POST /productos/save
	function save() {
		$this->form_validation->set_rules('codigo', 'Codigo', 'required');
		$this->form_validation->set_rules('peso', 'Peso', 'required');
		$this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		$this->form_validation->set_rules('tipo_impuesto_id', 'Tipo impuesto', 'required');
		$data['impuestos'] = $this->db->where("tipo",1)->get('impuestos')->result();
		$data['empresas'] = $this->db->get('empresas')->result();
		$data['producto'] = $this->Productos_model->find($this->input->post('id', TRUE));
		if ($this->form_validation->run()) 
		{
			$data[] = array();
			$data['id'] = $this->input->post('id', TRUE);
			$data['codigo'] = $this->input->post('codigo', TRUE);
			$data['peso'] = $this->input->post('peso', TRUE);
			$data['descripcion'] = $this->input->post('descripcion', TRUE);
			$data['tipo_impuesto_id'] = $this->input->post('tipo_impuesto_id', TRUE);
			$data['empresa'] = $this->input->post('empresa', TRUE);

			$this->Productos_model->save($data);
			redirect('/productos/index', 'refresh');
		}
		$data['titulo'] = 'Nuevo Producto';
		$data['productos'] = $this->rebuild();
		$data['content'] = '/productos/create';
		$this->load->view('/includes/template', $data);
	}

	function rebuild() {
		$object = new Productos_model();
		$object->id = $this->input->post('id', TRUE);
		$object->codigo = $this->input->post('codigo', TRUE);
		$object->peso = $this->input->post('peso', TRUE);
		$object->descripcion = $this->input->post('descripcion', TRUE);
		$object->tipo_impuesto_id = $this->input->post('tipo_impuesto_id', TRUE);
		$object->empresa = $this->input->post('empresa', TRUE);
		return $object;
	}
}

?>
