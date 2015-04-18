<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('getMEmembersDetails')){		 
	function getMEmembersDetails($memberId=array()){
		$CI =&get_instance();
		$CI->load->model('model_Collaboration');
		$res =  $CI->model_Collaboration->getMEmembersDetails($memberId);
		return $res;
	}
}

if ( ! function_exists('checkCollabAccess')){		 
	function checkCollabAccess($givenAecees=array(), $findAccess=''){
		$return = false;
		if(is_array($givenAecees) && !empty($findAccess)){
			
			if(in_array('all',$givenAecees) || in_arrayr($findAccess,$givenAecees)){
				$return = true;
			}
		}
		
		return $return;
	}
}
