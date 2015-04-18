<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
//Variables for news form
$promoImageListFormAttributes = array(
	'name'=>'promoImageListForm',
	'id'=>'promoImageListForm'
);


if(count($eventPromoImages)>0){
echo form_open('event/promoImageAction',$promoImageListFormAttributes);
echo form_hidden('promoImageIdForDelete','');	
$countRecord =  count($eventPromoImages)-1;
$ipromoImages = 0; 
?>
<div class="row">
<?php
foreach($eventPromoImages as $k=>$eventPromoImagesItem)
{
$eventImagePath = $eventPromoImagesItem['filePath'].$eventPromoImagesItem['fileName'];
 $imageSrc =  '<img style="margin:auto; min-height:100px; max-height:100px;min-width:100px;" src="'.getImage($eventImagePath).'" class="formTip HoverBorder" title="'.$label['promoImage'].'" id="eventPromoImage_'.$eventPromoImagesItem['MediaId'].'" />';
?>		


<div class="cell">
<div class="PROMOTIONALIMAGEId" titlehere="<?php echo $eventPromoImagesItem['MediaTitle'];?>" id="PROMOTIONALIMAGEId" promoDescHere="<?php echo $eventPromoImagesItem['MediaDescription'];?>" PROMOTIONALIMAGEId="<?php echo $eventPromoImagesItem['MediaId'];?>" promoImgsrc="<?php echo $eventImagePath; ?>">
<?php

	echo  $imageSrc;
	
?>
</div>
</div>

<?php
$ipromoImages++;
echo '</form>';
}
echo '</div>';
echo '<div class="row heightSpacer">&nbsp;</div>';
}
else{
echo '<div id="PROMOTIONALIMAGE-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['PROMOTIONALIMAGE'],array('class'=>'formTip','title'=>$label['PROMOTIONALIMAGE'],'onclick'=>'showRelatedForm(\'PROMOTIONALIMAGEForm-Content-Box\',\'PROMOTIONALIMAGE-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.PROMOTIONALIMAGEId').click(function(){
		var flag = $(this).attr('flag');
		var embedvalue = $(this).attr('embed');
		var title = $(this).attr('titlehere');
		var promoDesc = $(this).attr('promoDescHere');
		
		var myPROMOTIONALIMAGEId = $(this).attr('PROMOTIONALIMAGEId');
		
		$('#title').val(title);
		$('#description').val(promoDesc);
		$('#promotionalImageId').val(myPROMOTIONALIMAGEId);
		
		new_img_src = $('#eventPromoImage_'+myPROMOTIONALIMAGEId).attr('src');

		$('#currentPromotionalImage').attr('src',new_img_src);

		document.getElementById('PROMOTIONALIMAGEForm-Content-Box').style.display = 'block';
	
	});

});
</script>
<script language="javascript" type="text/javascript">
function promoImgDeleteAction(newsIdForDelete)
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

</script>
