<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Example Auth controller using Authme
 *
 * @package Authentication
 * @category Libraries
 * @author Gilbert Pellegrom
 * @link http://dev7studios.com
 * @version 1.0
 */

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
	}
	
	public function index()
	{
		if(!logged_in()) redirect('auth/login');
		$data['usuarios'] = $this->Authme_model->get_users();
		$data['titulo'] = 'Usuarios';
		$data['content'] = '/auth/index';
		$this->load->view('/includes/template', $data);
	}

	public function delete_logico(){
		$user_id = $this->input->post('user_id');
		$this->db->query("
			UPDATE users SET borrado=1 
			WHERE id=$user_id
			");
		echo $user_id;
	}

	public function guardarBody(){
		$clase_body = $this->input->post('body');
		$user = user('id');
		$this->db->query("
			UPDATE users SET body_class='$clase_body' 
			WHERE id=$user
			");
	}

	public function update_user(){
		$user_id = $this->input->post('user_id');
		$postData = array(
			'nombre' => $this->input->post('nombre'),
			'apellido' => $this->input->post('apellido'),
			'dni' => $this->input->post('dni')
		);
		
		if ($this->input->post('password')) {
			$this->authme->reset_password($user_id, $this->input->post('password'));
		}
		$this->Authme_model->update_user($user_id,$postData);
		print_r($this->db->last_query());
	}
	
	/**
	 * Login page
	 */
	public function login()
	{
		// Redirect to your logged in landing page here
		if(logged_in()) redirect('auth/dash');
		 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['error'] = false;
		 
		$this->form_validation->set_rules('dni', 'DNI', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run()){
			if($this->authme->login(set_value('dni'), set_value('password'))){
				// Redirect to your logged in landing page here
				redirect('auth/dash');
			} else {
				$data['error'] = 'El DNI o contraseña es incorrecta.';
			}
		}
		
		$data['content'] = '/auth/login';
		$this->load->view('/includes/template', $data);
	}
	
	/**
	 * Signup page
	 */
	public function signup()
	{
		$data['titulo'] = "Registrar usuario";
		// Redirect to your logged in landing page here
		 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['error'] = '';
		
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellido', 'Apellido', 'required');
		$this->form_validation->set_rules('dni', 'DNI', 'required|is_unique['. $this->config->item('authme_users_table') .'.dni]');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length['. $this->config->item('authme_password_min_length') .']');
		$this->form_validation->set_rules('password_conf', 'Repetir Contraseña', 'required|matches[password]');

		if($this->form_validation->run()){
			if($this->authme->signup(set_value('password'), $this->input->post("nombre"),$this->input->post("apellido"),$this->input->post("dni")))
			{
				$this->session->set_flashdata('ok','Usuario creado exitosamente');
				redirect('auth/signup');
				#$this->authme->login(set_value('email'), set_value('password'));
				#redirect('auth/dash');

			} else {
				$data['error'] = 'Error al registrar usuario.';
			}
		}

		$data['content'] = '/auth/signup';
		$this->load->view('/includes/template', $data);
	}
	
	/**
	 * Logout page
	 */
	public function logout()
	{
		if(!logged_in()) redirect('auth/login');

		// Redirect to your logged out landing page here
		$this->authme->logout('/');
	}
	
	/**
	 * Example dashboard page
	 */
	public function dash()
	{
		if(!logged_in()) redirect('auth/login');
		$data['titulo'] = 'Bienvenido';
		$data['content'] = 'auth/dash';
		$this->load->view('/includes/template', $data);
	}
	
	/**
	 * Forgot password page
	 */
	public function forgot()
	{
		// Redirect to your logged in landing page here
		if(logged_in()) redirect('auth/dash');
		 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['success'] = false;
		 
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_exists');
		
		if($this->form_validation->run()){
			$email = $this->input->post('email');
			$user = $this->Authme_model->get_user_by_email($email);
			$slug = md5($user->id . $user->email . date('Ymd'));

			$this->load->library('email');
			$this->email->from('noreply@example.com', 'Example App'); // Change these details
			$this->email->to($email); 
			$this->email->subject('Restablecer Contraseña');
			$this->email->message('Para restablecer tu contraseña por favor has click en el link de abajo y sigue las instrucciones:
      
'. site_url('auth/reset/'. $user->id .'/'. $slug) .'

Si no solicitaste restablecer tu contraseña solo ignora este email.

Nota: Este código de restablecimiento va a expirar después de '. date('j M Y') .'.');	
			$this->email->send();
			
			$data['success'] = true;
		}

		$data['titulo'] = "Recuperar Contraseña";
		$data['content'] = '/auth/forgot_password';
		$this->load->view('/includes/template', $data);	
	}
	
	/**
	 * CI Form Validation callback that checks a given email exists in the db
	 *
	 * @param string $email the submitted email
	 * @return boolean returns false on error
	 */
	public function email_exists($email)
	{		 
		if($this->Authme_model->get_user_by_email($email)){
			return true;
		} else {
			$this->form_validation->set_message('email_exists', 'We couldn\'t find that email address in our system.');
			return false;
		}
	}
	
	/**
	 * Reset password page
	 */
	public function reset()
	{
		// Redirect to your logged in landing page here
		if(logged_in()) redirect('auth/dash');
		 
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['success'] = false;
		 
		$user_id = $this->uri->segment(3);
		if(!$user_id) show_error('Código de restablecimiento invalido.');
		$hash = $this->uri->segment(4);
		if(!$hash) show_error('Código de restablecimiento invalido.');
		
		$user = $this->Authme_model->get_user($user_id);
		if(!$user) show_error('Código de restablecimiento invalido.');
		$slug = md5($user->id . $user->email . date('Ymd'));
		if($hash != $slug) show_error('Código de restablecimiento invalido.');
	 
		$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length['. $this->config->item('authme_password_min_length') .']');
		$this->form_validation->set_rules('password_conf', 'Repetir Contraseña', 'required|matches[password]');
		
		if($this->form_validation->run()){
			$this->authme->reset_password($user->id, $this->input->post('password'));
			$data['success'] = true;
		}

		$data['titulo'] = "Restablecer Contraseña";
		$data['content'] = '/auth/reset_password';
		$this->load->view('/includes/template', $data);	
	}
	
}