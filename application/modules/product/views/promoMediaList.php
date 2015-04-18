<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$controllerName = $this->router->class;
$promoMediaListAttributes = array(
	'name'=>'promoMediaList',
	'id'=>'promoMediaList',
	'action'=>''	 
);


//echo form_open($delMediaAction,$promoMediaListAttributes); ?>
<!--
<input type="hidden" id="entityId" value="<?php echo $currentEntityId;?>" name="entityId" />
<input type="hidden" id="isMain" value="0" name="isMain" />
<input type="hidden" id="entityMediaType" value="" name="entityMediaType" />
<input type="hidden" id="promoMediaId" value="" name="promoMediaId" />
<input type="hidden" id="returnUrl" value="<?php echo $returnUrl;?>" name="returnUrl" />

<input type="hidden" value="0" name="mediaId" id="mediaId" />
<input type="hidden" value="" name="formtype" />
<?php //echo form_close(); ?>

-->

<span class="clear_seprator"></span>

<div id="pagingContent">
	
	<div class="row  height30">					
		<div style="width:72px" class="cell ml10">
		   <label class="orange"><?php echo $label['thumdnail'];?></label>
		</div>
		<div class="cell promoTitle">
			<label class="orange"><?php echo $label['PromoTitle'];?></label> 
		</div>
		<div class="cell galAltText">
			<label class="orange"><?php echo $label['PromoAlternateText'];?></label>
		</div>
		<div class="cell promoAction ">
			<label class="orange"><?php echo $label['PromoAction'];?></label>
		</div>
	
	</div><!--End Row-->
	
    
	<div class="clear line1"></div>
	<div class="row heightSpacer"> </div>
		<? //print_r($listValues);die();	?>
		<?php
		if(!empty($listValues)){
		foreach($listValues as $listValue){
		$mediaPath = $listValue['filePath'].$listValue['fileName'];
			if(isset($listValue['isMain']))	{
				$imageStatus = $listValue['isMain'];
			}else{
				$imageStatus ='f';
			}
			if(strlen($listValue['mediaTitle']) >0){
				if(strlen($listValue['mediaTitle'])>10)
					$promoMediaTitle = substr($listValue['mediaTitle'],0,10).'...';
				else
					$promoMediaTitle = $listValue['mediaTitle'];
			}
			else $promoMediaTitle = $listValue['fileName'];
			$mediaId = $listValue['mediaId'];
			$imagePath = $listValue['filePath'];
			$imageName = $listValue['fileName'];
			$entityId = $listValue['entityId'];
			$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
			$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";?>
			
			<div class="all_list_item">
			   <div class="row">
				   				   
				 <div class="cell recent_thumb ml10">
					 
					<?php
					
					    $img=getImage($imagePath.$imageName);
						
						$editArr = array('title'=>'Edit',
						'class'=>"GalId formTip",
						'id'=>"GalId", 
						'mediaPromoId'=>$listValue['mediaId'],
						'mediaTitle'=>$listValue['mediaTitle'],
						'mediaDescription'=>$listValue['mediaDescription'],
						'fileName' => $imageName ,
						'onclick' => '$(\'#PromoForm-Content-Box\').slideDown(\'slow\');'
						);	
					    
					    $imageSrc = '<img src="'.$img.'" class="formTip  minMaxWidth59px" 
					          title="" id="galImg_'.$listValue['mediaId'].'" />';						
						echo anchor('javascript://void(0);', $imageSrc,$editArr);
					?>		
														
				</div> <!--End cell recent_thumb ml10 -->			
			
		</div>

		<div class="cell promoTitle">			
			
			<?php
				if($promoMediaTitle!='') 
					echo $promoMediaTitle; 
				else 
				echo "notAvalue";	
				
			   echo '<p>'.date('d/m/Y',strtotime($listValue['fileCreateDate'])).'</p>'; ?>	
			
		
		</div> <!-- End cell recent_thumb ml10 -->
	</div>
	
	<div class="cell galAltText">
		<?php
		
		 if($listValue['mediaDescription']!='') 
				echo $listValue['mediaDescription'];
			else 
				echo $imageName; ?>
		
		</div><!--End cell galAltText-->
		
	 <div class="promoAction">	
		<div class="cell pro_btns"> 
	        
					<div class="small_btn">						
						
						<a href="#" class="formTip" title="Delete" onmouseout="mouseout_small_button(this)" onmouseover="mouseover_small_button(this)" onmouseup="mouseup_small_button(this)" onmousedown="mousedown_small_button(this)" style=" background-position: 0px 0px;"  onclick="deleteMedia('<?php echo $controllerName;?>','<?php echo $mediaId;?>','<?php echo $entityId;?>','<?php if(isset($entityMediaType)) { echo $entityMediaType; }?>')"><span><div class="cat_smll_plus_icon"></div></span></a>
				  </div>
											
							
					<div class="small_btn">
						
					<?php 
												
					    $editImageSrc = '<span  style="background-position: right 0px;"><div class="cat_smll_edit_icon"></div></span>';
						
						echo anchor('javascript://void(0);', $editImageSrc,$editArr);
					?>							
									
						
					</div>	<!-- small_btn -->
						
				</div> <!-- cell pro_btns -->
	         
		
	
	  
			<?php 
			if(isset($listValue['isMain']))	{
				if($imageStatus != 't'){?>
				
				<a class="formTip" title="Make <br>Featured" style="cursor:pointer" onclick="makeFeatured('<?php echo $controllerName;?>','<?php echo $mediaId;?>','<?php echo $entityId?>','1','<?php if(isset($entityMediaType)) { echo $entityMediaType; }?>');">
					<img style="padding-top:5px" src="<?php echo base_url()?>images/featured.png"  />
				</a>
			<?php }
			}?>
			
			
		 <!--End Cell galImageName-->
	</div>
	
	
	
	<div class="row heightSpacer"> </div>	
	
	
	<?php } } else { echo "<div align='center' id='hideTextDiv' style='display:block'>No promotional image found!</div>"; } ?>


   
