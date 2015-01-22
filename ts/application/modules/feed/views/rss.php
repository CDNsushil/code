<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$loggedUserId = isloginUser();
$beforeCraveLoggedIn=$this->lang->line('beforeFeedLoggedIn');

if($loggedUserId > 0)
{	
	$attr = array('class'=>'orange ml5','onclick'=>'gotofeed();');
}
else
{
	$function = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeCraveLoggedIn."')";	
	$attr = array('target'=>'_self', 'class'=>'orange ml5 ','onclick'=>$function);
}

?>
<div class="fr mr23 mt10"><?php echo anchor('javascript://void(0);', '<div class="cell blogrss formTip" title="'.$this->lang->line('rssFeed').'"></div>',$attr);?></div>

<script>
function gotofeed()
{
	window.open(
	  baseUrl+language+'/feed/blog/<?php echo $userId;?>',
	  '_blank' // <- This is what makes it open in a new window.
	);
}
</script>
