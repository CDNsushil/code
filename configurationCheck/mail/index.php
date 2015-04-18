<?php

date_default_timezone_set('Europe/Luxembourg');
require("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();                                   // send via SMTP
//$mail->Host     = "83.243.8.6"; // SMTP servers
//$mail->Host     = "83.243.8.6"; // SMTP servers
//$mail->Host     = "69.63.149.30";
$mail->Host     = "mail.toadsquare.com";
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "noreply@toadsquare.com";  // SMTP username
$mail->Password = "und3rc0v3r"; // SMTP password

$mail->From     = "noreply@toadsquare.com";
$mail->FromName = "cdnsol";
	/*$mail->AddAddress("anoop@cdnsol.com","Anoop"); 
	$mail->AddAddress("perminder.jolly@gmail.com","Perminder"); */
	
	$mail->AddAddress("perminder@cdnsol.com","perminder");
	$mail->AddAddress("sushilmishra@cdnsol.com","Sushil");
	 
	
//$mail->AddAddress("ameen_shah11@yahoo.com");               // optional name
//$mail->AddReplyTo("amshah@cdnsol.com","Information");

$mail->WordWrap = 50;                              // set word wrap
//$mail->AddAttachment(dirname(__FILE__)."/Ticket1.pdf");      // attachment
//$mail->AddAttachment(dirname(__FILE__)."/Ticket2.pdf"); 
//$mail->AddAttachment(dirname(__FILE__)."/Ticket3.pdf");
$mail->IsHTML(true);                               // send as HTML

$mail->Subject  =  "Event ticket purchase";
$mail->Body     =  "Thank you for your purchase.<BR>Please download the tickets.";
$mail->AltBody  =  "Thank you for purchasing";

if(!$mail->Send())
{
   echo "Message was not sent <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";

?>