</div>  <!-- End pagingContent -->

<script type="text/javascript">
$(document).ready(function()
{	
	$('#BrowserHiddenPromo').bind('change', function() {
		var ext = $('#PromoFileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			alert('Only gif,png,jpg,jpeg extensions are allowed');
			$('#BrowserHiddenPromo').attr({ value: '' }); 
			$('#PromoFileField').attr({ value: '' }); 
		}
	});	
	
	
	$('.GalId').click(function(){
		
		var mediaPromoId = $(this).attr('mediaPromoId');
		var galTitle = $(this).attr('mediaTitle');
		var galAltText = $(this).attr('mediaDescription');
		var imageName = $(this).attr('filename');
					
		new_img_src = $('#galImg_'+mediaPromoId).attr('src');
				
		$('#promoImage').attr('src',new_img_src);		
		
				
		$('#mediaId').val(mediaPromoId);
		$('#mediaTitle').val(galTitle);
		$('#mediaDescription').val(galAltText);
		//$('#fileInput').val(imageName);
					 
		$('.promoImageCount').css("display","block");
		$('#PromoForm-Content-Box').slideDown("slow");
		$('#fileInputImage').removeClass('required');
		
	
	});

	
	
});

function makeFeatured(controllerName,mediaId,entityId,mediaType,entityMediaType)
{
		location.href=baseUrl+language+"/"+controllerName+"/makeFeatured/"+mediaId+"/"+entityId+"/"+mediaType+"/"+entityMediaType;
}

</script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

$(".delImg").click(function() {

var conBox = confirm(areYouSure);
		if(conBox){
var postMediaId = $(this).attr('postMediaId');

$("#promoMediaId").val(postMediaId);

$('#promoMediaList').submit();
return true;
		}
		else{
		return false;
		}
});

$(".delIsMain").click(function() {

var conBox = confirm(areYouSure);
	if(conBox){
		var entityId = $(this).attr('entityId');
		var postMediaId = $(this).attr('postMediaId');
		$("#promoMediaId").val(postMediaId);
		$("#isMain").val(1);

		$('#promoMediaList').submit();
		return true;
	}
	else{
		return false;
	}
	
});
	$('.PROMOTIONALMEDIAId').click(function(){
		var promoMediaTitle = $(this).attr('titlehere');
		var promoMediaDesc = $(this).attr('promoDescHere');

		var myPROMOTIONALMEDIAId = $(this).attr('PROMOTIONALMEDIAId');
		var myPROMOTIONALMEDIAIsMain = $(this).attr('PROMOTIONALMEDIAIsMain');

		$('#mediaTitle').val(promoMediaTitle);
		$('#mediaDescription').val(promoMediaDesc);
		$('#mediaId').val(myPROMOTIONALMEDIAId);
		$('#isMain').val(myPROMOTIONALMEDIAIsMain);

		new_img_src = $('#promoMedia_'+myPROMOTIONALMEDIAId).attr('src');

		$('#currentPromotionalImage').attr('src',new_img_src);
		
	});

});

function deleteMedia(controllerName,mediaId,entityId,mediaType)
	{
		var conBox = confirm(areYouSure);
		if(conBox){
			location.href=baseUrl+language+"/"+controllerName+"/deletePromotionImage/"+mediaId+"/"+entityId+"/"+mediaType;
		return true;
		}
		else{
		return false;
		}
	}
	
</script>
