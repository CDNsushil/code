<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

	// get loggedin userId
	$userId = (isLoginUser())?isLoginUser():0;
	if($userId){
		$actionFunction = "sorlistNunshortlist('".$userId."','".$competitionId."','".$competitionEntryId."')";
	}else{	
	$beforeSortlistLoggedIn = $this->lang->line('compeEntriesShorlistLoggedInMsg');
		$actionFunction = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeSortlistLoggedIn."')";
	}
?>

<!---------sortlist button for entries full view--------->
<?php if($buttonSection=='entriesFullView') { ?>
	<div class="<?php echo $buttonDivClass ?> fl ml34 mt12 zindex_999 position_relative">
		<a onclick="<?php echo  $actionFunction;  ?>"  onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)" style="background-position: 0px 0px; "><span class="font_size18 lineH26 width_80 clr_black" style="background-position: 100% 0px; ">Short List</span></a>
	</div>
<?php } ?>	

<!---------sortlist button for entries sort view--------->
<?php if($buttonSection=='entriesSortView') { ?>
	<div class="<?php echo $buttonDivClass ?> fl ml5 mt-4">
		<a onclick="<?php echo  $actionFunction;  ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 lineH26 width_80 clr_black">Short List</span></a>
	</div>
<?php } ?>	


<!---------sortlist button for entries sort view--------->
<?php if($buttonSection=='entriesDetails') { ?>
	<div class="<?php echo $buttonDivClass ?> fl ml5 mt-4">
		<a onclick="<?php echo  $actionFunction;  ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 lineH26 widht_106 clr_black">Short List</span></a>
	</div>
<?php } ?>	
