<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if($eventNatureId==4) $launchEventId='launchEventId';
else $launchEventId='';
	echo Modules::run("additionalInfo/addInfoSesTimePanel",$tableId,$eventId,$this->uri->uri_string(),'eventId',$launchEventId,0,0,$sessionId); 
?> 

