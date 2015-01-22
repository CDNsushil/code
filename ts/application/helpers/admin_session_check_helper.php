<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Function to check session for admin login	
	**/
	if(!function_exists('login_check'))
	{
		function login_check()
		{
			$CI =& get_instance();
			if($CI->session->userdata('session_data'))
			{
				return true;
			}
			else
			{
				redirect('admin');
			}
		}
	}
    /**
	* Function to check session for admin login end	
	**/
?>
