<?php 
/**
 * @Author : Sushil Mishra
 * @Email  : sushilmishra2cdnsol.com
 * @Timestamp : Feb-26 06:51PM 
 * @Copyright : www.cdnsol.com 
**/

function expiryAlert(){
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
			
	$db = db_connect();
	
	$currentDate=date('Y-m-d');
	$expiryAlertDate=getPreviousOrFututrDate($date='', $interval='-7 day' ,$format='Y-m-d');
	$mediaExpiryDate =  date( "d F Y", strtotime( "$currentDate +7 day" ) );
	
	$sql='SELECT uc.*, (item).title as itemtitle,(item).userid,(item).creative_name,(item).category,(item).categoryid,(item).work_type,(item).industryid,(item).industry, ua."email"
	from "TDS_UserContainer" as uc, "TDS_search" as s, "TDS_UserAuth" as ua     
	where uc."entityId" > 0 AND uc."elementId" > 0 AND uc."expiryDate" >= \''.$expiryAlertDate.'\' AND uc."expiryDate" <= \''.$currentDate.'\' AND uc."isExpired" = \'f\' AND s.entityid=uc."entityId" AND s.elementid=uc."elementId" AND ua."tdsUid"=uc."tdsUid"';
	
	$res = pg_query($db, $sql);
	
	
	if($res){
		$sql='SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'toolexpiring\' AND "active" =1 LIMIT 1';
		$resTemplate = pg_query($db, $sql);
		$template=pg_fetch_assoc($resTemplate);
		
		$mediasql = 'SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'mediatoolexpiring\' AND "active" =1 LIMIT 1';
		$mediaresTemplate = pg_query($db, $mediasql);
		$mediatemplate = pg_fetch_assoc($mediaresTemplate);
		
		$sqlExpired='SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'toolexpired\' AND "active" =1 LIMIT 1';
		$expiredTmpl = pg_query($db, $sqlExpired);
		$expiredTemplate=pg_fetch_assoc($expiredTmpl);
		
		$sqlTmail='SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'tmailtoolexpiring\' AND "active" =1 LIMIT 1';
		$resTemplateTmail = pg_query($db, $sqlTmail);
		$templateTmail=pg_fetch_assoc($resTemplateTmail);
		
		$sqlExpiredTmail='SELECT * from "TDS_EmailTemplates" WHERE "purpose" = \'tmailtoolexpired\' AND "active" =1 LIMIT 1';
		$expiredTmplTmail = pg_query($db, $sqlExpiredTmail);
		$expiredTemplateTmail=pg_fetch_assoc($expiredTmplTmail);
		
		$user_id=false;
		while ($row = pg_fetch_assoc($res)) {
			
			
			if(isset($row['entityId']) && isset($row['elementId']) && $row['entityId'] > 0 && $row['elementId'] >0){
				
				$personName=$row['creative_name'];
				
				
				if($SERVERADDR=='94.242.251.14'){ 
					// Staging K119.server.lu, 94.242.251.14
					$site_url = $site_base_url = 'http://staging.toadsquare.com/';
				}
				elseif($SERVERADDR == '94.242.254.30'){
					//Live L221.server.lu 94.242.254.30
					$site_url = $site_base_url = 'http://www.toadsquare.com/';
				}
				else{
					//Developement
					$site_url = $site_base_url = 'http://115.113.182.141/toadsquare_branch/dev/';
				}
			
				
				//$tool_title = $row['itemtitle'].' of '.$row['title'];
				$tool_text = '';
				$tool_title = $row['itemtitle'];
				$tool_item_title = ' of '.$row['title'];
				
				$dashboard_url = $site_url.'dashboard/';
				
				switch($row['entityId']){
					case 93: 
						$dashboard_url.='showcase';
						$tool_text = 'Your';
						$tool_title = $row['title']; // set single container tool title
						$tool_item_title = '';
						break;
					case 86: 
						$dashboard_url.='workprofile';
						$tool_text = 'Your';
						$tool_title = $row['title']; // set single container tool title
						$tool_item_title = '';
						break;
					case 71: 
						$dashboard_url.='upcoming';
						break;
					case 82: 
						$dashboard_url.='work';
						break;
					case 49: 
						$dashboard_url.='products';
						break;
					case 97: 
						$dashboard_url.='blog';
						$tool_text = 'Your';
						$tool_title = $row['title']; // set single container tool title
						$tool_item_title = '';
						break;
					case 9:
					case 15: 
						$dashboard_url.='performancesevents';
						break;
					case 54: 
						if($row['pkgSections']=='{1}'){
							$dashboard_url.='media/filmvideo/editmediacollection'; 
						}elseif($row['pkgSections']=='{2}'){
							$dashboard_url.='media/musicaudio/editmediacollection';
						}elseif($row['pkgSections']=='{3}' || $row['pkgSections']=='{3:1}' || $row['pkgSections']=='{3:2}'){
							$dashboard_url.='media/writingpublishing/editmediacollection'; 
						}elseif($row['pkgSections']=='{4}'){
							$dashboard_url.='media/photographyart/editmediacollection'; 
						}elseif($row['pkgSections']=='{10}'){
							$dashboard_url.='media/educationmaterials/editmediacollection'; 
						}
						break;
						
					default:
						$dashboard_url = $site_url.'dashboard/';
								
				}
				
				/* while we don't remove restriction (username, password) in .htacess file  from live site*/
				$image_base_url = 'http://115.113.182.141/toadsquare_branch/dev/images/email_images/';
				$crave_us = 'http://www.toadsquare.com/en/showcase/index/4';
				$facebook_follow_url = 'http://www.facebook.com/pages/Toadsquare/121921117888970';
				$linkedin_follow_url = 'http://www.linkedin.com/company/toadsquare?trk=hb_tab_compy_id_3001132';
				$twitter_follow_url = 'https://twitter.com/Toadsquare';
				$google_follow_url = 'https://plus.google.com/113568803978838695517/posts';

				
				$expiryDateInt=strtotime($row['expiryDate']);
				$currentDateInt=strtotime($currentDate);
				$tool_url = $dashboard_url;
				//---------current condition '<' ----------//
				if($expiryDateInt < $currentDateInt){
					$template=$expiredTemplate;
					$templateTmail=$expiredTemplateTmail;
					$updateSql='UPDATE "TDS_UserContainer" SET "isExpired" = \'t\', "isSentExpiryMail" = \'t\'  WHERE "userContainerId" = '.$row['userContainerId'];
				}else{
					$updateSql='UPDATE "TDS_UserContainer" SET "isSentExpiryMail" = \'t\'  WHERE "userContainerId" = '.$row['userContainerId'];
				}
				
				if( $row['entityId'] == 54 ) {
					$template = $mediatemplate;
				}
				
				if(is_array($template) && count($template) > 0) {
					$reportTemplate=$template['templates'];
					$reportTemplateTmail=$templateTmail['templates'];
					$subject=$template['subject'];
					$subjectTmail=$templateTmail['subject'];
					
					$searchArray = array("{tool_url}","{tool_title}" ,"{tool_text}" ,"{tool_item_title}" , "{dashboard_url}" , "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{subject}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}","{media_expiry_date}");
					$replaceArray = array($tool_url,$tool_title,$tool_text,$tool_item_title,$dashboard_url,$site_url,$site_base_url,$image_base_url,$crave_us,$subject,$facebook_follow_url,$linkedin_follow_url,$twitter_follow_url,$google_follow_url,$mediaExpiryDate);
					
					$replaceArrayTmail = array($tool_url,$tool_title,$tool_text,$tool_item_title,$dashboard_url,$site_url,$site_base_url,$image_base_url,$crave_us,$subjectTmail);
					$message=str_replace($searchArray, $replaceArray, $reportTemplate);
					$messageTmail=str_replace($searchArray, $replaceArrayTmail, $reportTemplateTmail);
				
				
				
				}
				else {
					$message='';
					$subject='';
				}
				
				$user_id=$row['tdsUid'];
				
				$isUser=False;
				$usersql='SELECT "active","email" FROM "TDS_UserAuth" WHERE "tdsUid" = '.$user_id.' AND "active" = 1 LIMIT 1';
				$userResult = pg_query($db, $usersql);
				
				if($userResult){
					$userInfo = pg_fetch_assoc($userResult);
					$email= $userInfo['email'];
					$isUser=true;
				}
				
				if($isUser){
					
					if((!empty($messageTmail)) && (!empty($subjectTmail))){
						if($expiryDateInt < $currentDateInt || ($row['isSentExpiryMail'] == 'f')){
							
							 send_tmail_template($user_id,$messageTmail,$subjectTmail);		
						}
					}
					
					if((!empty($message)) && (!empty($subject))){
						if($expiryDateInt < $currentDateInt || ($row['isSentExpiryMail'] == 'f')){
							$resultExpiry = pg_query($db, $updateSql) ;
							send_email_template($email,$personName,$message,$subject);	
						}
					}
				}
				
			}
		}
		
		
	}
}

