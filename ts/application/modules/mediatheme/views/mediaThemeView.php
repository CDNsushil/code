<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//echo '<pre/>';print_r($listValues);
?>
<span class="clear_seprator"></span>
<div class="frm_wp" style="width:721px">
	<div class="table">
		<div class="row">
			<?php
				if(!empty($listValues)){
				foreach($listValues as $listValue){
				$mediaPath = $listValue['filePath'].$listValue['fileName'];
					
					if(isset($listValue['isMain']))	{
						$imageStatus = $listValue['isMain'];
					}else{
						$imageStatus ='f';
					}

					//$imageStatus = $listValue['isMain'];
					$mediaId = $listValue['mediaId'];
					$imagePath = $listValue['filePath'];
					$imageName = $listValue['fileName'];
					$entityId = $listValue['entityId'];

					$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
					$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";?>
					<div class="cell" style="height:135px;margin:5px 33px 5px 5px;">
						<div class="cell dblBorder" style="<?php if($imageStatus == 't'){ echo $styleFeatured; } else { echo $style;}?>" id="upcomingProductImage_<?php echo $mediaId;?>">
<div class="PROMOTIONALMEDIAId" titlehere="<?php echo $listValue['mediaTitle'];?>" id="PROMOTIONALMEDIAId" promoDescHere="<?php echo $listValue['mediaDescription'];?>" PROMOTIONALMEDIAId="<?php echo $listValue['mediaId'];?>" promoImgsrc="<?php echo $mediaPath; ?>"> <!-- Div to Fill the Form -->
<img style="max-height:82px;max-width:82px; margin:auto; cursor:pointer" src="<?php echo base_url().$imagePath.$imageName?>" class="formTip" <?php if($imageStatus == 't'){ ?>title="Featured Image" <?php }?> id="promoMedia_<?php echo $listValue['mediaId'];?>" />
</div>
						</div>
						<div class="cell" style="clear:both;">
						<?php 
						if(isset($listValue['isMain']))	{
							if($imageStatus != 't'){?>
							<a style="cursor:pointer" onclick="makeFeatured('<?php echo $mediaId;?>','<?php echo $entityId?>','1');">
								<img style="padding-top:5px" src="<?php echo base_url()?>images/featured.png" title="Make Featured" class="formTip" />
							</a>
						<?php }
						}?>
						</div>
						<div class="cell">
							<?php 
							if(isset($listValue['isMain']))	{?>
							<a style="cursor:pointer" onclick="deleteImage('<?php echo $mediaId;?>','<?php echo $entityId?>','image')";>
							<?php } else{ ?>
							<a style="cursor:pointer">
							<?php }?>
								<img style="padding-top:8px;margin-left:10px;" src="<?php echo base_url()?>images/crossSmall.png" title="Delete Image" class="formTip"/>
							</a>
						</div>
					</div>
			<?php } } else { echo "<div align='center' id='hideTextDiv' style='display:block'>No promotional images for this upcoming Project! <a style='cursor:pointer' onclick='openAddForm()'>Click here</a> to add Image</div>"; } ?>
		</div>
	</div>
	<span class="clear_seprator"></span>
</div>
<!--frm_wp-->
<script type="text/javascript">
$(document).ready(function()
{	
	$('#BrowserHidden').bind('change', function() {
		var ext = $('#FileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			alert('Only gif,png,jpg,jpeg extensions are allowed');
			$('#BrowserHidden').attr({ value: '' }); 
			$('#FileField').attr({ value: '' }); 
		}
	});	
});

function makeFeatured(mediaId,entityId,mediaType)
	{
		location.href=baseUrl+language+"/upcomingprojects/makeFeatured/"+mediaId+"/"+entityId+"/"+mediaType;
	}

function deleteImage(mediaId,entityId)
	{
		var conBox = confirm(areYouSure);
		if(conBox){
			location.href=baseUrl+language+"/upcomingprojects/deletePromotionImage/"+mediaId+"/"+entityId;
		return true;
		}
		else{
		return false;
		}
	}
</script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.PROMOTIONALMEDIAId').click(function(){
		var promoMediaTitle = $(this).attr('titlehere');
		var promoMediaDesc = $(this).attr('promoDescHere');
		
		var myPROMOTIONALMEDIAId = $(this).attr('PROMOTIONALMEDIAId');
		
		$('#mediaTitle').val(promoMediaTitle);
		$('#mediaDescription').val(promoMediaDesc);
		$('#mediaId').val(myPROMOTIONALMEDIAId);
		
		new_img_src = $('#promoMedia_'+myPROMOTIONALMEDIAId).attr('src');

		$('#currentPromotionalImage').attr('src',new_img_src);

		document.getElementById('PROMOTIONALIMAGEForm-Content-Box').style.display = 'block';
	
	});

});
</script>

