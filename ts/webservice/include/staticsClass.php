<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
class StaticsClass
{
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
   }
		
		// Comman function for get data statics
		public function getDataStatics($year, $month, $table_name, $field_name, $conditon='')
		{
			$today_date = "";
			$result = array();
			$count = 1;
				
			if(!$year) { $year = date("Y"); }
			if(!$month) { $month = date("m"); }

			// Store log 
			log_message("debug","getDataStatics() :: Variables :: Year=>".$year." month=>".$month." Week=>".$week);
	
			$this->getInfoQuery = "WHERE YEAR( ".$field_name." ) = ".$year." AND MONTH( ".$field_name." ) = ".$month;
			$this->getInfoQuery .= $conditon." group by DAY(".$field_name.")";
			$QueryExe = "SELECT ".$field_name.",count(".$field_name.") as num FROM ".$table_name." ".$this->getInfoQuery;
			
		
			$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					
			$number_of_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); 

			while ($row = $this->_dbRef->my_fetch_object($req)) {
							$date_string = strtotime($row->$field_name);
							$date_count  =  date("d",$date_string);
							$result_count[$date_count] 	 = $date_count;;
							$result_day_count[$date_count] = $row->num;
				} // End while loop
				
			if(count($result_count) > 0 ) {
				for($i=1; $i<=$number_of_day; $i++) 
				{
					if($i < 10) { 	$i = "0".$i; }
						if (@in_array($i, $result_count)) {
								 $result['day'][] = $i.",".$result_day_count[$i];
						} else {
							 $result['day'][] = $i.",0";
						}
				}
			}
			return $result;
			}

			public function getServicesStatics($service_id, $year, $month)
			{
				switch ($service_id) {
					// IF want to get Registered Memebers Total - Today.
					case 1: 
						/// -- Get User Statics Class --
						$table_name = 'cc_user'; 
						$field_name = 'created_at';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $conditon='');
						return $result;
					break;
						
					//IF want to get Registered offering Total - Today.
					case 2: 
						/// -- Get User Statics Class --
						$table_name = 'cc_user'; 
						$field_name = 'created_at';
						$condtion = ' AND parent_id !=0';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion);
						return $result;
					break;
						
					//IF want to get Invitation sent Today.
					case 3: 
						/// -- Get User Statics Class --
						$table_name = 'cc_incentive_request'; 
						$field_name = 'requested_date';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion='');
						return $result;
					break;
						
					//IF want to get Invitation pending Today.
					case 4: 
						/// -- Get User Statics Class --
						$table_name = 'cc_friends'; 
						$field_name = 'created_at';
						$condtion = ' AND status = 0';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion);
							return $result;
					break;
						
					//IF want to get Points Awarded Total.
					case 5: 
						/// -- Get User Statics Class --
						$table_name = 'cc_point'; 
						$field_name = 'datetime';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion='');
						 return $result;
					break;
						
					//IF want to get Photos Uploaded Total - Today.
					case 6: 
						/// -- Get User Statics Class --
						$table_name = 'cc_media'; 
						$field_name = 'media_created_at';
						$condtion = ' AND media_type = 1';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion);
						 return $result;
					break;
						
					//IF want to get Total Emails Sent - Today.
					case 7: 
						/// -- Get User Statics Class --
						$table_name = 'cc_email_log'; 
						$field_name = 'created_at';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion='');
						return $result;
					break;
						
					//IF want to get Total page load  - Today.
					case 8: 
						/// -- Get User Statics Class --
						$table_name = 'cc_page_load'; 
						$field_name = 'created_at';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion='');
						return $result;
					break;

					//IF want to get Total page load  - Today.
					case 9: 
						/// -- Get User Statics Class --
						/// -- Get User Statics Class --
						$table_name = 'cc_statistics_s3_images'; 
						$field_name = 'created_at';
						$result = StaticsClass::getDataStatics($year, $month, $table_name, $field_name, $condtion='');
						return $result;
					break;

					// This is a default condition for monthly data 
					default:
						$result_val['response_code'] = 1;
						$result_val['response_msg']  = 'Please put service id.';
						return $result_val;
					break;
					}
			}
			
		
		
	

	public function getServicesDetailInfoStatics($service_id,$type,$country_id)
	{
		switch($service_id)
		{
			case "1":
					$result = $this->getUserInfoStatics($type,$country_id);
					return $result;
			break;
			
			case "2":
					$result = $this->getUserOfferInfoStatics($type,$country_id);
					return $result;
			break;
			
			case "3":
					$result = $this->invtationSendInfoStatics($type);
					return $result;
			break;
			
			case "4":
					$result = $this->invtationUserPendingInfoStatics($type);
					return $result;
			break;
			
			case "5":
					$result = $this->pointsAwardedTotalStaticsinfoStatics($type);
					return $result;
			break;
			
			case "6":
					$result = $this->getPhotoUploadedInfoStatics($type, $country_id);
					return $result;
			break;

			case "7":
					$result = $this->getEmailCountInfoStatics($type);
					return $result;
			break;

			case "8":
					$result = $this->pageloadInfoStatics($type);
					return $result;
			break;
			
			case "9":
					$result = $this->photoLoadInfoStatics($type);
					return $result;
			break;

			case "10":
					$result = $this->getUserInfoStaticsPerDay($type,$country_id);
					return $result;
			break;

			default:
			break;
		}
	}
	
	/**
	* Service for check token into database
	* @param token
	* Return boolean
	*/
	public function checkServiceToken($token)
	{
			if($token) { 
				$QueryExe = "SELECT * FROM cc_auth_token where token='".$token."'";
					// Execute query
				$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					if ($this->_dbRef->my_num_rows($req) > 0)	{
						return 1;
					}	else {	return 0;	}
					} else { return 0; } 
	 }					
				
}
?>
