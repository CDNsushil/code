<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
//Variables for news form
$newsFormAttributes = array(
	'name'=>'newsListForm',
	'id'=>'newsListForm'
);
$currentId = array(
	'name'=>'currentId',
	'id'=>'currentId',
	'type'=>'hidden'
);
$swapId = array(
	'name'=>'swapId',
	'id'=>'swapId',
	'type'=>'hidden'
);
$currentPosition = array(
	'name'=>'currentPosition',
	'id'=>'currentPosition',
	'type'=>'hidden'
);
$swapPosition = array(
	'name'=>'swapPosition',
	'id'=>'swapPosition',
	'type'=>'hidden'
);


if(count($interviews)>0){
echo form_open('showcase/shiftNews',$newsFormAttributes);
echo form_hidden('newsIdForDelete','');	
echo form_hidden('newsIdForSwap','');	
echo form_input($currentId);	
echo form_input($swapId);
echo form_input($currentPosition);
echo form_input($swapPosition);

$countRecord =  count($news)-1;
$inews = 0; 
?>
<div class="row">
<div class="cell" style="width:375px;"><div class="listing_title_orng"><?php echo $label['title'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['writerName'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><div class="listing_title_orng"><?php echo $label['Date'];?></div></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<?php
foreach($news as $k=>$newsItem)
{
 
	$newsCreateDate = date("F d, Y", strtotime($newsItem->newsCreateDate));

	$publishDate = date("Y-m-d", strtotime($newsItem->newsPublishDate));
	
	$title = htmlentities(addslashes($newsItem->newsTitle),ENT_QUOTES);
	$writer = htmlentities(addslashes($newsItem->newsWriter),ENT_QUOTES);
	if($newsItem->uploadVideoType == 't') {
		$flag = 1;		
	}
	else{
		$flag = 0;		
	}
	
	$embedvalue = $newsItem->newsEmbed;
 //$tableName = 'UserContacts';
 //$field = 'firstName,lastName';
 //$whereField = 'uId';
 //$whereValue = $newsItem->uId;
 //$userName = getDataFromTabelCommon($tableName,$field,$whereField,$whereValue);

 //$postedUserName = ucfirst($userName[0]->firstName).' '.ucfirst($userName[0]->lastName);
 //$writer = htmlentities(addslashes($postedUserName),ENT_QUOTES);
 //$writer = htmlentities(addslashes($newsItem->newsWriter),ENT_QUOTES);
?>		
<div class="row">
<!--<div class="cell"><input id="NewsId" class="NewsId" value="<?php echo $newsItem->showcaseNewsId;?>" type="checkbox" name="NewsId" /></div> -->
<!--<div class="cell" style="padding-left:10px;">&nbsp;</div>-->
<div class="cell" style="max-width:428px;min-width:428px;"><?php echo stripslashes($title);?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>

<div class="cell" style="max-width:150px;min-width:150px;"><?php echo stripslashes($writer);?></div>
<div class="cell" style="padding-left:10px;">&nbsp;</div>

<div class="cell" style="max-width:100px;"><?php echo $newsCreateDate;?></div> 
<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell title-content title-content-right title-content-center tds-button-top" style="width:100px;text-align:center">
<?php
	
	$editArr = array('title'=>$label['edit'],
	'class'=>"formTip NewsId",
	'id'=>"NewsId", 
	'flag'=> $flag ,
	'titlehere'=>$title, 
	'writer'=> $writer, 
	'myNewsId'=>$newsItem->showcaseNewsId, 
	'embed'=>$embedvalue, 
	'newsLanguage'=> $newsItem->newsLanguage, 
	'publishDate'=>$publishDate
	);
	
	echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);	
	
	$attr = array("onclick"=>"newsDeleteAction('".encode($newsItem->showcaseNewsId)."')","title"=>$label['delete'],'class'=>'formTip');
	echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);

	if($inews!=$countRecord)
	{
		$moveDown = array("onclick"=>"moveNewsDown('".encode($newsItem->showcaseNewsId)."','".encode(@$news[$k+1]->showcaseNewsId)."','".$newsItem->position."','".@$news[$k+1]->position."')",'title'=>$label['moveDown'],'class'=>'formTip');
		echo anchor('javascript://void(0);','<span><div class="projectDownRecord"></div></span>',$moveDown);
	}else
	{
		$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
		echo anchor('javascript://void(0);','<span><div class="projectDownRecordDisabled"></div></span>',$moveDown);
	}
	
	if($inews!=0)
	{
		$moveUp = array("onclick"=>"moveNewsUp('".encode($newsItem->showcaseNewsId)."','".encode(@$news[$k-1]->showcaseNewsId)."','".$newsItem->position."','".@$news[$k-1]->position."')",'title'=>$label['moveUp'],'class'=>'formTip');
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
$inews++;
echo '</form>';
}
echo '<div class="row heightSpacer">&nbsp;</div>';
}
else{
echo '<div id="INTERVIEWS-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['INTERVIEWS'],array('class'=>'formTip','title'=>$label['INTERVIEWS'],'onclick'=>'showRelatedForm(\'INTERVIEWSForm-Content-Box\',\'INTERVIEWS-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.NewsId').click(function(){
		var flag = $(this).attr('flag');
		var embedvalue = $(this).attr('embed');
		var title = $(this).attr('titlehere');
		var writerName = $(this).attr('writer');
		var newsLanguage = $(this).attr('newsLanguage');
		var publishDate = $(this).attr('publishDate');
		var myNewsId = $(this).attr('myNewsId');
		if(flag == 1) {		
			$('#showNewsVideo').show();
			$('#showNewsURL').hide();
			$('#newsEmbbededVideo').val(embedvalue);
		}
		else{
			$('#showNewsVideo').hide();
			$('#showNewsURL').show();		
			$('#newsEmbbededURL').val(embedvalue);
		}
		$('#title').val(title);
		$('#writerName').val(writerName);
		$('#publishDate').val(publishDate);
		$('#newsLanguage').parent().find('.abc').text(newsLanguage);
		//$('.abc').siblings('#newsLanguage').text(newsLanguage);
		//$('#newsLanguage').find('.abc').text(newsLanguage);
		$('#newsLanguage').val(newsLanguage);
		$('#showcaseNewsId').val(myNewsId);
		$('#newsEmbedDIv').hide();
		document.getElementById('NEWSForm-Content-Box').style.display = 'block';
	
	});

});
</script>
<script language="javascript" type="text/javascript">
function newsDeleteAction(newsIdForDelete)
{
	//alert(profileSocialLinkId);
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		document.newsListForm.newsIdForDelete.value = newsIdForDelete;
		document.newsListForm.submit();
	}
	else{
		return false;
	}	
}

function moveNewsUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.newsListForm.newsIdForSwap.value = 1;
	document.newsListForm.submit();	
}

function moveNewsDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.newsListForm.newsIdForSwap.value = 1;
	document.newsListForm.submit();
}
</script>
