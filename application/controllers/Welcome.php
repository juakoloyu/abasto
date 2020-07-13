<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!logged_in()) {
			redirect(base_url('auth/login'));
		}
	
	}
	public function index(){
		$data['titulo'] = 'Bienvenido';
		$data['content'] = '/welcome/index';
		$this->load->view('/includes/template', $data);
	}
    
}
