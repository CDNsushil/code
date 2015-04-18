<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Lang_library
 *
 * Authentication library for Code Igniter.
 *
 * @package		Lang_library
 * @author		Ilya Konyukhov (http://konyukhov.com/soft/)
 * @version		1.0.9
 * @based on	DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */
class Lang_library
{
	
function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('admin_model');
		$this->ci->load->library(array('session')); //load session if youre not doing it in autoload
		$this->ci->load->library('auth/PasswordHash',$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
	}
	
	/**
	* Function to check session for admin login	
	**/
	public function login_check(){
		if($this->ci->session->userdata('session_data')){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	* Function for toad_admin login		
	**/
	public function login(){
		if($this->input->post('login')){
			/*----Form validation -----*/
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password','password','trim|required');
			if ($this->form_validation->run() == TRUE){	
				$username = $this->input->post('username');
				$password = $this->input->post('password');

				$login_check = $this->admin_model->login($username,$password);

				if($login_check->num_rows() > 0){
					$dataSet = $login_check->row();
					 
					$sessiondata = array(
						'user_id'  	   => $dataSet->user_id,
						'username'     => $dataSet->username,
						'firstname'    => $dataSet->firstname,
						'lastname'     => $dataSet->lastname,
						'user_role'    => $dataSet->user_role
					);				
					$this->session->set_userdata('session_data', $sessiondata);
				
					//redirect('admin_statistics');
					redirect('language');
				}else{
					$this->session->set_flashdata('message',$this->lang->line('wrong_credential_msg'));
					redirect('toad_admin/toad_admin');
				}
			}else{
				$this->session->set_flashdata('message',$this->lang->line('required_fields'));
				redirect('toad_admin/toad_admin');
			}
		}else{
			$this->load->view('admin/login');
		}
	}
}
