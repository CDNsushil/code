<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

if($isExternal==1)
	$fileType = 2;
else 
	$fileType = 'external';				
	
if($videoPath=='')
{
$imgIntroductorySrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
}
else
{
$imgIntroductorySrc = '<img  id ="showVideo'.$browseId.'"  width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$videoPath.'\',\''.$fileType.'\',5);" />';
}

echo $imgIntroductorySrc;

?>
