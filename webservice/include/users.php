<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
class users extends UserClass
{
	public $name			  = "";
	public $age				  = "";
	public $address 		  = "";
	public $status  		  = "";
	public $_tbPrefix 	  = 'cc';
	public $month_count    = 0;
	public $week_count     = 0;
	public $today_count    = 0;
	public $getInfoQuery   = " WHERE "; 
	public $current_year   = "";
	public $current_month  = "";
	public $statics_obj 	  = "";

	/**
  * @method __construct
  * @see private constructor to protect beign inherited
  * @access private
  * @return void
  */
  public function __construct()
  {
    	/// -- Create Database Connection instance --
			$this->_dbRef=env::getInst();
			// $this->statics_obj = new StaticsClass(); 
  }
	
	
			/*
			* Service : Get Total No of Services Details [Main]
			* @method: getTotalServicesDetail()
			* @param: type: "string"
			* @reutrn: Array
			*/
			function getTotalServicesDetail($token='')
			{
				// First need to check token value
				$service_token = $this->checkServiceToken($token);

				if ($service_token==1) 
				{ 
					$result_arr   = array();
					$final_result = array();
					$result 	  = $this->getTotalServicesDetailHelper();
					if (!$result) 
					{
						$result_val['response_code']  = 1;
						$result_val['response_msg']   = 'Fail';
						return $result_val;
					} 
						$result_arr['response_code']   = 0;
						$result_arr['response_msg']    = 'success';
						$result_arr['response_result'] = $result;
						$final_result = $result_arr;
						return $final_result;
				 } else {
					$result_arr['response_code']   = 1;
					$result_arr['response_msg']    = 'Fail';
					$result_arr['response_result'] = 'Token need';
					$final_result = $result_arr;
					return $final_result;
				 }
	 		}		
			
			
			/*
			* Service : Main service to get details of each swervice [Main]
			* @method: getServicesDetail()
			* @param: type: "integer" ($service_id)
			* @reutrn: Array
			*/
			function getServicesDetail($token, $service_id = '', $year = '', $month = '',$day = '', $country_id = '')
			{
				
				$result_arr   = array();
				$final_result = array();
				/// -- Get User Helper Class --
				
				// First need to check token value
			// First need to check token value
				$service_token = $this->checkServiceToken($token);

				if ($service_token==1) 
				{ 
					$result = $this->getServicesDetailHelper($service_id, $year, $month, $day, $country_id);
					if (!$result) 
					{
						$result_val['response_msg'] = 'Fail';
						$result_val['response_code']   = 1;
						return $result_val;
					} 
						$result_arr['response_code']   = 0;
						$result_arr['response_msg']    = 'success';
						$result_arr['response_result'] = $result;
						$final_result = $result_arr;
						return $final_result;
				} else {
					$result_arr['response_code']   = 1;
					$result_arr['response_msg']    = 'Fail';
					$result_arr['response_result'] = 'Token need';
					$final_result = $result_arr;
					return $final_result;

				}
			}
			
			/*
			* Service : Main service to get details of each swervice [Main]
			* @method: getServicesDetail()
			* @param: type: "integer" ($service_id)
			* @reutrn: Array
			*/
			function getServicesStatics($token, $service_id = '', $year = '', $month = '')
			{
				
				$result_arr   = array();
				$final_result = array();
				
			// First need to check token value
				$service_token = $this->checkServiceToken($token);

				if ($service_token == 1)
		      {
					$result = StaticsClass::getServicesStatics($service_id, $year, $month);
					if (!$result) 
					{
						$result_val['response_msg']    = 'Fail';
						$result_val['response_code']   = 1;
						return $result_val;
					} 
						$result_arr['response_code']   = 0;
						$result_arr['response_msg']    = 'success';
						$result_arr['response_result'] = $result;
						$final_result = $result_arr;
						return $final_result;
				} else {
					$result_arr['response_code']      = 1;
					$result_arr['response_msg']       = 'Fail';
					$result_arr['response_result']    = 'Token need';
					$final_result = $result_arr;
					return $final_result;
				}
			}


			/*
			* Service : Authentication key
			* @method: getAuthToken()
			* @param: auth_key: "integer" 
			* @Return: Boolean
			*/
			function getAuthToken($auth_key = '')
			{
				/// -- Get User Helper Class --
				$result = $this->getAuthTokenHelper($auth_key);
				if (!$result) {
					$result_val['response_code']  = 1;
					$result_val['response_msg']   = 'Fail';
					return $result_val;
				} 
					if($result['token'] == 'Unauthorized Authentication key') {
						$result_arr['response_code']   = 1;
						$result_arr['response_msg']    = 'Fail';
					} else { 
						$result_arr['response_code']   = 0;
						$result_arr['response_msg']    = 'success';
					}
					$result_arr['response_result'] = $result;
					$final_result = $result_arr;
					return $final_result; 
			}

			/*
			* Service : Authentication logout 
			* @method: authLogout()
			* @param: auth_key: "integer" 
			* @Return: Boolean
			*/
			function authLogout($token='')
			{
				/// -- Get User Helper Class --
				$result = $this->authLogoutHelper($token);
				if (!$result) {
					$result_val['response_code']  = 1;
					$result_val['response_msg']   = 'Fail';
					return $result_val;
				} 
					if($result['token'] == 'Unauthorized Authentication key') {
						$result_arr['response_code']   = 1;
						$result_arr['response_msg']    = 'Fail';
					} else { 
						$result_arr['response_code']   = 0;
						$result_arr['response_msg']    = 'success';
					}
					$result_arr['response_result'] = $result;
					$final_result = $result_arr;
					return $final_result;
			}
			
		
		function getServicesDetailInfo($token='', $service_id='',$year='', $month='',  $day='', $country_id='') 
		{
			
			// First need to check token value
			// First need to check token value
				$service_token = $this->checkServiceToken($token);

				if ($service_token==1) 
				{  
								
				$result_arr   = array();
				$final_result = array();
				/// -- Get User Helper Class --

				$result = $this->getServicesDetailInfoHelper($service_id, $year, $month, $day, $country_id);
				if (!$result) 
				{
					$result_val['response_msg'] = 'Fail';
					$result_val['response_code']   = 1;
					return $result_val;
				} 
					$result_arr['response_code']   = 0;
					$result_arr['response_msg']    = 'success';
			
					if(count($result[0]) > 1 ) {  
						$result_arr['column_count'] = count($result[0]);
					} else { 
						$result_arr['column_count'] = 0;
					}	
					
					$result_arr['response_result'] = $result;
					$final_result = $result_arr;
					return $final_result;
			} else {
					$result_arr['response_code']   = 1;
					$result_arr['response_msg']    = 'Fail';
					$result_arr['response_result'] = 'Token need';
					$final_result = $result_arr;
					return $final_result;
			}
		}
	
	function get_server_info($password)
	{
		if($password=='987654@123') { 
		$result = $this->get_server_info_Helper();
		if($result)	{
				$result_arr['response_result'] = $result;
				$final_result = $result_arr;
				return $final_result;
		}
		} else {
					$result_arr['response_code']   = 1;
					$result_arr['response_msg']    = 'Fail';
					$result_arr['response_result'] = 'Token need';
					$final_result = $result_arr;
					return $final_result;
		}
	}		
}

?>
