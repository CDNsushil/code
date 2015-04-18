<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$browseImgJs = $toggleId;
$controllerName = $this->router->class;
$promoMediaListAttributes = array(
	'name'=>'promoMediaList',
	'id'=>'promoMediaList',
	'action'=>''	 
);
//$toggleId='imageShowcase';
if(isset($fileId) && $fileId > 0){
	echo '<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
}
?>


<span class="clear_seprator"></span>

<div id="pagingContent<?php echo $toggleId;?>">

	<?php
	
		if(is_array(@$listValues[0]))
		{
		$fieldNameWorkId=array_key_exists('workId',$listValues[0]);
		$fieldNamePId=array_key_exists('prodId',$listValues[0]);
		$fieldNameUpId=array_key_exists('projId',$listValues[0]);
		$fieldNameEventId=array_key_exists('eventId',$listValues[0]);
		$fieldNameLaunchEventId=array_key_exists('launchEventId',$listValues[0]);
		$fieldNameWorkProfileId=array_key_exists('workProfileId',$listValues[0]);		
		
		if($fieldNameWorkId)
		$fieldName='workId';
		if($fieldNameWorkProfileId)
		$fieldName='workProfileId';
		if($fieldNamePId)
		$fieldName='prodId';
			if($fieldNameUpId)
			{
			$fieldName='projId';
			$entityMediaType='upcoming';
			}
			if($fieldNameEventId) 
			{
			$fieldName='eventId';
			
			}
			
			if($fieldNameLaunchEventId && $entityMediaType!="mediaEvent") 
			{
			$fieldName='launchEventId';
			$entityMediaType='launchevent';
			}
			
		
		}
		
		if(!empty($listValues)){
			
		
		foreach($listValues as $key=>$listValue){
			
			
		$mediaPath = $listValue['mediaPath'].$listValue['mediaName'];
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
			else 
			$promoMediaTitle = $listValue['rawFileName'];
			$mediaId = $listValue['mediaId'];
			$imagePath = $listValue['filePath'];
			$imageName = $listValue['fileName'];
			$entityId = $listValue['mediaId'];
			$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
			$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";
			
			$uniqueRowId="imgRow".$listValue['fileId'];
			$uniqueImgRowId="#imgRow";
			 ?>
			<div id="<?php echo $uniqueRowId;?>" class="imgCount">
			<div class="all_list_item">
			   <div class="row">
				   				   
				 <div class="cell ml10 maxWidth59px">
					 <div class="cell recent_thumb promoImgWrapper">
					<?php
					//echo $imagePath.$imageName;
					    $img=getImage($imagePath.'/'.$imageName);
					    
					    if($listValue['mediaDesc']!='') 
							$imgDesc = $listValue['mediaDesc'];
						else 
							$imgDesc = $imageName; 
						
						//echo $promotionMediaTable;
						$editArr = array('title'=>'Edit',
						'class'=>"GalId formTip",
						'id'=>"GalId", 
						'mediafileId'=>$listValue['fileId'],
						'mediaPromoId'=>$listValue['mediaId'],
						'mediaTitle'=>$listValue['mediaTitle'],
						'mediaDescription'=>$listValue['mediaDesc'],
					    'title'=>$imgDesc,
						'fileName' => $imageName ,
						'onclick' => '$(\'#imageShowcaseForm-Content-Box\').slideDown(\'slow\');'
						);	
					    
					    
					  
					    //$imageSrc = '<img src="'.$img.'" class="formTip " title="'.$imgDesc.'" id="galImg_'.$listValue['mediaId'].'" />';						
					    $imageSrc = '<img  "class"="formTip" src="'.$img.'" title="'.$imgDesc.'" id="galImg_'.$listValue['mediaId'].'" />';						
						echo anchor('javascript://void(0);', $imageSrc,$editArr);
					?>		
														
				</div> <!--End cell recent_thumb ml10 -->			
			</div>
		</div>
		<div class="cell promoTitle">	
			<div class="var_name"> 
				<?php
				if($promoMediaTitle!='') 
				echo $promoMediaTitle; 
				else 
				echo "notAvalue";
				?>
			</div>
			
		</div> <!-- End cell recent_thumb ml10 -->
	</div>

	 <div class="promoAction">	
	 
	 
	 
	
		<div class="cell pro_btns"> 
	        
					<div class="small_btn">						
						<?php if(strcmp($this->router->method,'launchEventForm')==0) 
						$entityMediaType=3;//to distinush the launch event type to get deleted form launch table
						//$elemetTable='MediaFile';
						$elementFieldId='fileId';
						$divId='pagingContent';
						$filePathImage=$imagePath.$imageName;
						
						$jsonMediaDataArray=array("tableName"=>$tableName,
						"elementFieldId"=>$elementFieldId,
						"fileId"=>$listValue["fileId"],
						"divId"=>$divId,
						"mediaId"=>$mediaId,
						"filePathImage"=>$filePathImage,
						"method"=>$this->router->fetch_method(),
						"fieldName"=>$fieldName,
						"fieldValue"=>$listValue[$fieldName]
						);
$jsonMedia=json_encode($jsonMediaDataArray);
?>
<script>
var deleData<?php echo $mediaId;?> = <?php echo $jsonMedia; ?>;
</script>
	
	<?php 
	$delBtnArr = array(
	"title"=>$this->lang->line("delete"),
	"class"=>"formTip",
	"onclick"=>"deleteTabelRowMedia(deleData".$mediaId.")",
	);						
	$deleImageSrc = '<div class="cat_smll_plus_icon"></div>';
	echo anchor('javascript://void(0);', $deleImageSrc,$delBtnArr);	
	?>
</div>
		<div class="small_btn">						
		<?php
			$editBtnArr = array('title'=>'Edit',
			'class'=>"GalId formTip",
			'id'=>"GalId", 
			'mediafileId'=>$listValue['fileId'],
			'mediaPromoId'=>$listValue['mediaId'],
			'mediaTitle'=>$listValue['mediaTitle'],
			'mediaDesc'=>$listValue['mediaDesc'],
			'rawFileName'=>$listValue['rawFileName'],
			'isExternal'=>$listValue['isExternal'],
			'embbededURL'=>'',
			'browseImgJs'=>$browseImgJs,
			'title'=>$this->lang->line('edit'),
			'fileName' => $imageName ,
			'onclick' => '$(\'#imageShowcaseForm-Content-Box\').slideDown(\'slow\');'
			);					
			
			$editImageSrc = '<div class="cat_smll_edit_icon"></div>';
			
			echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);
		?>						
		</div>	<!-- small_btn -->
						
		</div> <!-- cell pro_btns -->     
		<?php
			
			
			if(isset($listValue['isMain']))	{
				if($imageStatus != 't'){
					
					?>
				
				<a class="formTip"  style="cursor:pointer" onclick="makeFeatured('<?php echo $fieldName;?>','<?php echo $mediaId;?>','<?php echo $entityId?>','1','<?php if(isset($entityMediaType)) {echo $entityMediaType; }?>','<?php echo $tableName;?>','<?php echo $listValue['mediaTitle']?>','<?php echo $listValue['mediaDesc']?>');">
					<div id='makeFeatureImg<?php echo $mediaId;?>'>
						<img style="padding-top:5px" src="<?php echo base_url()?>images/featured.png"  />
				</div>
				</a>
			<?php }
			}?>
	<!--End Cell galImageName-->
	</div>
	<div class="row heightSpacer"> </div>
	
	</div>
	
		<div class="clear"></div>
	
	<?php } 
	
	
	
	} else {
		
		
		echo '<div id="addLink" >';  		
		
		$noRecBtnArr = array('class' => 'a_orange',
	
						'onclick' => '$(\'#imageShowcase-Content-Box\').slideDown(\'slow\');'
						);						
		echo anchor('javascript://void(0);', $this->lang->line('add'),$noRecBtnArr);
		
		echo '</div>';
		
		} ?>
		
		
		
		
		