function send_tmail_template($user_id,$body,$subject){
	
	if($user_id > 0){
		$thread_id = insert_thread($subject);
		if($thread_id > 0){
			$type=9; //sent tmail by system for expire project
			$msg_id = insert_message($thread_id, $body, $subject, $type);
			
			if($msg_id > 0){
				$isinserted=insert_participants($user_id, $thread_id, $msg_id);
			}
		}
	}
}

function insert_thread($subject)
{
		$db = db_connect();
		$thread_id = false;
		
		$SQL = 'INSERT INTO "TDS_tmail_threads" ("subject") VALUES (\''.pg_escape_string($subject).'\') ';
		$query = pg_query($db, $SQL);
		if($query){
			$insert_query = 'SELECT lastval();';
			$insert_row = pg_fetch_row(pg_query($insert_query));
			$thread_id= $insert_row[0];
		}
		return $thread_id;
}

function insert_message($thread_id, $body, $subject, $type)
{
	$db = db_connect();
	$msg_id = false;
	
	$SQL = 'INSERT INTO "TDS_tmail_messages" ("thread_id","body","subject","type") VALUES ('.$thread_id.', \''.pg_escape_string($body).'\', \''.pg_escape_string($subject).'\', '.$type.') ';
	$query = pg_query($db, $SQL);
	if($query){
		$insert_query = 'SELECT lastval();';
		$insert_row = pg_fetch_row(pg_query($insert_query));
		$msg_id= $insert_row[0];
	}
	return $msg_id;

}

