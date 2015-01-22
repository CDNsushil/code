<?php

/**
 
 * @Author : Amit Wali
 * @Email  : amitwali@cdnsol.com
 * @Timestamp : June-3-13  
 * @Copyright : www.cdnsol.com 
 
**/

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


function send_email_template($email,$personName,$body,$subject,$path='',$isbcc=''){
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
	
	$mail->AddAttachment($path);
	
	$mail->AddBCC($isbcc);
	


	if(!$mail->Send())
	{
	   log_message("INFO",":: Mailer Error: ".$mail->ErrorInfo.", ".date("D M j G:i:s T Y")."");
	}else{
		log_message("INFO",":: expiry tool message successfully sent to: $personName  <".$email.">, ".date("D M j G:i:s T Y")."");
	}
}
