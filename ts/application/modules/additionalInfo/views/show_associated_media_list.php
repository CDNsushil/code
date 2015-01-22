<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="frm_wp">
<?php
if(count($associatedMedias)>0)
{
?>
<div class="row">
<div class="cell" style="width:465px;"><h3><?php echo $label['title'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="width:175px;"><h3><?php echo $label['writerName'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><h3><?php echo $label['Date'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php

foreach($news as $newsItem)
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
?>
<?php /*?>fillmeinfrom('<?php echo addslashes($newsItem->newsTitle);?>','<?php echo $newsItem->newsWriter;?>','<?php echo $publishDate;?>','<?php echo $newsItem->newsLangauage;?>')
onclick="fillmeinfrom('<?php echo $title;?>','<?php echo $writer;?>','<?php echo $publishDate;?>','<?php echo $newsItem->newsLangauage;?>','<?php echo $flag?>');"
<?php */?>		
<div class="row">
<div class="cell"><input id="NewsId" class="NewsId" value="<?php echo $newsItem->showcaseNewsId;?>" flag='<?php echo $flag;?>' titlehere='<?php echo $title;?>' writer='<?php echo $writer;?>' myNewsId='<?php echo $newsItem->showcaseNewsId;?>' embed='<?=$embedvalue?>' newsLanguage='<?php echo $newsItem->newsLanguage;?>' publishDate='<?php echo $publishDate;?>' type="checkbox" name="NewsId" /></div> 
<div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:440px;min-width:440px; border: #000066 1px soild;"><?php echo stripslashes($title);?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:150px;min-width:150px;"><?php echo stripslashes($writer);?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:100px;"><?php echo $newsCreateDate;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>

<?php
}
}else{
?>
<div class="row">
<div style="width:100%;" align="center"  class="cell error">
<?php echo $label['SorryNo'].ucwords(strtolower($label['ASSOCIATEDMEDIAS'])).$label['available'];?>
</div>
</div>
<?php
}
?>
<div class="row heightSpacer"> &nbsp;</div>	
</div>

<?php 
//$publishDate = date("Y-m-d", strtotime($newsItem->newsPublishDate));
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
		//if(flag == 1) $('#newsEmbbededVideo').val(embedvalue);
		//else $('#newsEmbbededURL').val(embedvalue);
		$('#title').val(title);
		$('#writerName').val(writerName);
		$('#publishDate').val(publishDate);
		$('#newsLanguage').val(newsLanguage);
		$('#showcaseNewsId').val(myNewsId);
		
		$('#embedDIv').hide();
		$('#listBoxWp').trigger('close');
	});

});
</script>
