<?php
/** This helper  user only for frotend for memberhsip modules 
 * * @author:  Rajendra patidar
 * 	 @Descrip: To create common function for frontend
 * **/
	

	// ------------------------------------------------------------------------ 	
	/*
	 * @descri: get user type (Merchant/Affiliate)
	 * @param: 	void
	 * @return 	userId for merchant or admin
	 * 
	 **/ 
	if(!function_exists('isMerchantUser'))
	{
		
		function isMerchantUser()
		{	$CI =& get_instance();
			if(is_logged_in()){
				$userType=$CI->current_user->group_id;
				if($userType==3){
					return $CI->current_user->id;
				}else{
					
					$CI->session->set_flashdata('error', 'Access denied for unauthorised user.');
					redirect(base_url());
				}
			}
			$CI->session->set_flashdata('error', 'Access denied for unauthorised user.');
			redirect(base_url());
		}
	}
	/*
	 * @descri: get user type (Affiliate/Merchant)
	 * @param: 	void
	 * @return 	userId for affiliate or admin
	 * 
	 **/ 
	 if(!function_exists('isAffiliateUser'))
	{
		
		function isAffiliateUser()
		{	$CI =& get_instance();
			if(is_logged_in()){
				
				$userType=$CI->current_user->group_id;
				if($userType==2){
					return $CI->current_user->id;
				}else{
					
					$CI->session->set_flashdata('error', 'Access denied for unauthorised user.');
					redirect(base_url());
				}
			}
			$CI->session->set_flashdata('error', 'Access denied for unauthorised user.');
			redirect(base_url());
		}
	}
	/*
	 * @description: This function is used to get day listing between two dates
	 * @param1: startDate (date)
	 * @param2: endDate  (date)
	 * @return  arryRange
	 * 
	 **/ 
	if ( ! function_exists('datedaydifference'))
	{
		function datedaydifference($startDate,$endDate)
		{	
			$aryRange=array();

			$iDateFrom=mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
			$iDateTo=mktime(1,0,0,substr($endDate,5,2),  substr($endDate,8,2),substr($endDate,0,4));

			if ($iDateTo>=$iDateFrom)
			{	
				$day=1;
				//array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
				$aryRange[$day]['day'] = $day; // first entry
				$aryRange[$day]['date'] = date('Y-m-d',$iDateFrom); // first entry
				while ($iDateFrom<$iDateTo)
				{ 
					$day++;
					$iDateFrom+=86400; // add 24 hours
					$aryRange[$day]['day'] = $day;
					$aryRange[$day]['date'] = date('Y-m-d',$iDateFrom);
					
				}
			}
			
			return $aryRange;
		}
	}
	
