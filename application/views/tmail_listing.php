<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="author" content="CDN" />
	<meta name="description" content="movie, film, music,toadsquare." />
	
	<link type="text/css" href="<?php echo base_url().'templates/default/css/allStyle.css';?>" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo base_url().'templates/default/css/template.css';?>" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo base_url().'templates/system/css/common.css';?>" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo base_url().'templates/system/css/jquery-ui.css';?>" rel="stylesheet" media="all" />
	<script type="text/javascript" language="javascript">
	/*Function to acivate disabled checkbox */
	$(document).ready(function(){
		$(".lb_overlay js_lb_overlay").css({ position: 'fixed'});
	});
	</script>
	<script type="text/javascript" language="javascript">
	// <![CDATA[
		var baseUrl= '<?php echo base_url();?>' ; 
		var language= 'en' ; 
	// ]]>
	</script>
	<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/jquery-lib/jquery.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/common.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/jquery-plugin/lightboxme-2.3/jquery.lightboxmev1.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/common/lightboxme-common.js';?>"></script>
</head><body>	
<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div style="border: 1px solid #C9C9C9; width: 560px; background:#F9F9F9" class="makeShowcaseBetter">
<div class="tmailtop_gradient minH60 bdr_e2e2e2 mt1 ml1 mr1">									
<div style="height: 14px;width: 100%;"></div>
<div style="margin:0 10px 10px 10px; min-height:200px; padding:0 15px 0 15px; color:#444444;">
	<a href="javascript:void(0)" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','reminder_tmail')" style="color:#848484;">A Reminder</a>	
	<div style="height: 5px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','date_tmail')">Date Change</a>	
	<div style="height: 5px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','delete_event_tmail')">Deleted Event</a>	
	<div style="height: 5px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','refund_tmail')">Your Refund from Toadsquare</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','membership_expire_tmail')">Your Toadsquare Membership is Expiring</a>
	<div style="height: 10px;width: 100%;"></div>	
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','tool_expire_tmail')">Your Toadsquare Tool is Expiring</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','purchase_tmail')">Your Purchase</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','ticket_tmail')">Your Tickets</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','sale_tmail')">Your Sale</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','personal_tmail')">Report a Problem(Personal)</a>	
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','illegal_tmail')">Report a Problem(Illegal)</a>
	<div style="height: 10px;width: 100%;"></div>	
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','other_illegal_tmail')">Report a Problem(Other)</a>
	<div style="height: 10px;width: 100%;"></div>	
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','terms_tmail')">Updated Terms & Conditions</a>
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','update_price_tmail')">Updated Prices</a>
	<div style="height: 10px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','tool_purchase_tmail')">Your Purchase from Toadsquare</a>
	<div style="height: 5px;width: 100%;"></div>
	<a href="javascript:void(0)" style="color:#848484;" onclick="openLightBox('popupBoxWp','popup_box','/test/tmail_display','welcome_tmail')">Welcome to Toadsquare</a>	
</div>
</div>


	</body>
</html>
