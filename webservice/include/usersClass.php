<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
class UserClass 
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
   }
	
	
			// Function for get user information by type [ today / week / month ]
				public function getUserInfoHelperPerDay($type , $country)
				{
					$today_date      	 = date("Y-m-d"); 	// Current date
					$this->current_year  = date("Y"); 		// Current Year
					$this->current_month = date("m"); 		// Current Month
					
					// Execute Switch for different type case { today , week , month }
					switch ($type)  {
						case 'today':
							$this->getInfoQuery .= " DATE(user.created_at)='".$today_date."'";			
						break;

						case 'week':
							$ts	   	= strtotime($today_date);
							$start 		= strtotime('sunday this week -1 week', $ts);
							$end   		= strtotime('sunday this week', $ts);
							$start_day  = date('Y-m-d', $start);
							$end_day    = date('Y-m-d', $end);

							$this->getInfoQuery .= "YEAR( user.created_at ) = ".$this->current_year." AND MONTH( user.created_at ) = ".$this->current_month;
							$this->getInfoQuery .=" AND DATE(user.created_at) >= '".$start_day."' AND DATE(user.created_at) <='".$end_day."'";
						break;
						
						default:
							$this->getInfoQuery .= "YEAR( user.created_at ) = ".$this->current_year." AND MONTH( user.created_at ) = ".$this->current_month;
						break;
					}
				
					// If country paramter not blank set 
					if ($country!='') {
						$this->getInfoQuery .=" AND profile.user_id = user.user_id AND profile.country_id=".$country;
						$QueryExe = "SELECT firstname,lastname,created_at FROM cc_user as user,cc_user_profile as profile".$this->getInfoQuery;
					} else {
						$QueryExe = "SELECT user.firstname,user.lastname,user.created_at FROM cc_user as user".$this->getInfoQuery;
					}
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
	

						while ($row = $this->_dbRef->my_fetch_object($req)) {
							$result['Full_Name'] = $row->firstname." ".$row->lastname;
							$result['Registration_Date'] = date('d-m-y',strtotime($row->created_at));
							$result2[] = $result;
						}
						
						if(count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
				}

			// Function for get user information by type [ today / week / month ]
				public function getUserInfoHelper($year, $month, $day, $country_id)
				{
				
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
			
				// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}
					
					$this->getInfoQuery .= "YEAR( user.created_at ) = ".$year." AND MONTH( user.created_at ) = ".$month;
					// If country paramter not blank set 
					if ($country_id!='') {
						$this->getInfoQuery .=" AND profile.user_id = user.user_id AND profile.country_id=".$country_id;
						$QueryExe = "SELECT firstname,lastname,created_at FROM cc_user as user,cc_user_profile as profile".$this->getInfoQuery;
					} else {
						$QueryExe = "SELECT user.firstname,user.lastname,user.created_at FROM cc_user as user".$this->getInfoQuery;
					}
					$QueryExe = $QueryExe." ORDER BY created_at asc";
						
					
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
				 	
						if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							

						while ($row = $this->_dbRef->my_fetch_object($req)) {
							if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
												$result['Full_Name'] = $row->firstname." ".$row->lastname;
												$result['Registration_Date'] = date('d-m-y',strtotime($row->created_at));
												$result2[] = $result;
								 		}	
									}
								} else {
												$result['Full_Name'] = $row->firstname." ".$row->lastname;
												$result['Registration_Date'] = date('d-m-y',strtotime($row->created_at));
												$result2[] = $result;
								}			
						}
						
						if(count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
				}
				
				
				
			public function getUserPointCountHelper($year, $month, $week) 
			{
					$today_date      	 = date("Y-m-d"); 	// Current date
					$this->current_year  = date("Y"); 		// Current Year
					$this->current_month = date("m"); 		// Current Month
					$result_array 		 = array();

					if ($year == null) 	{ 
						// Get Ragister member info which ragister current month , week and today
							$this->getInfoQuery .= "YEAR( datetime ) = ".$this->current_year." AND MONTH( datetime ) = ".$this->current_month;
					}
					
					// Will be use for extend year , month and week variable
			 		$QueryExe = "SELECT datetime,point FROM cc_point".$this->getInfoQuery;
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");

					if ($this->_dbRef->my_num_rows($req) > 0)
					{
							$ts	   	= strtotime($today_date);
							$start 		= strtotime('sunday this week -1 week', $ts);
							$end   		= strtotime('sunday this week', $ts);
							$start_day  = date('Y-m-d', $start);
							$end_day    = date('Y-m-d', $end);

						while ($row = $this->_dbRef->my_fetch_object($req)) {
						//Count number of register user today
							 if ($today_date) {
								 if ($today_date == date("Y-m-d",strtotime($row->datetime))) {
									 $this->today_count = $this->today_count + $row->point; 
								 }
							 }
							
							// Count number of register user current week
							if ($today_date) {
								$week_day = date("Y-m-d",strtotime($row->datetime));
								if ($week_day >= $start_day && $week_day <= $end_day) {
									$this->week_count = $this->week_count + $row->point;
								}
							} 
						//Count number of register user current month
							$this->month_count = $this->month_count + $row->point; 
						} // End while loop
						
						$result_array['point_award_month'] = round($this->month_count);
						$result_array['point_award_week']  = round($this->week_count);
						$result_array['point_award_today'] = round($this->today_count);

						return $result_array;
						
					} else {
						return false;
					}
					
			}
			
			/**
			 * Get Userinfo for point according by type
			 * @Param $type ( string )
			 * Return Array
			 * */
			public function getUserPointInfoHelper($type,$country)
			{
					$today_date     	 = date("Y-m-d"); 	// Current date
					$this->current_year  = date("Y"); 		// Current Year
					$this->current_month = date("m");		// Current Month
					
					switch ($type) {
						// IF want to get today data 
						case 'today': 
							$this->getInfoQuery .= " DATE(datetime)='".$today_date."'";			
						break;

						// IF want to get Weekly data 
						case 'week':
							$ts	   		= strtotime($today_date);
							$start 		= strtotime('sunday this week -1 week', $ts);
							$end   		= strtotime('sunday this week', $ts);
							$start_day  = date('Y-m-d', $start);
							$end_day 	= date('Y-m-d', $end);
							$this->getInfoQuery .= "YEAR( datetime ) = ".$this->current_year." AND MONTH( datetime ) = ".$this->current_month;
							$this->getInfoQuery .=" AND DATE( datetime) >= '".$start_day."' AND DATE( datetime) <='".$end_day."'";
						break;

						// This is a default condition for monthly data 
						default:
							$this->getInfoQuery .= "YEAR( datetime ) = ".$this->current_year." AND MONTH( datetime ) = ".$this->current_month;
						break;
					}
				
					$this->getInfoQuery.= " And point_tab.user_id = user.user_id GROUP BY point_tab.user_id ";

					// If country id not blank set 
					if ($country != "") 
					{
						$this->getInfoQuery .=" AND profile.user_id = user.user_id AND profile.country_id=".$country;
						$QueryExe = "SELECT user.firstname,user.lastname,sum(point_tab.point) as total_point 
									 FROM cc_user as user,cc_point as point_tab,cc_user_profile as profile".$this->getInfoQuery;
					} else { 
						$QueryExe = "SELECT user.firstname,user.lastname,sum(point_tab.point) as total_point 
								 FROM cc_user as user,cc_point as point_tab".$this->getInfoQuery;
					}
					
					// Execute query
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					if ($this->_dbRef->my_num_rows($req) > 0)
					{
						while ($row = $this->_dbRef->my_fetch_object($req))	{
							$result['firstname'] 	= $row->firstname;
							$result['lastname']  	= $row->lastname;
							$result['total_point']  = round($row->total_point);
							$result2[] = $result; // Create Array for store user information data
						} // End while loop

						if (count($result2) > 0 ) {
							return $result2;
						} else { return "No Record"; }
						
					} else {
						return false;
					}
					
			}

	
		
		
		/* Service Invitation Sent Today [Sub] 
		 * Function for Get user information for email send
		 */
		 public function invtationSendInfoHelper($year, $month, $day)
		 {
	
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}
					
					$this->getInfoQuery .= "YEAR( requested_date ) = ".$year." AND MONTH( requested_date ) = ".$month;
					$QueryExe = "SELECT requested_date,email_to FROM cc_incentive_request".$this->getInfoQuery;
			
								 
					// Execute query
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
	
					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							
							
					while ($row = $this->_dbRef->my_fetch_object($req))	{
								if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->requested_date))) {
												$result['Email_ID'] 	   = $row->email_to;
												$result['Invitation_Date'] = date('d-m-y',strtotime($row->requested_date));
												$result2[] = $result;
								 		}	
									}
								} else {
										$result['Email_ID'] 	   = $row->email_to;
										$result['Invitation_Date'] = date('d-m-y',strtotime($row->requested_date));
										$result2[] = $result;
								}								
					} // End while loop
					
					if(count($result2) > 0 ) {
						return $result2;
					} else {
						return "No Record";
					}
		}
		 
		
		 
		 public function getUserOfferInfoHelper($year, $month, $day, $country_id )
		 {
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
				//	 If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}
					
						$this->getInfoQuery .= "YEAR( user.created_at ) = ".$year." AND MONTH( user.created_at ) = ".$month;
		          	$this->getInfoQuery .=" AND parent_id !=0";

					// If country paramter not blank set 
					if ($country_id!='') {
						$this->getInfoQuery .=" AND profile.user_id = user.user_id AND profile.country_id=".$country_id;
						$QueryExe = "SELECT firstname,lastname,created_at FROM cc_user as user,cc_user_profile as profile".$this->getInfoQuery;
					} else {
						$QueryExe = "SELECT user.firstname,user.lastname,user.created_at FROM cc_user as user".$this->getInfoQuery;
					}
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					
					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
					}
							
							
						while ($row = $this->_dbRef->my_fetch_object($req))
						{
								if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
												$result['Full_Name'] = $row->firstname." ".$row->lastname;
												$result['Registration_Date'] = date('d-m-y',strtotime($row->created_at));
												$result2[] = $result;
								 		}	
									}
								} else {
												$result['Full_Name'] = $row->firstname." ".$row->lastname;
												$result['Registration_Date'] = date('d-m-y',strtotime($row->created_at));
												$result2[] = $result;
								}		
						}
						
						if(count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
						
					
		 }
		 
	

		/*
		* Service : Total Emails Sent - Today [sub]
		* @method: getUserOfferCount($type,$country)
		* @param: type: "string"
		* @param: Country: "integer"
		* @reutrn: Array
		*/
		public function getEmailCountInfoHelper($year, $month, $day)
		{

					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}

				$this->getInfoQuery .= "YEAR( created_at ) = ".$year." AND MONTH( created_at ) = ".$month;
				
				$QueryExe = "SELECT * FROM cc_email_log".$this->getInfoQuery;
				$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
				
					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							
							
					while ($row = $this->_dbRef->my_fetch_object($req))	{

							if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
												$result['Email_ID'] 			  = $row->from;
												$result['Sent_Date_Time']  = $row->created_at;
												$result2[] = $result;
								 		}	
									}
								} else {
										$result['Email_ID'] 			  = $row->from;
										$result['Sent_Date_Time']  = $row->created_at;
										$result2[] = $result;
								}
								
					} // End while loop
					
					if(count($result2) > 0 ) {
						return $result2;
					} else {
						return "No Record";
					} 
		}
		
			/* 
			 * Service Invitation Pending Today [Sub]  B
			 * Function for Get user information for email send
			 */
			 public function invtationUserPendingInfoHelper($year, $month, $day)
			 {
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}

					$this->getInfoQuery .= "YEAR( cc_friends.created_at ) = ".$year." AND MONTH( cc_friends.created_at ) = ".$month;
					$QueryExe = "SELECT cc_friends.created_at, cc_friends.to_user_id, cc_user.email FROM cc_friends
								LEFT JOIN cc_user on cc_friends.to_user_id = cc_user.user_id ".$this->getInfoQuery;
					 
					// Execute query
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							
						while ($row = $this->_dbRef->my_fetch_object($req)) {
								if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
													$result['Email_ID'] 	   = $row->email;
													$result['Invitation_Date'] = date('d-m-y',strtotime($row->created_at));
													$result2[] = $result;
								 		}	
									}
								} else {
											$result['Email_ID'] 	   = $row->email;
											$result['Invitation_Date'] = date('d-m-y',strtotime($row->created_at));
											$result2[] = $result;
								}	
						}
						if (count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}

			 }

			
		
			
			/* 
			 * Service Photos Uploaded  { information } [Sub] - B
			 * Function for Get Photo uploaded information
			 */
			 public function getPhotoUploadedInfoHelper($year, $month, $day)
			 {
					$today_date     	 = ''; 	// Current date
					if(!$year)  { $year = date("Y");  } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
					// If day number is set then 					
					if($day) {
						 $day = intval($day);
							if($day < 10 ) { $day = "0".$day; }
								$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}
					
					$this->getInfoQuery .= "YEAR( media.media_created_at ) = ".$year." AND MONTH( media.media_created_at ) = ".$month;
					$this->getInfoQuery.=" AND album.album_id=media.album_id";
					$QueryExe = "SELECT album.album_name,media.album_id,media.user_id,media.media_created_at, media.media_name,media.media_id FROM cc_media as media, cc_album as album".$this->getInfoQuery;
					// Execute query
						$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
						while($row = $this->_dbRef->my_fetch_object($req))	{
						$result['Image_Name'] 		= $row->media_name;

						if($day) {								
								if ($today_date) {
										 if ($today_date == date("Y-m-d",strtotime($row->media_created_at))) {

								/*------------------------------------------------------------
											 Create image link according to album name
										Check two album name ( wallphoto and profile picture )
									----------------------------------------------------------------*/
								switch($row->album_name)
								{
										case "Wall Photos":
											$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/wall/".$row->media_name;
											$result['Image_Link'] 		= $img_url;
										break;

										case "Profile Pictures":
											$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/profile/".$row->media_name;
											$result['Image_Link'] 		= $img_url;
										break;
								
										case "ChatChing Album":
											$img_url = $_SERVER['HTTP_HOST']."/".$row->media_name;
											$result['Image_Link'] 		= $img_url;
										break;	
								
										default:
											$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/album_".$row->album_id."/".$row->media_name;
											$result['Image_Link'] 		= $img_url;
										break;
								}

								/*-------------------------------------------------
											 Get image size in KB use by CURL
								---------------------------------------------------*/
							 			 $ch = curl_init($img_url);
						    			 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							 			 curl_setopt($ch, CURLOPT_HEADER, TRUE);
						    			 curl_setopt($ch, CURLOPT_NOBODY, TRUE);

						     				 $data = curl_exec($ch);
						    				 $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

						     				curl_close($ch);
	  						 				$result['Size (KB)'] 		= round($size / 1024, 2);
							  				$result2[] = $result; // Create Array for store user information data

								 		}	
									}
								} else {
											
						
						/*------------------------------------------------------------
										 Create image link according to album name
									Check two album name ( wallphoto and profile picture )
							----------------------------------------------------------------*/
							switch($row->album_name)
							{
								case "Wall Photos":
									$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/wall/".$row->media_name;
									$result['Image_Link'] 		= $img_url;
								break;

								case "Profile Pictures":
									$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/profile/".$row->media_name;
									$result['Image_Link'] 		= $img_url;
								break;
								
								case "ChatChing Album":
									$img_url = $_SERVER['HTTP_HOST']."/".$row->media_name;
									$result['Image_Link'] 		= $img_url;
								break;	
								
								default:
									$img_url = "https://cccdnsol.s3.amazonaws.com/user_".$row->user_id."/album_".$row->album_id."/".$row->media_name;
									$result['Image_Link'] 		= $img_url;
								break;
							}

							/*-------------------------------------------------
										 Get image size in KB use by CURL
							---------------------------------------------------*/
							  $ch = curl_init($img_url);
						     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							  curl_setopt($ch, CURLOPT_HEADER, TRUE);
						     curl_setopt($ch, CURLOPT_NOBODY, TRUE);

						     $data = curl_exec($ch);
						     $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

						     curl_close($ch);
	  						  $result['Size (KB)'] 		= round($size / 1024, 2);
							  $result2[] = $result; // Create Array for store user information data
							}
						} // End while loop

						if (count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
				
			 }

		
			/* 
			 * Service Points Awarded Total Information -[Sub] - B
			 * Function for Get Points Awarded Total - Information
			 */
			 public function pointsAwardedTotalHelperinfoHelper($year, $month, $day)
			 {
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}
	
					$this->getInfoQuery .= "YEAR( cc_point.datetime ) = ".$year." AND MONTH( cc_point.datetime ) = ".$month;
					$QueryExe = "SELECT cc_point.datetime, cc_point.user_id, cc_point.point, cc_user.username FROM cc_point
					LEFT JOIN cc_user on cc_point.user_id = cc_user.user_id ".$this->getInfoQuery;
					 
					// Execute query
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					
					if ($today_date) { 
							$ts	   	= strtotime($today_date);
							$start 		= strtotime('sunday this week -1 week', $ts);
							$end   		= strtotime('sunday this week', $ts);
							$start_day  = date('Y-m-d', $start);
							$end_day    = date('Y-m-d', $end);
						}
							
					if ($this->_dbRef->my_num_rows($req) > 0)
					{
						while ($row = $this->_dbRef->my_fetch_object($req))	{
							if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->datetime))) {
													$result['Username'] 	  			   = $row->username;
													$result['Points_Awarded'] 		   = $row->point;
													$result2[] = $result;
								 		}	
									}
								} else {
											$result['Username'] 	  			   = $row->username;
											$result['Points_Awarded'] 		   = $row->point;
											$result2[] = $result;
								}		
						} // End while loop

						if ( count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
					} else {
						return false;
					}
			 }
			 

        /*
			* Service : Get Total No of Services Details [Main]
			* @method: getTotalServicesDetailHelper()
			* @reutrn: Array
			*/
			public function getTotalServicesDetailHelper()
			{
				$today_date      	 = date('Y-m-d');	 // Current date
				$this->current_year  = date('Y'); 		// Current Year
				$this->current_month = date('m'); 		// Current Month

				$result_array = array();

				/*-----------------------------------------------------
							 This is for Registered Memebers Total
				--------------------------------------------------------*/					
				$QueryExe = "SELECT * FROM cc_user WHERE YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;
				$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
					$total_ragister = array();
					while ($row = $this->_dbRef->my_fetch_object($req))	{
						$this->month_count++; 
					}
						$total_ragister['service_count'] = $this->month_count;
						$total_ragister['service_id'] 	= 1;
						$total_ragister['service_title'] = "Registered Memebers";
						$result_array[] = $total_ragister;
					
					/*-----------------------------------------------------
								 This is for Registered offering Total.
					--------------------------------------------------------*/					
					$QueryExe1 = "SELECT user_id,created_at FROM cc_user where parent_id !=0 and YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;
					$req1 = $this->_dbRef->my_query($QueryExe1,"Authontication Failed!!");

				
						$registered_offering = array();
						$month_count = 0;
						while ($row1 = $this->_dbRef->my_fetch_object($req1)) {
							$month_count++ ;
						}
						$registered_offering['service_count'] 	= $month_count;
						$registered_offering['service_id']  	= 2;
						$registered_offering['service_title'] 	= "Registered offering";
						$result_array[] = $registered_offering;

					
					/*-----------------------------------------------------
									 This is for Invitation sent Today
					--------------------------------------------------------*/					
					$QueryExe2 = "SELECT incentive_request_id,requested_date FROM cc_incentive_request WHERE YEAR( requested_date ) = ".$this->current_year." AND MONTH( requested_date ) = ".$this->current_month;
					$req2 = $this->_dbRef->my_query($QueryExe2,"Authontication Failed!!");

					
						$invitation_sent = array();
						$invitation_month = 0;
						while ($row2 = $this->_dbRef->my_fetch_object($req2)) {
							$invitation_month++; 
						}
						$invitation_sent['service_count']  = $invitation_month;
						$invitation_sent['service_id'] 	  = 3;
						$invitation_sent['service_title']  = "Invitation sent";
						$result_array[] = $invitation_sent;
					

					/*-----------------------------------------------------
										Invitation pending Today.
					--------------------------------------------------------*/					
					$QueryExe3 = "SELECT friends_id, created_at FROM cc_friends where status = 0 and YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;
					$req3 = $this->_dbRef->my_query($QueryExe3,"Authontication Failed!!");
					
					
						$pending_invitation = array();
						$invitation_pending = 0;
						while ($row3 = $this->_dbRef->my_fetch_object($req3)) {
							$invitation_pending++; 
						}
						
						$pending_invitation['service_count'] 	= round($invitation_pending);
						$pending_invitation['service_id'] 		= 4;
						$pending_invitation['service_title'] 	= "Invitation pending";
						$result_array[] = $pending_invitation;
					
					
					/*-----------------------------------------------------
									Points Awarded Total - Today
					--------------------------------------------------------*/					
					$QueryExe4 = "SELECT point, datetime FROM cc_point WHERE YEAR( datetime ) = ".$this->current_year." AND MONTH( datetime ) = ".$this->current_month;
					$req4 = $this->_dbRef->my_query($QueryExe4,"Authontication Failed!!");
					
						$points_awarded = array();
						$awarded_point  = 0;
						while ($row4 = $this->_dbRef->my_fetch_object($req4)) {
							$awarded_point++; 
						}
						$points_awarded['service_count'] 	= $awarded_point;
						$points_awarded['service_id'] 		= 5;
						$points_awarded['service_title'] 	= "Points Awarded";
						$result_array[] = $points_awarded;
					
						
					/*-----------------------------------------------------
									Photos Uploaded Total - Today
					--------------------------------------------------------*/					
					$QueryExe5 = "SELECT media_id, media_name, media_created_at FROM cc_media WHERE media_type = 1 AND  YEAR( media_created_at ) = ".$this->current_year." AND MONTH( media_created_at ) = ".$this->current_month;
					$req5 = $this->_dbRef->my_query($QueryExe5,"Authontication Failed!!");
					
					
						$uploaded_photos = array();
						$photos_uploaded = 0;
						while ($row5 = $this->_dbRef->my_fetch_object($req5)) {
							$photos_uploaded++; 
						}
						$uploaded_photos['service_count'] 	= round($photos_uploaded);
						$uploaded_photos['service_id'] 		= 6;
						$uploaded_photos['service_title']   = "Photos Uploaded";
						$result_array[] = $uploaded_photos;
				

					/*-----------------------------------------------------
									Total Emails Sent - Today 
					--------------------------------------------------------*/					
					$QueryExe6 = "SELECT * FROM cc_email_log WHERE YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;

					$req6 = $this->_dbRef->my_query($QueryExe6,"Authontication Failed!!");
					
						$sent_email = array();
						$email_sent = 0;
						while ($row6 = $this->_dbRef->my_fetch_object($req6)) {
							$email_sent++; 
						}
						
						$sent_email['service_count'] 	= $email_sent;
						$sent_email['service_id'] 		= 7;
						$sent_email['service_title'] 	= "Total Emails Sent";
						$result_array[] = $sent_email;
					

					/*-----------------------------------------------------
											Page Load - today
					--------------------------------------------------------*/					
					$QueryExe6 = "SELECT * FROM cc_page_load WHERE YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;

					$req6 = $this->_dbRef->my_query($QueryExe6,"Authontication Failed!!");
					
						$sent_email = array();
						$email_sent = 0;
						while ($row6 = $this->_dbRef->my_fetch_object($req6)) {
							$email_sent++; 
						}
						
						$sent_email['service_count'] 	  = $email_sent;
						$sent_email['service_id'] = 8;
						$sent_email['service_title'] 	  = "Page Load";
						$result_array[] = $sent_email;
					
					/*-----------------------------------------------------
										 Photo Served from S3
					--------------------------------------------------------*/
					$QueryExe6 = "SELECT * FROM cc_statistics_s3_images WHERE YEAR( created_at ) = ".$this->current_year." AND MONTH( created_at ) = ".$this->current_month;
					$req6 = $this->_dbRef->my_query($QueryExe6,"Authontication Failed!!");
					
						$sent_email = array();
						$email_sent = 0;
						while ($row6 = $this->_dbRef->my_fetch_object($req6)) {
							$email_sent++; 
						}
						
						$sent_email['service_count'] 	= $email_sent;
						$sent_email['service_id']		= 9;
						$sent_email['service_title'] 	= "Photo Served from S3";
						$result_array[] = $sent_email;
					return $result_array;
				}
	
			/**
			* Get service counter 	
			* @Param Year , month , day
			* Return array		
			*/
			public function getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day, $country_id)
			{
					$today_date = "";
					if(!$year)  { $year 	= date("Y"); } // Set default year if not get in function 
					if(!$month) { $month = date("m"); } // Set default month if not get in function

				// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}

						// Store log 
						//	log_message("debug","getUserRegCount() :: Variables :: Year=>".$year." month=>".$month." Week=>".$week);
						
						// Create query according to perameters 	
						$this->getInfoQuery .= "YEAR( ".$field_name." ) = ".$year." AND MONTH( ".$field_name." ) = ".$month." ".$condition;
	

					// If country paramter not blank set 
					if ($country_id!='') {
						$this->getInfoQuery .=" AND profile.user_id = user.user_id AND profile.country_id=".$country_id;
						$QueryExe = "SELECT ".$field_name." FROM ".$table_name." as user,cc_user_profile as profile".$this->getInfoQuery;
						$QueryExe = "SELECT ".$field_name." FROM ".$table_name." ".$this->getInfoQuery;
					} else {
						$QueryExe = "SELECT ".$field_name." FROM ".$table_name." ".$this->getInfoQuery;
				}
					
				
						$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!"); // Return result 
	
						// If Today date set then get start and end day 
						if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							
						// Execute while loop for get data for today / week / month
							while ($row = $this->_dbRef->my_fetch_object($req))	
							{
								//Count number of register user today
								 if ($today_date) {
								 	 if ($today_date == date("Y-m-d",strtotime($row->$field_name))) {
										 $this->today_count++; 
							 			}
								 }
									// Count number of register user current week
									if ($today_date) {
											$week_day = date("Y-m-d",strtotime($row->$field_name));
											if ($week_day >= $start_day && $week_day <= $end_day) {
											$this->week_count++;
										}
									} 
							 	//Count number of register user current month
								$this->month_count++; 
						} // End while loop
						
						$result_array = array();
						
						if($this->month_count > 0 ) { 
							$result_array['month_counter'] = $this->month_count;
							$result_array['week_counter']  = $this->week_count;  
							if($week) { $this->today_count = 0; $result_array['today_counter'] = $this->today_count; } else { $result_array['today_counter'] = $this->today_count; }
						}
					//	$result_array['service_title'] = "Registered Memebers";
						return $result_array;
			}

			public function getServicesDetailHelper($service_id, $year, $month, $day, $country_id)
			{
		
				switch ($service_id) {
					// IF want to get Registered Memebers Total - .
					case 1: 
						/// -- Get User Helper Class --
						$table_name = 'cc_user'; 
						$field_name = 'created_at';
						$condition  = 'order by created_at asc';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day, $country_id);
						return $result;
					break;
						
					//IF want to get Registered offering Total - .
					case 2: 
						/// -- Get User Helper Class --
						$table_name = 'cc_user'; 
						$field_name = 'created_at';
						$condition  = 'AND parent_id !=0';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						return $result;
					break;
						
					//IF want to get Invitation sent .
					case 3: 
						/// -- Get User Helper Class --
						$table_name = 'cc_incentive_request'; 
						$field_name = 'requested_date';
						$condition  = '';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						return $result;
					break;
						
					//IF want to get Invitation pending .
					case 4: 
						/// -- Get User Helper Class --
						$table_name = 'cc_friends'; 
						$field_name = 'created_at';
						$condition  = ' AND status = 0 order by created_at asc';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						return $result;
					break;
						
					//IF want to get Points Awarded Total.
					case 5: 
						/// -- Get User Helper Class --
						$table_name = 'cc_point'; 
						$field_name = 'datetime';
						$condition  = '';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						 return $result;
					break;
						
					//IF want to get Photos Uploaded Total - Today.
					case 6: 
						/// -- Get User Helper Class --
						$table_name = 'cc_media'; 
						$field_name = 'media_created_at';
						$condition  = ' AND media_type = 1 order by media_created_at asc';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						 return $result;
					break;
						
					//IF want to get Total Emails Sent - Today.
					case 7: 
						/// -- Get User Helper Class --
						$table_name = 'cc_email_log'; 
						$field_name = 'created_at';
						$condition  = '';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						return $result;
					break;
						
					//IF want to get Total page load  - Today.
					case 8: 
						/// -- Get User Helper Class --
						$table_name = 'cc_page_load'; 
						$field_name = 'created_at';
						$condition  = '';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
						return $result;
					break;

					//IF want to get Total page load  - Today.
					case 9: 
						/// -- Get User Helper Class --
						$table_name = 'cc_statistics_s3_images'; 
						$field_name = 'created_at';
						$condition  = ' GROUP BY media_name order by created_at ';
						$result = $this->getServiceCountHelper($table_name, $field_name, $condition, $year, $month, $day);
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
			
			/**
			 * Auth key helper function
			 * param Auth key is string
			 * Return Boolean
			 * */
			public function getAuthTokenHelper($auth_key)
			{
				// Check token for Authentication key
				$QueryExe2 = "SELECT token FROM cc_auth_token WHERE auth_key='".$auth_key."'";
			
				// Execute query
				$req2 = $this->_dbRef->my_query($QueryExe2,"Authontication Failed!!");
				if ($this->_dbRef->my_num_rows($req2) > 0) 
				{
					while ($rows = $this->_dbRef->my_fetch_object($req2))
					{
						if ( $rows->token!='' ) {
	
							$result['token']  = $rows->token;
							$_SESSION['token_val'] = $rows->token;
						} else {
				
							$token 	= $this->getToken($auth_key);
							if ($token) { 
								$result['token'] 	   = $token;
								$_SESSION['token_val'] = $token;
								
								// Store token in database for auth key
								$QueryToken = "UPDATE cc_auth_token SET token='".$token."' WHERE auth_key='".$auth_key."'";
								// Execute query
								$resultToken = $this->_dbRef->my_query($QueryToken,"Authontication Failed!!");
							}
						}
					} // End while loop
				} else {
						$result['token']  = 'Unauthorized Authentication key';
				}

				return $result;
			}
			
			/**
			 * Get Token by auth key 
			 * param Auth key is string
			 * Return string ( Token ) 
			 * */
			public function getToken($auth_key)
			{
				// Need to generate Token for auth key 
				$random = substr(number_format(time() * rand(),0,'',''),0,5);

				return $random;
			}
			
	

		public function authLogoutHelper($token)
		{
			if($token) {
			// Check token for Authentication key
			$QueryExe2 = "UPDATE cc_auth_token SET token='' WHERE token='".$token."'";
			// Execute query
			$req2 = $this->_dbRef->my_query($QueryExe2,"Authontication Failed!!");
			$result['token']  = 'logout';
			} else {
					$result['token']  = 'Unauthorized Authentication key';
			}
			return $result;
		}
		
		
		public function pageloadInfoHelper($year, $month, $day)
		{
					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}

					$this->getInfoQuery .= "YEAR(created_at ) = ".$year." AND MONTH( created_at ) = ".$month;
				
					// If country paramter not blank set 
					$QueryExe = "SELECT * FROM cc_page_load".$this->getInfoQuery;
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");

					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
							}
							
							
						while ($row = $this->_dbRef->my_fetch_object($req)) {

							if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
												$page_title = str_replace("_", " ", $row->page_title);
												$result['Page_Title'] = ucfirst($page_title);
												$result['Page_Link']  = $row->page_url;
												$result2[] = $result;
								 		}	
									}
								} else {
									$page_title = str_replace("_", " ", $row->page_title);
									$result['Page_Title'] = ucfirst($page_title);
									$result['Page_Link']  = $row->page_url;
									$result2[] = $result;
								}	
						}
						
						if(count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
		}

		
		
		public function photoLoadInfoHelper($year, $month, $day)
		{

					$today_date     	 = ''; 	// Current date
					if(!$year) { $year = date("Y"); } // Current Year
					if(!$month) { $month = date("m"); } // Current Month
					
						// If day number is set then 					
					if($day) {
						 $day = intval($day);
						if($day < 10 ) { $day = "0".$day; }
							$today_date  = date($year."-".$month."-".$day);		
					}
					// Set today date if not set
					if($today_date=="") { $today_date = date("Y-m-d");	}

		
					$this->getInfoQuery .= "YEAR( created_at ) = ".$year." AND MONTH( created_at ) = ".$month;
					$this->getInfoQuery.=" GROUP BY media_name order by created_at";
					$QueryExe = "SELECT * FROM cc_statistics_s3_images".$this->getInfoQuery;
					 
					
					// Execute query
					$req = $this->_dbRef->my_query($QueryExe,"Authontication Failed!!");
				
					if ($today_date) { 
									$ts	   	= strtotime($today_date);
									$start 		= strtotime('sunday this week -1 week', $ts);
									$end   		= strtotime('sunday this week', $ts);
									$start_day  = date('Y-m-d', $start);
									$end_day    = date('Y-m-d', $end);
					}
							
						while ($row = $this->_dbRef->my_fetch_object($req)) {
							if($day) {								
										if ($today_date) {
										 	 if ($today_date == date("Y-m-d",strtotime($row->created_at))) {
													$result['Image_Name'] 	 = $row->media_name;
													$result['Image_Link'] 	 = $row->media_url;
													$result['No_of_Serve']  = $row->count;
													$result2[] = $result; // Create Array for store user information data
						 						}	
										}	
								} else {
									$result['Image_Name'] 	 = $row->media_name;
									$result['Image_Link'] 	 = $row->media_url;
									$result['No_of_Serve']  = $row->count;
									$result2[] = $result; // Create Array for store user information data
								}		

						}
						if (count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
				
		}

	public function getServicesDetailInfoHelper($service_id, $year, $month, $day, $country_id)
	{
		switch($service_id)
		{
			case "1":
					$result = $this->getUserInfoHelper($year, $month, $day, $country_id);
					return $result;
			break;
			
			case "2":
					$result = $this->getUserOfferInfoHelper($year, $month, $day, $country_id);
					return $result;
			break;
			
			case "3":
					$result = $this->invtationSendInfoHelper($year, $month, $day);
					return $result;
			break;
			
			case "4":
					$result = $this->invtationUserPendingInfoHelper($year, $month, $day);
					return $result;
			break;
			
			case "5":
					$result = $this->pointsAwardedTotalHelperinfoHelper($year, $month, $day);
					return $result;
			break;
			
			case "6":
					$result = $this->getPhotoUploadedInfoHelper($year, $month, $day, $country_id);
					return $result;
			break;

			case "7":
					$result = $this->getEmailCountInfoHelper($year, $month, $day);
					return $result;
			break;

			case "8":
					$result = $this->pageloadInfoHelper($year, $month, $day);
					return $result;
			break;
			
			case "9":
					$result = $this->photoLoadInfoHelper($year, $month, $day);
					return $result;
			break;

		/* 	case "10":
					$result = $this->getUserInfoHelperPerDay($type,$country_id);
					return $result; */
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
			
	public function get_server_info_Helper()
	{


		    $_config=config::getInst()->getSettings();
		    
		    foreach($_config as $key=>$val)
		    {
		    $result[$key]  = $val;
   		 }
	   	$result['basepath'] = BASEPATH;	
    		 $result2[] = $result;
    		 
	   			if(count($result2) > 0 ) {
							return $result2;
						} else {
							return "No Record";
						}
						
	}			
}
?>
