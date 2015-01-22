<?php 
require("class.phpmailer.php");
$regis_email =	'nitin9193@gmail.com';
			
/****** send actvation code to registered user - start ***********/
$mail = new PHPMailer();
$mail->IsSMTP();                 	// set mailer to use SMTP
$mail->Host = "mail.cdnsolutionsgroup.com";  		// specify main and backup server
$mail->SMTPAuth = true;     		// turn on SMTP authentication
$mail->CharSet="windows-1251";
$mail->CharSet="utf-8";
$mail->Username = "admin@cdnsolutionsgroup.com";  	// SMTP username
$mail->Password = "a1-b2-c3"; 	// SMTP password
$mail->From = "neerajsharma@cdnsol.com";
$mail->FromName = "neerajsharma@cdnsol.com";
$mail->AddAddress($regis_email);	//sender user email id
$mail->WordWrap = 50;      			// set word wrap to 50 characters
$mail->IsHTML(true);      			// set email format to HTML
$mail->Subject = utf8_encode("Neeraj");
$mail->Body    = utf8_encode("test body");

if($mail->Send())
{
	echo "Mail send";
}
else
{
	echo "Mail not send";
}

echo "<pre/>";
print_r($mail);


?>
