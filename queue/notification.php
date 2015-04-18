<?php 
/**
 * @Author : Sushil Mishra
 * @Email  : sushilmishra2cdnsol.com
 * @Timestamp : March-22 06:55PM 
 * @Copyright : www.cdnsol.com 
**/
	date_default_timezone_set('Europe/Luxembourg');
	// -- Check if file YAML file exists --
	define("BASEPATH",dirname(__FILE__));
	// -- File Extension --
	define("EXT",".php");
	ini_set('display_errors','1');
	// -- Check if file Common file exists --
	if(file_exists(dirname(__FILE__).'/inc/common'.EXT))
	{
		include(dirname(__FILE__).'/inc/common'.EXT);
		log_message("ALL","All files include successfully");
	}
	if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
	{
		log_message("ALL","expiryCheck will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
		
	} else {
		
		/// -- Log Message to Log file for Type of call --
		log_message("ALL","expiryCheck will run for --> INTERNAL ()");
		$db_job = processNotification();
		exit();
		
	}// -- FII :: $_POST["key"] --
	
	
	//send notification to all usere who craved that pericular element, project, industry or showcase
	function processNotification(){
		$result =	getQueue();
		if($result){
			$queueIdSuccess=array();
			$queueIdFail=array();
			
			$isSent=3;
			while ($row = pg_fetch_assoc($result)) {
				
				$isSent=3; // fail to send notification status
				
				// Get the list of participants
				$participants = getNoficationParticipants($row);
				
				
				
				if($participants){
					
					// get Notification string
					$notificationString = getNotificationStr($row);
					
				
					
					
					if($notificationString){
						// insert notificaiton
						$notificationId = insertNotification($row,$notificationString);
						
						if($notificationId > 0){
							// insert notification participants
							insertNotificationParticipants($notificationId, $participants);
							
							$isSent=2; // success to send notification status
							
						}
					}
				}
				if($row['id'] >0){
					if($isSent==2){
						$queueIdSuccess[]=$row['id'];
					}else{
						$queueIdFail[]=$row['id'];
					}
				}
			}
			//update notification queue
			if($queueIdSuccess && is_array($queueIdSuccess) && count($queueIdSuccess) > 0 && is_numeric($isSent)){
				$queueStatus =setQueueStatus($queueIdSuccess, $isSent);
			}
			
			if($queueIdFail && is_array($queueIdFail) && count($queueIdFail) > 0 && is_numeric($isSent)){
				$queueStatus =setQueueStatus($queueIdFail, $isSent);
			}
		}
	}
	
	// Fetch notification pending queue
	/**
	To fetch the notifiaction queue we need to pull 
	records from TDS_NoficationQue table 
	where field "isSent=false"
	return Array
	**/
	function getQueue(){
		$queue = false;
		$db = db_connect();
		if($db){
			$queue = pg_query($db, 'SELECT * from "TDS_NotificationQue" where "isSent" in(0,3)');
		}
		return $queue;
		// return recordset or array of elements
	}
	
	
	
	// Get individual notification participants
	/**
	Get Participants by fetching Distinct Member 
		Check owner's showcase craved by people, 
		Check entity craved by people
	@entityId = table id 
	@elementId = element id of that table
	@ownerId = owner / userid of that element
	**/
	function getNoficationParticipants($row=array()){
		if($row && is_array($row) && count($row) > 0){
			$db = db_connect();
			$where = false;
			
			if($row['projectType']=='yourReviews'){ // find owner of project in case of your showcase or project reviewed by other user
				$participant=false;
				$SQL = 'SELECT (item).userid FROM "TDS_search" where entityid='.$row['entityId'].' AND elementid='.$row['elementId'].' LIMIT 1';
				$query = pg_query($db, $SQL);
				if($query){
					$data = pg_fetch_assoc($query);
					$participant=array($data['userid']);
				}
				return $participant;
			}
			else{
				switch($row['entityId']){ // find user list who crave your shocase, industry or project  in case of you has added new project or element
					case 97: //blog
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$row['entityId'].' OR lc."entityId" = 97 OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId" ';
					break;
					
					case 96: //blog->post
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$row['entityId'].' OR lc."entityId" = 97 OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId" ';
					break;
					
					case 49: //product
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$row['entityId'].' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
					break;
					
					case 82: // work
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$row['entityId'].' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
					break;
					
					case 71: // UpcomingProject
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$row['entityId'].' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
					break;
					
					case 54: //project media
					case 12: // F&V Element
					case 25: // M&A Element
					case 47: // P&A Element
					case 12: // W&P Element
					case 7: // EM Element
					case 94: // news Element
					case 95: // Reviews Element
						if($row['projectType']=='educationMaterial'){ // Education Material 
							$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."projectType" = \'educationMaterial\' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
						}elseif($row['entityId']==94){ //  news Element 
							$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."projectType" = \'news\' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
						}elseif($row['entityId']==95){ //  Reviews Element
							$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."projectType" = \'reviews\' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
						}
						elseif($row['industryId'] > 0){ // media section:  F&V, M&A , P&A , W&P 
							$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = 93 OR (item)."industryid"='.$row['industryId'].') AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId" ';
						}
						
					break;
						
					case 9: //Event & Event notification 
					case 15: // launch
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = 9 OR lc."entityId" = 15 OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
						break;
						
					case 10: // Event Session
						if($row['alert_type']=='event'){
							$entityId=9;
						}else{
							$entityId=15;
						}
						$where='WHERE lc."ownerId" = '.$row['ownerId'].' AND (lc."entityId" = '.$entityId.' OR lc."entityId" = 93) AND s."entityid"= lc."entityId" AND s."elementid"= lc."elementId"  ';
					break;
						
					default:
						$where=false;
				}
				
				if($where){
					$SQL = 'SELECT lc."tdsUid" FROM "TDS_LogCrave" as lc, "TDS_search" as s '.$where.' GROUP BY lc."tdsUid"';
					$query = pg_query($db, $SQL);
					
					if($query){
						$participant=array();
						while ($data = pg_fetch_assoc($query)) {
							$participant[]=$data['tdsUid'];
						}
						return $participant;
					}else{
						return false;
					}
					
				}else{
					return false;
				}
			}	
		
		}else{
			return false;
		}
	}
	
	// Get Notification Templates.
	/**
	@entityId = table id 
	@elementId = element id of that table
	@ownerId = owner / userid of that element
	@type = type of notification we are looking forward
	get notification string from notification config file
	**/
	function getNotificationStr($row=array()){
		include(dirname(dirname(__FILE__)).'/application/config/notification_alert'.EXT);
		$notificationString=false;
		$alert_key='';
		$alert_type='';
		if(isset($row['entityId']) && $row['entityId'] > 0 && isset($row['elementId']) && $row['elementId'] > 0){
			$db = db_connect();
			$entityId=$row['entityId'];
			$elementId=$row['elementId'];
			if($row['entityId']==10){
				$SQL_SESS = 'SELECT "sessionTitle" as "title" FROM "TDS_EventSessions"  where "sessionId"='.$row['elementId'].' LIMIT 1';
				$query_SESS = pg_query($db, $SQL_SESS);
				if($query_SESS){
					$data_SESS = pg_fetch_assoc($query_SESS);
				}
				
				
				if($row['alert_type']=='event'){
					$entityId=9;
				}else{
					$entityId=15;
				}
				$elementId=$row['projectId'];
			}
			
			$SQL = 'SELECT entityid, elementid, projectid,section,(item).title,(item).userid,(item).creative_name,(item).category,(item).categoryid,(item).work_type,(item).industryid,(item).industry,"enterprise","enterpriseName" FROM "TDS_search", "TDS_UserShowcase"  where entityid='.$entityId.' AND elementid='.$elementId.' AND "TDS_UserShowcase"."tdsUid"= (item).userid LIMIT 1';
			
			$query = pg_query($db, $SQL);
			if($query){
				$data = pg_fetch_assoc($query);
				if($data){
					if($row['entityId']==10){
						$data['section']='eventSession';
					}
					
					if($row['projectType']=='yourReviews'){ // find owner of project in case of your showcase or project reviewed by other user
						
						$creative_name='';
						
						$SQL2 = 'SELECT up."firstName", up."lastName", us."enterprise", us."enterpriseName" FROM "TDS_UserShowcase" as us, "TDS_UserProfile" as up where us."tdsUid"='.$row['ownerId'].' AND up."tdsUid"='.$row['ownerId'].' LIMIT 1';
						$query2 = pg_query($db, $SQL2);
						if($query2){
							$data2 = pg_fetch_assoc($query2);
							$creative_name=($data2['enterprise']=='t')?$data2['enterpriseName']:$data2['firstName'].' '.$data2['lastName'];
						}
						
						if($data['entityid']==93){
							$alert_type='showcase_review_alert';
						}else{
							$alert_type='project_review_alert';
						}
						
					}
					else{
						
						switch($data['section']){
							
							case 'blog': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '97'){
									$alert_type='blog_alert'; // get new blog added notification string 
								}else{
									$alert_type='post_alert'; // get new post added notification string 
								}
							break;
							
							case 'blog': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '97'){
									$alert_type='blog_alert'; // get new blog added notification string 
								}else{
									$alert_type='post_alert'; // get new post added notification string 
								}
							break;
							
							case 'post': 
								$alert_type='post_alert'; // get new post added notification string 
							break;
							
							case 'product': 
								if($data['categoryid'] == 'product_1'){
									$alert_type='product_sale_alert'; // get new product(sell) added notification string 
								}elseif($data['categoryid'] == 'product_2'){
									$alert_type='product_wanted_alert';  // get new product(wanted) added notification string 
								}else{
									$alert_type='product_free_alert'; // get new product(free) added notification string 
								}
							break;
							
							case 'work': 
								if($data['work_type'] == 'wanted'){
									$alert_type='work_wanted_alert'; // get new work(wanted) added notification string 
								}else{
									$alert_type='work_offered_alert'; // get new work(offered) added notification string 
								}
							break;	
							
							case 'notification': // get P&E (notification) added notification string 
								$alert_type='performancesevents_event_notification_alert';
							break;
							
							case 'event':  // get P&E (event) added notification string 
								$alert_type='performancesevents_event_alert';
							break;
							
							case 'launch':  // get P&E (launch) added notification string 
								$alert_type='performancesevents_launch_alert';
							break;
							
							case 'upcoming': // get upcoming added notification string 
								$alert_type='upcoming_alert';
							break;
							
							case 'filmNvideo': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='filmNvideo_alert'; // get F&V added notification string 
								}else{
									$alert_type='filmNvideo_element_alert'; // get F&V Element added notification string 
								}
							break;
							
							case 'musicNaudio': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='musicNaudio_alert'; // get M&A added notification string 
								}else{
									$alert_type='musicNaudio_element_alert'; // get M&A Element added notification string 
								}
							break;
							
							case 'photographyNart': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='photographyNart_alert'; // get P&A added notification string 
								}else{
									$alert_type='photographyNart_element_alert'; // get P&A Element added notification string
								}
							break;
							
							case 'writingNpublishing': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='writingNpublishing_alert'; // get W&P added notification string 
								}else{
									$alert_type='writingNpublishing_element_alert'; // get W&P Element added notification string
								}
							break;
							
							case 'educationMaterial': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='educationMaterial_alert'; // get educationMaterial added notification string 
								}else{
									$alert_type='educationMaterial_element_alert'; // get educationMaterial Element added notification string
								}
							break;
							
							case 'news': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='news_alert'; // get news added notification string 
								}else{
									$alert_type='news_element_alert';  // get news Element added notification string
								}
							break;
							
							case 'reviews': 
								if($data['elementid'] == $data['projectid'] && $data['entityid'] == '54'){
									$alert_type='reviews_alert'; // get reviews added notification string 
								}else{
									$alert_type='reviews_element_alert';  // get reviews Element added notification string
								}
							break;
							
							case 'eventSession': 
								$alert_type='session_change_alert';
								if(isset($data_SESS) && is_array($data_SESS) && count($data_SESS)){
									$data['title']=$data_SESS['title'];
								}
							break;
							
							default:
								$alert_type='';
						}
					
						$creative_name=($data['enterprise']=='t')?$data['enterpriseName']:$data['creative_name'];
					}	
					if($alert_type !=''){
						if(isset($config[$alert_type]) && $creative_name !=''){
							// $notificationString=$config[$alert_type.$alert_key];
							$notificationString=$config[$alert_type];
							
							$notificationString=str_replace(array('{X}','{Y}'),array($creative_name,$data['title']),$notificationString);
						}
					}
				}
			}
		}
		// Switch case based on $entityId, type
		return $notificationString;
	}
	
	
	// Insert notification in TDS_Notification Table
	/**
	@entityId = table id 
	@elementId = element id of that table
	@ownerId = owner / userid of that element
	@templateStr = return from get Template
	**/
	function insertNotification($row=array(),$notificationString=''){
		
		$checkNotification = notificationExist($row);
		if((isset($checkNotification)) && (is_array($checkNotification)) && (count($checkNotification)>0)){
			return false;
		}
		else
		{
			$notificationId = false;
			if(isset($row['entityId']) && $row['entityId'] > 0 && isset($row['elementId']) && $row['elementId'] > 0){
				$db = db_connect();
				$SQL = 'INSERT INTO "TDS_Notification" (
															"entityId",
															"elementId",
															"projectId",
															"industryId",
															"message",
															"createdDate",
															"ownerId",
															"projectType"
														)
												 VALUES (
															'.$row['entityId'].',
															'.$row['elementId'].',
															'.$row['projectId'].',
															'.$row['industryId'].',
															\''.pg_escape_string($notificationString).'\',
															\''.date('Y-m-d h:i:s').'\',
															'.$row['ownerId'].',
															\''.$row['projectType'].'\'
															
														) ';
				$query = pg_query($db, $SQL);
				$insert_query = 'SELECT lastval();';
				$insert_row = pg_fetch_row(pg_query($insert_query));
				$notificationId= $insert_row[0];	
			}
			return $notificationId;
		}
	}
	
	// insertNotificationParticipants
	/**
	@notificationId = id of TDS_Notification table
	@partifications = array of user ids (participants)
	**/
	function insertNotificationParticipants($notificationId, $participants){
		$db = db_connect();
		$values='';
		$TP = count($participants);
		foreach($participants as $k=>$userId){
			if($userId > 0){
				$values.=  '('.$notificationId.','.$userId.') ';
				if($k < ($TP-1)){
					$values.= ',';
				}
			}
		}
		
		$SQL = 'INSERT INTO "TDS_NotificationParticipants" (
										"notificationId",
										"userId"
									)
							 VALUES  '.$values.'';
		$query = pg_query($db, $SQL);
		return $query;
	}
	
	// Set notification queue in process status, 
	// so Next time when this process runs, 
	// will not pock under process notficaiton queue
	/**
	* @queue : Array / Ids
	* @status : New/InProcess/Sent/Fail
	**/
	function setQueueStatus($queue, $status){
		
		if($queue && is_array($queue) && count($queue) > 0 && is_numeric($status)){
			$db = db_connect();
			$ids= implode(',',$queue);
			$update_queue = pg_query($db, 'update "TDS_NotificationQue" SET "isSent" = '.$status.'  where "id" in('.$ids.') ');
			return $update_queue;
		}else{
			return false;
		}
	}
	
	// Function to check notification is exists
	/**
	* @notificationData : Details of notification
	**/
	function notificationExist($notificationData=array()){
		if(isset($notificationData['entityId'])){
			$db = db_connect();
			$SQL_Notification = 'SELECT "id" FROM "TDS_Notification"  where "entityId"='.$notificationData['entityId'].' AND "elementId"='.$notificationData['elementId'].' AND "projectId"='.$notificationData['projectId'].'  AND "industryId"='.$notificationData['industryId'].'  AND "ownerId"='.$notificationData['ownerId'].' AND "projectType"=\''.$notificationData['projectType'].'\'';
			$query_Notification = pg_query($db, $SQL_Notification);
			
			if($query_Notification){
				$data_Notification = pg_fetch_assoc($query_Notification);
				return $data_Notification;
			}
		}
	}

?>
