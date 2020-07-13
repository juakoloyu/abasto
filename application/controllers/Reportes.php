<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reportes extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Reportes_model');
	}
	/*
	function index() {
		$data['titulo'] = "Reportes";
		$data['content'] = '/reportes/index';
		$this->load->view('/includes/template', $data);
	}
	*/
	function porFechas() 
	{
		$data['titulo'] = 'Reportes Diarios';
		$data['content'] = '/reportes/por_fechas';
		if($this->input->post())
		{
			$data['pagos'] = $this->Reportes_model->getPagos($this->input->post('desde',TRUE),$this->input->post('hasta',TRUE));
		}
		$this->load->view('/includes/template', $data);
	}

	function deudas() 
	{
		$data['titulo'] = 'Deudas';
		$data['content'] = '/reportes/deudas';
		$data['deudas'] = $this->Reportes_model->getDeudas();
		$this->load->view('/includes/template', $data);
	}

	function deudasEmpresa() 
	{
		$data['titulo'] = 'Deudas por Empresa';
		$data['content'] = '/reportes/deudas_empresas';
		$data['empresas'] = $this->Empresas_model->find();
		$data['error'] = false;
		if($this->input->post())
		{
			$data['deudas'] = $this->Reportes_model->getDeudasEmpresa($this->input->post('empresa',TRUE));
			if(empty($data['deudas']))
			{
				$data['error'] = 'No existen resultados';
			}
		}
		$this->load->view('/includes/template', $data);
	}

	function deudasFechas() 
	{
		$data['titulo'] = 'Deudas por Fechas';
		$data['content'] = '/reportes/deudas_fechas';
		$data['empresas'] = $this->Empresas_model->find();
		$data['error'] = false;
		if($this->input->post())
		{
			$data['deudas'] = $this->Reportes_model->getDeudasFechas($this->input->post('empresa',TRUE),$this->input->post('desde',TRUE),$this->input->post('hasta',TRUE));
			if(empty($data['deudas']))
			{
				$data['error'] = 'No existen resultados';
			}
		}
		$this->load->view('/includes/template', $data);
	}

}