<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
//Variables for reviews form
$reviewsFormAttributes = array(
	'name'=>'reviewsListForm',
	'id'=>'reviewsListForm'
);

$currentId = array(
	'name'=>'reviewCurrentId',
	'id'=>'reviewCurrentId',
	'type'=>'hidden'
);

$swapId = array(
	'name'=>'reviewSwapId',
	'id'=>'reviewSwapId',
	'type'=>'hidden'
);

$currentPosition = array(
	'name'=>'reviewCurrentPosition',
	'id'=>'reviewCurrentPosition',
	'type'=>'hidden'
);

$swapPosition = array(
	'name'=>'reviewSwapPosition',
	'id'=>'reviewSwapPosition',
	'type'=>'hidden'
);



if(count($reviews)>0){
echo form_open('showcase/shiftReviews',$reviewsFormAttributes);
echo form_hidden('reviewsIdForDelete','');	
echo form_hidden('reviewsIdForSwap','');	
echo form_input($currentId);	
echo form_input($swapId);
echo form_input($currentPosition);
echo form_input($swapPosition);

$countRecord =  count($reviews)-1;
$ireviews = 0; 
?>
<div class="row">
<div class="cell" style="width:375px;"><div class="listing_title_orng"><?php echo $label['title'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" ><div class="listing_title_orng"><?php echo $label['writerName'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['Date'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>

<?php

foreach($reviews as $k=>$reviewsItem)
{	
	if($reviewsItem->reviewsPublishDate==NULL) $reviewDate = date("F d, Y", strtotime($reviewsItem->reviewsCreateDate));
	else $reviewDate = date("F d, Y", strtotime($reviewsItem->reviewsPublishDate));	
	
	$publishDate = date("Y-m-d", strtotime($reviewsItem->reviewsPublishDate));
	
	$title = htmlentities(addslashes($reviewsItem->reviewsTitle),ENT_QUOTES);
	$writer = htmlentities(addslashes($reviewsItem->reviewsWriter),ENT_QUOTES);
	if($reviewsItem->uploadVideoType == 't') {
		$flag = 1;		
	}
	else{
		$flag = 0;		
	}
	
	$embedvalue = $reviewsItem->reviewsEmbed;
?>
		
<div class="row">
<div class="cell" style="max-width:428px;min-width:428px;"><?php echo $reviewsItem->reviewsTitle;?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:150px;min-width:150px;"><?php echo $reviewsItem->reviewsWriter;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:100px;"><?php echo $reviewDate;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell title-content title-content-right title-content-center tds-button-top" style="width:100px;text-align:center">
<?php
	//Reviews Edit Icon
							
	$editArr = array('title'=>$label['edit'],
	'class'=>"formTip ReviewsId",
	'id'=>"ReviewsId", 
	'flag'=> $flag,
	'titlehere'=>$title, 
	'writer'=> $writer, 
	'myReviewsId'=>$reviewsItem->showcaseReviewsId, 
	'embed'=>$embedvalue, 
	'reviewsLanguage'=> $reviewsItem->reviewsLanguage, 
	'publishDate'=>$publishDate
	);
	
	echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);	
	
	//Reviews Delete Icon
	$attr = array("onclick"=>"DeleteReviewsAction('".encode($reviewsItem->showcaseReviewsId)."')","title"=>$label['delete'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);

if($ireviews!=$countRecord)
{
	$moveDown = array("onclick"=>"moveReviewsDown('".encode($reviewsItem->showcaseReviewsId)."','".encode(@$reviews[$k+1]->showcaseReviewsId)."','".$reviewsItem->position."','".@$reviews[$k+1]->position."')",'title'=>$label['moveDown'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDownRecord"></div></span>',$moveDown);
}
else
{
	$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDownRecordDisabled"></div></span>',$moveDown);
}
	
if($ireviews!=0)
{		
	$moveUp = array("onclick"=>"moveReviewsUp('".encode($reviewsItem->showcaseReviewsId)."','".encode(@$reviews[$k-1]->showcaseReviewsId)."','".$reviewsItem->position."','".@$reviews[$k-1]->position."')",'title'=>$label['moveUp'],'class'=>'formTip');
	echo anchor('javascript://void(0);', '<span><div class="projectUpRecord"></div></span>',$moveUp);
}
else
{
	$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
	echo anchor('javascript://void(0);', '<span><div class="projectUpRecordDisabled"></div></span>',$moveUp);
}
							
?>
	</div>
</div>
<?php
$ireviews++;
echo '</form>';
}
echo '<div class="row heightSpacer">&nbsp;</div>';
}
else{
echo '<div id="Reviews-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['REVIEWS'],array('class'=>'formTip','title'=>$label['REVIEWS'],'onclick'=>'showRelatedForm(\'REVIEWSForm-Content-Box\',\'Reviews-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.ReviewsId').click(function(){
		var flag = $(this).attr('flag');
		var embedvalue = $(this).attr('embed');
		var title = $(this).attr('titlehere');
		var writerName = $(this).attr('writer');
		var reviewsLanguage = $(this).attr('reviewsLanguage');
		var publishDate = $(this).attr('publishDate');
		var myReviewsId = $(this).attr('myReviewsId');
		if(flag == 1) {		
			$('#showReviewsVideo').show();
			$('#showReviewsURL').hide();
			$('#reviewsEmbbededVideo').val(embedvalue);
		}
		else{
			$('#showReviewsVideo').hide();
			$('#showReviewsURL').show();
		
			$('#reviewsEmbbededURL').val(embedvalue);
		}
		$('#reviewstitle').val(title);
		$('#reviewswriterName').val(writerName);
		$('#reviewsPublishDate').val(publishDate);
		$('#reviewsLanguage').parent().find('.abc').text(reviewsLanguage);
		$('#reviewsLanguage').val(reviewsLanguage);
		$('#showcaseReviewsId').val(myReviewsId);
		$('#reviewEmbedDIv').hide();
		document.getElementById('REVIEWSForm-Content-Box').style.display = 'block';
	
	});

});

function DeleteReviewsAction(reviewsIdForDelete)
{
	//alert(profileSocialLinkId);
	var conBox = confirm(areYouSure);
	if(conBox){
		document.reviewsListForm.reviewsIdForDelete.value = reviewsIdForDelete;
		document.reviewsListForm.submit();
		document.getElementById('REVIEWSForm-Content-Box').style.display = 'block';
	}
	else{
		return false;
	}	
}

function moveReviewsUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#reviewCurrentId').val(currentId);
	$('#reviewSwapId').val(swapId);
	$('#reviewCurrentPosition').val(currentPosition);
	$('#reviewSwapPosition').val(swapPosition);
	document.reviewsListForm.reviewsIdForSwap.value = 1;
	document.reviewsListForm.submit();
		
}

function moveReviewsDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#reviewCurrentId').val(currentId);
	$('#reviewSwapId').val(swapId);
	$('#reviewCurrentPosition').val(currentPosition);
	$('#reviewSwapPosition').val(swapPosition);
	document.reviewsListForm.reviewsIdForSwap.value = 1;
	document.reviewsListForm.submit();
	
}
</script>
