<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
//Variables for social media links
$socialListFormAttributes = array(
	'name'=>'socialListForm',
	'id'=>'socialListForm'
);
$currentId = array(
	'name'=>'socialLinkCurrentId',
	'id'=>'socialLinkCurrentId',
	'type'=>'hidden'
);

$swapId = array(
	'name'=>'socialLinkSwapId',
	'id'=>'socialLinkSwapId',
	'type'=>'hidden'
);

$currentPosition = array(
	'name'=>'socialLinkCurrentPosition',
	'id'=>'socialLinkCurrentPosition',
	'type'=>'hidden'
);

$swapPosition = array(
	'name'=>'socialLinkSwapPosition',
	'id'=>'socialLinkSwapPosition',
	'type'=>'hidden'
);
if(count($socialLinks)>0){
echo form_open('showcase/shiftSocialLink',$socialListFormAttributes);
echo form_hidden('socialLinkIdForDelete','');	
echo form_hidden('socialLinkIdForSwap','');	
echo form_input($currentId);	
echo form_input($swapId);
echo form_input($currentPosition);
echo form_input($swapPosition);
		   
$countRecord =  count($socialLinks)-1;
$isocialLinks = 0; 
?>
<div id="frm_wp">
<div class="row">
<div class="cell" style="width:428px;"><div class="listing_title_orng"><?php echo $label['title'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['Date'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php

foreach($socialLinks  as $k=>$socialLinksItem)
{
	
	if($socialLinksItem->socialLinkDateCreated==NULL && $socialLinksItem->socialLinkDateModified==NULL)
		$socialLinkDate = 'N\A';
		else{
			if($socialLinksItem->socialLinkDateModified==NULL) $socialLinkDate = date("F d, Y", strtotime($socialLinksItem->socialLinkDateCreated));
			else $socialLinkDate = date("F d, Y", strtotime($socialLinksItem->socialLinkDateModified));
		}
	
?>
		
<div class="row">
<div class="cell" style="max-width:16px;min-width:16px; padding-right:2px;">
<img class="formTip HoverBorder" src="<?php echo base_url().$socialLinksItem->profileSocialMediaPath;?>" style="margin:auto; cursor:pointer" title="<?php echo $socialLinksItem->profileSocialMediaName;?>" />
</div>

<div class="cell" style="max-width:484px;min-width:484px;"><?php echo $socialLinksItem->socialLink;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>

<div class="cell" style="max-width:100px;"><?php echo $socialLinkDate;?></div>
<div class="cell title-content title-content-right title-content-center tds-button-top" style="width:100px;text-align:center">
<?php
							
	$editArr = array('title'=>$label['edit'],
	'class'=>"formTip SocialNetworkingId",
	'id'=>"SocialNetworkingId", 
	'titlehere'=>$socialLinksItem->socialLink, 
	'socialLinkType'=>$socialLinksItem->socialLinkType,
	'mySocialLinkId'=>$socialLinksItem->showcaseSocialLinkId, 
	);
	
	echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);	
	
	//History Delete Icon
	$attr = array("onclick"=>"socialLinkIDeleteAction('".encode($socialLinksItem->showcaseSocialLinkId)."')","title"=>$label['delete'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);

	if($isocialLinks!=$countRecord)
	{
		$moveDown = array("onclick"=>"moveSocialDown('".encode($socialLinksItem->showcaseSocialLinkId)."','".encode(@$socialLinks[$k+1]->showcaseSocialLinkId)."','".$socialLinksItem->position."','".@$socialLinks[$k+1]->position."')",'title'=>$label['moveDown'],'class'=>'formTip');
		echo anchor('javascript://void(0);','<span><div class="projectDownRecord"></div></span>',$moveDown);
	}else
	{
		$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
		echo anchor('javascript://void(0);','<span><div class="projectDownRecordDisabled"></div></span>',$moveDown);
	}
	
	if($isocialLinks!=0)
	{
		$moveUp = array("onclick"=>"moveSocialUp('".encode($socialLinksItem->showcaseSocialLinkId)."','".encode(@$socialLinks[$k-1]->showcaseSocialLinkId)."','".$socialLinksItem->position."','".@$socialLinks[$k-1]->position."')",'title'=>$label['moveUp'],'class'=>'formTip');
		echo anchor('javascript://void(0);', '<span><div class="projectUpRecord"></div></span>',$moveUp);
	}else
	{
		$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
		echo anchor('javascript://void(0);', '<span><div class="projectUpRecordDisabled"></div></span>',$moveUp);
	}
	
?>
	</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php
$isocialLinks++;
}
echo '</form>';
}
else{
echo '<div id="SOCIALNETWORKING-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['SOCIALNETWORKING'],array('class'=>'formTip','title'=>$label['SOCIALNETWORKING'],'onclick'=>'showRelatedForm(\'SOCIALNETWORKINGForm-Content-Box\',\'SOCIALNETWORKING-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>	';
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.SocialNetworkingId').click(function(){
		var title = $(this).attr('titlehere');
		var socialLink = $(this).attr('socialLink');
		var mySocialLinkId = $(this).attr('mySocialLinkId');
		var socialLinkType =	$(this).attr('socialLinkType');
		$('#socialLink').val(title);
		$('#showcaseSocialLinkId').val(mySocialLinkId);
		$("#socialLinkType").val(socialLinkType);

		document.getElementById('SOCIALNETWORKINGForm-Content-Box').style.display = 'block';
	
	});

});
</script>
<script language="javascript" type="text/javascript">
function socialLinkIDeleteAction(socialLinkIdForDelete)
{
	//alert(profileSocialLinkId);
	var conBox = confirm(areYouSure);
	if(conBox){
		document.socialListForm.socialLinkIdForDelete.value = socialLinkIdForDelete;
		document.socialListForm.submit();
	}
	else{
		return false;
	}	
}

function moveSocialUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#socialLinkCurrentId').val(currentId);
	$('#socialLinkSwapId').val(swapId);
	$('#socialLinkCurrentPosition').val(currentPosition);
	$('#socialLinkSwapPosition').val(swapPosition);
	
	document.socialListForm.socialLinkIdForSwap.value =1;
	document.socialListForm.submit();
}

function moveSocialDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#socialLinkCurrentId').val(currentId);
	$('#socialLinkSwapId').val(swapId);
	$('#socialLinkCurrentPosition').val(currentPosition);
	$('#socialLinkSwapPosition').val(swapPosition);
	document.socialListForm.socialLinkIdForSwap.value =1;
	document.socialListForm.submit();
}
</script>
