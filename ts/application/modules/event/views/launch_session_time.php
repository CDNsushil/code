<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/*
if($sessionId>0)
	echo Modules::run("additionalInfo/addInfoSesTimePanel",$tableId,$sessionId,$this->uri->uri_string(),'sessionId'); 
else
*/

echo Modules::run("additionalInfo/addInfoSesTimePanel",'15',$eventId,$this->uri->uri_string(),'eventId','launchEventId',$launchEventId,0,$sessionId); 
?>
		