</div>  <!-- End pagingContent -->

<script type="text/javascript">
$(document).ready(function()
{	
	//To stop user to add more than 1 images
	if($('.imgCount').length>=10)
		$('#addIcon').addClass('dn');
	else
		$('#addIcon').removeClass('dn');	
	
	$('.GalId').click(function(){
		
		var mediaPromoId = $(this).attr('mediaPromoId');
		var galTitle = $(this).attr('mediaTitle');
		var mediafileId = $(this).attr('mediafileId');
		var galAltText = $(this).attr('mediaDesc');
		var imageName = $(this).attr('filename');
		
		new_img_src = $('#galImg_'+mediaPromoId).attr('src');
		//alert(new_img_src);
		$('#mediaSrc<?php echo $toggleId;?>').attr('src',new_img_src);		
		$('#mediaId<?php echo $toggleId;?>').val(mediaPromoId);
		$('#fileId').val(mediafileId);
		$('#mediaTitle<?php echo $toggleId;?>').val(galTitle);
		$('#mediaDescription<?php echo $toggleId;?>').val(galAltText);
		//$('#fileInput').val(imageName);
					 
		$('.promoImageCount').css("display","block");
		$('#imageShowcase-Content-Box').slideDown('slow');
		$('#fileInput<?php echo $toggleId;?>').removeClass('required');
		
	
	});
	
});

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
