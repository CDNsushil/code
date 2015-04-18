<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
//Variables for news form
$awardsFormAttributes = array(
	'name'=>'awardsListForm',
	'id'=>'awardsListForm'
);
$currentId = array(
	'name'=>'awardsCurrentId',
	'id'=>'awardsCurrentId',
	'type'=>'hidden'
);
$swapId = array(
	'name'=>'awardsSwapId',
	'id'=>'awardsSwapId',
	'type'=>'hidden'
);
$currentPosition = array(
	'name'=>'awardsCurrentPosition',
	'id'=>'awardsCurrentPosition',
	'type'=>'hidden'
);
$swapPosition = array(
	'name'=>'awardsSwapPosition',
	'id'=>'awardsSwapPosition',
	'type'=>'hidden'
);

echo form_open('showcase/shiftAwards',$awardsFormAttributes);
echo form_hidden('awardsIdForDelete','');	
echo form_hidden('awardsIdForSwap','');	
echo form_input($currentId);	
echo form_input($swapId);
echo form_input($currentPosition);
echo form_input($swapPosition);

$countRecord =  count($awards)-1;
$iawards = 0; 
if(count($awards)>0){

?>
<div class="row">
<div class="cell" style="width:375px;"><div class="listing_title_orng"><?php echo $label['title'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['writerName'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['Date'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>

<?php
foreach($awards  as $k=>$awardsItem)
{
 $awardsCreateDate = date("F d, Y", strtotime($awardsItem->awardsCreateDate));
 $title = htmlentities(addslashes($awardsItem->awardsTitle),ENT_QUOTES);
 
 $tableName = 'UserContacts';
 $field = 'firstName,lastName';
 $whereField = 'uId';
 $whereValue = $awardsItem->uId;
 $userName = getDataFromTabelCommon($tableName,$field,$whereField,$whereValue);

 $postedUserName = ucfirst($userName[0]->firstName).' '.ucfirst($userName[0]->lastName);
 $writer = htmlentities(addslashes($postedUserName),ENT_QUOTES);
 $publishDate = date("Y-m-d", strtotime($awardsItem->awardsPublishDate));
	
?>		
<div class="row">
<!--<div class="cell"><input id="NewsId" class="NewsId" value="<?php echo $awardsItem->showcaseAwardsId;?>" type="checkbox" name="NewsId" /></div> -->
<!--<div class="cell" style="padding-left:10px;">&nbsp;</div>-->
<div class="cell" style="max-width:428px;min-width:428px; padding-top:4px;"><?php echo stripslashes($title);?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>

<div class="cell" style="max-width:150px;min-width:150px;padding-top:4px;"><?php echo stripslashes($writer);?></div>
<div class="cell" style="padding-left:10px;">&nbsp;</div>

<div class="cell" style="max-width:100px; padding-top:4px;"><?php echo $awardsCreateDate;?></div>

<div class="cell title-content title-content-right title-content-center tds-button-top" style="width:100px;text-align:center">
<?php

	$editArr = array(
		'title' => $label['edit'],
		'class' => "formTip AwardsId",
		'id' => "AwardsId", 
		'titlehere' => $title, 
		'writer' => $writer, 
		'myAwardsId' => $awardsItem->showcaseAwardsId, 
		'awardsUrl' => $awardsItem->awardsUrl, 
		'awardsDescription' => $awardsItem->awardsDescription, 
		'publishDate' => $publishDate
	);
		
	echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);	
	
	//Awards Delete Icon
	$attr = array("onclick"=>"awardsDeleteAction('".encode($awardsItem->showcaseAwardsId)."')","title"=>$label['delete'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
	
	if($iawards!=$countRecord)
	{
	$moveDown = array("onclick"=>"moveAwardsDown('".encode($awardsItem->showcaseAwardsId)."','".encode(@$awards[$k+1]->showcaseAwardsId)."','".$awardsItem->position."','".@$awards[$k+1]->position."')",'title'=>$label['moveDown'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDownRecord"></div></span>',$moveDown);
	}else
	{
	$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDownRecordDisabled"></div></span>',$moveDown);
	}
	
	if($iawards!=0)
	{
	$moveUp = array("onclick"=>"moveAwardsUp('".encode($awardsItem->showcaseAwardsId)."','".encode(@$awards[$k-1]->showcaseAwardsId)."','".$awardsItem->position."','".@$awards[$k-1]->position."')",'title'=>$label['moveUp'],'class'=>'formTip');
	echo anchor('javascript://void(0);', '<span><div class="projectUpRecord"></div></span>',$moveUp);
	}else
	{
	$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
	echo anchor('javascript://void(0);', '<span><div class="projectUpRecordDisabled"></div></span>',$moveUp);
	}

?>
</div>
</div>
<?php
$iawards++;
echo '</form>';
}
echo '<div class="row heightSpacer">&nbsp;</div>';
}
else{
echo '<div id="Awards-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['AWARDS'],array('class'=>'formTip','title'=>$label['AWARDS'],'onclick'=>'showRelatedForm(\'AWARDSForm-Content-Box\',\'Awards-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.AwardsId').click(function(){
		var flag = $(this).attr('flag');
		var embedvalue = $(this).attr('embed');
		var title = $(this).attr('titlehere');
		var writerName = $(this).attr('writer');
		var awardsUrl = $(this).attr('awardsUrl');
		var awardsDescription = $(this).attr('awardsDescription');
		var publishDate = $(this).attr('publishDate');
		var myAwardsId = $(this).attr('myAwardsId');
	
		$('#awardsTitle').val(title);
		$('#awardsPublishDate').val(publishDate);
		$('#awardsUrl').val(awardsUrl);
		$('#awardsDescription').val(awardsDescription);
		$('#showcaseAwardsId').val(myAwardsId);
		document.getElementById('AWARDSForm-Content-Box').style.display = 'block';
	
	});

});
</script>
<script language="javascript" type="text/javascript">
function awardsDeleteAction(awardsIdForDelete)
{
	//alert(profileSocialLinkId);
	var conBox = confirm(areYouSure);
	if(conBox){
		document.awardsListForm.awardsIdForDelete.value = awardsIdForDelete;
		document.awardsListForm.submit();
	}
	else{
		return false;
	}	
}

function moveAwardsUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#awardsCurrentId').val(currentId);
	$('#awardsSwapId').val(swapId);
	$('#awardsCurrentPosition').val(currentPosition);
	$('#awardsSwapPosition').val(swapPosition);
	document.awardsListForm.awardsIdForSwap.value = 1;
	document.awardsListForm.submit();	
}

function moveAwardsDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#awardsCurrentId').val(currentId);
	$('#awardsSwapId').val(swapId);
	$('#awardsCurrentPosition').val(currentPosition);
	$('#awardsSwapPosition').val(swapPosition);
	document.awardsListForm.awardsIdForSwap.value = 1;
	document.awardsListForm.submit();
}
</script>