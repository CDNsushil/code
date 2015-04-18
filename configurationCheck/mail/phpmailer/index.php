<html>
<head>
<title>PHPMailer - SMTP advanced test with authentication</title>
</head>
<body>

<?php

require_once('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "email-smtp.us-east-1.amazonaws.com"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = TRUE;                  // enable SMTP authentication
  //$mail->SMTPSecure = "tls";
  $mail->Host       = "ssl://email-smtp.us-east-1.amazonaws.com"; // sets the SMTP server
  $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
  $mail->Username   = "AKIAIF7YGFIM6G2KVUEA"; // SMTP account username
  $mail->Password   = "AryUPdeRVkp57pzRdrXu9r+0mi602odWTehGd7lhZnfM";        // SMTP account password
  //$mail->set_newline("\r\n");
  $mail->AddReplyTo('info@tablegrabber.com', 'First Last');
  $mail->AddAddress('anoop@cdnsol.com', 'John Doe');
  $mail->SetFrom('info@tablegrabber.com', 'First Last');
    
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML("ok now mail bosy have text");
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>

</body>
</html>
