<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$loggedUserId=isloginUser();
?>
<span>
	<a class="relationemail dash_link_hover" onclick="javascript:openLightBox('popupBoxWp','popup_box','/auction/bidList','<?php echo $auctionId;?>','<?php echo $projectTitle;?>');">
		<?php echo 'Bid list';?>
	</a>
</span>