function insert_participants($user_id, $thread_id, $msg_id)
{
	$db = db_connect();
	$SQL = 'INSERT INTO "TDS_tmail_participants" ("user_id","thread_id","msg_id","is_sender") VALUES ('.$user_id.','.$thread_id.','.$msg_id.', \'f\') ';
	$query = pg_query($db, $SQL);
	return $query;
}


function send_email_template($email,$personName,$body,$subject){
	include_once(dirname(dirname(__FILE__)).'/configurationCheck/mail/phpmailer/class.phpmailer'.EXT);
	
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	if($SERVERADDR=='94.242.251.14'){ 
		
		$Host="mail.toadsquare.com";
		$Username="noreply@toadsquare.com";
		$Password="und3rc0v3r";
	}
	elseif($SERVERADDR == '94.242.254.30'){
		$Host="mail.toadsquare.com";
		$Username="noreply@toadsquare.com";
		$Password="und3rc0v3r";
	}
	else{
		$Host="mail.cdnsol.com";
		$Username="admin@cdnsol.com";
		$Password="oNqN=vG0gTWt";
	}
	
	
	$mail = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->IsHTML(true);                                   // send via SMTP
	$mail->Host     = $Host;
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = $Username;  // SMTP username
	$mail->Password = $Password; // SMTP password

	$mail->From     = "noreply@toadsquare.com";
	$mail->FromName = "Toadsquare";
	$mail->AddReplyTo($mail->From, $mail->FromName);
	$mail->AddAddress($email,$personName);
	$mail->WordWrap = 50;                              // set word wrap
	$mail->Subject  =  $subject;
	$mail->Body     =  $body;
	$mail->AltBody  =  "mesage body not found";
	


	if(!$mail->Send())
	{
	   log_message("INFO",":: Mailer Error: ".$mail->ErrorInfo.", ".date("D M j G:i:s T Y")."");
	}else{
		log_message("INFO",":: expiry tool message successfully sent to: $personName  <".$email.">, ".date("D M j G:i:s T Y")."");
	}
}

function getPreviousOrFututrDate($date='', $interval='-1 month' ,$format='Y-m-d H:i:s'){
	if($date != ''){
		$date=date($format);
	}
	$date = new DateTime($date);
	$date->modify($interval);
	return $date->format($format);
}
?>
