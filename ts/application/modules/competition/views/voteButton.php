<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

	// get loggedin userId
	$userId = (isLoginUser())?isLoginUser():0;
	if($userId){
		$actionFunction = "voteInsert('".$userId."','".$competitionId."','".$competitionEntryId."')";
	}else{	
	$beforeSortlistLoggedIn = $this->lang->line('compeEntriesVoteLoggedInMsg');
		$actionFunction = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeSortlistLoggedIn."')";
	}	
?>

<!---------vote button for entries full view--------->
<?php if($buttonSection=='entriesFullView') { ?>
	<div class="<?php echo $buttonDivClass ?> fl ml34 mt12 zindex_999 position_relative">
		<a onclick="<?php echo $actionFunction; ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 lineH26 width_65 clr_black">Vote</span></a>
	</div>
<?php } ?>	

<!---------vote button for entries sort view--------->
<?php if($buttonSection=='entriesSortView') { ?>
<div class="<?php echo $buttonDivClass ?> fl ml5 mt-4">
	<a  onclick="<?php echo $actionFunction; ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 lineH26 width_60 clr_black">Vote</span></a>
</div>
<?php } ?>	


<!---------vote button for entries sort view--------->
<?php if($buttonSection=='entriesDetails') { ?>
<div class="<?php echo $buttonDivClass ?> fl ml5 mt-4">
	<a  onclick="<?php echo $actionFunction; ?>" onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size18 lineH26 widht_106 clr_black">Vote</span></a>
</div>
<?php } ?>	
