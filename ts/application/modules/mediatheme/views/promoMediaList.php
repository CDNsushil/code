<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$browseId=$browseImgJs=isset($browseImgJs)?$browseImgJs:'image';
$controllerName = $this->router->class;

$defaultImage_s = $this->config->item('defaultImg_s');
$defaultImage = $this->config->item('defaultImg');
$isdata=false;

if(isset($fileId) && $fileId > 0){
	echo '<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
}
?>
<span class="clear_seprator"></span>
<div id="pagingContent">
<?php
//echo '<pre />';print_r(@$listValues);die;
if(isset($listValues[0]) && is_array(@$listValues[0]))
{
	$fieldNameWorkId = array_key_exists('workId',$listValues[0]);
	$fieldNamePId = array_key_exists('prodId',$listValues[0]);
	$fieldNameUpId = array_key_exists('projId',$listValues[0]);
	$fieldNameEventId = array_key_exists('eventId',$listValues[0]);
	$fieldNameLaunchEventId = array_key_exists('launchEventId',$listValues[0]);		
	$fieldNameUserId = array_key_exists('userId',$listValues[0]);
		
	if($fieldNameUserId) $fieldName = 'userId';		
	if($fieldNameWorkId) $fieldName = 'workId';		
	if($fieldNamePId) $fieldName = 'prodId';		
	if($fieldNameUpId)
	{
		$fieldName = 'projId';
		$entityMediaType = 'upcoming';
	}
	if($fieldNameEventId) $fieldName = 'eventId';		
		
	if($fieldNameLaunchEventId && @$entityMediaType!="mediaEvent") 
	{
		$fieldName = 'launchEventId';
		$entityMediaType = 'launchevent';
	}	
}
//echo '<pre />';print_r($listValues);die;

		if(is_array($listValues) && count($listValues) > 0){
			
			$isdata=true;
		foreach($listValues as $key=>$listValue){
			
			//$mediaPath = $listValue['filePath'].$listValue['fileName'];
			
			if(isset($listValue['isMain'])&&$listValue['isMain']!='')	
			{
				$imageStatus = $listValue['isMain'];
			}
			else{
				$imageStatus = 'f';
			}
			
			if(strlen($listValue['mediaTitle']) >0)
			{
				$promoMediaTitle = getSubString($listValue['mediaTitle'],40);				
			}
			else 
				$promoMediaTitle = $listValue['rawFileName'];
			
			$mediaId = $listValue['mediaId'];
			$imagePath = $listValue['filePath'];
			$imageName = $listValue['fileName'];
			$imageToolTip = $listValue['rawFileName'];
			$entityId = $listValue['entityId'];
			
			$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
			$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";
			
			$uniqueRowId="imgRow".$listValue['fileId'];
			$uniqueImgRowId="#imgRow";
			
			//edit on image click
			$imgDesc = $listValue['mediaTitle'];
		
			if(strcmp($this->router->method,'launchEventForm')==0) $entityMediaType=3;//to distinush the launch event type to get deleted form launch table
				
				$elementFieldId='fileId';
				$divId='pagingContent';
				$filePathImage=$imagePath.$imageName;
				
				$jsonMediaDataArray=array("tableName"=>$tableName,
				"elementFieldId"=>$elementFieldId,
				"fileId"=>$listValue["fileId"],
				"divId"=>'',
				"mediaId"=>$mediaId,
				"filePathImage"=>$filePathImage,
				"method"=>$this->router->fetch_method(),
				"fieldName"=>$fieldName,
				"fieldValue"=>$listValue[$fieldName],
				"reloadPage"=>1,
				"delBrowseId"=>'promo'
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
			$editImageSrc = '<div class="cat_smll_edit_icon"></div>';
			
			//Set values to make event/launch primary image
			if(isset($listValue['eventId']) && !empty($listValue['eventId'])) {
				$projectEventType = 9; //Set event type id
				$projectEventId = $listValue['eventId'];
			} elseif(isset($listValue['launchEventId']) && !empty($listValue['launchEventId'])){
				$projectEventType = 15; //Set launch type id
				$projectEventId = $listValue['launchEventId'];
			}else {
				$projectEventType = ''; 
				$projectEventId = '';
			}
		?>
			
			<div id="<?php echo $uniqueRowId;?>" class="imgCount">
			<div class="cell frm_element_wrapper extract_content_bg">
				<div class="extract_img_wp">				
					<?php
					//media/S1oIKjkC/events/192/images/p17jgktlbr1lc315dk1vj31tgh1dce4.png
					$extraSmallImg = addThumbFolder($imagePath.$imageName,'_xxs');										
					$passImg = getImage($extraSmallImg,$defaultImage);					

					$editattr = array(
					
					'divId'=>$uniqueRowId,
					'mediafileId'=>$listValue['fileId'],
					'mediaPromoId'=>$listValue['mediaId'],
					'mediaTitle'=>$listValue['mediaTitle'],
					'mediaDescription'=>$listValue['mediaDescription'],
					'showimage'=>@$passImg,
					'isMain'=>$listValue['isMain'],
					'title'=>$imgDesc,
					'fileName' => $imageName,
					'rawFileName'=>$listValue['rawFileName'],
					'isExternal'=>$listValue['isExternal'],
					'fileName' => $imageName );
					$editJsonMedia=json_encode($editattr);
					?>
					<script>
						var editDataMedia<?php echo $listValue['mediaId'];?> = <?php echo $editJsonMedia; ?>;
					</script> 
					<?php
					$editBtnArr = array(
						'id'=>"GalId", 
						"onclick" => "editPromoImg(editDataMedia".$listValue['mediaId'].", '".$browseImgJs."');"
					);	
					
					
					$img = getImage($extraSmallImg,$defaultImage_s);
					
					$imageSrc = '<img  class="ptr maxWH30 ma" src="'.$img.'" title="'.$imgDesc.'" id="galImg_'.$listValue['mediaId'].'" />';						
					echo anchor('javascript://void(0);', $imageSrc,$editBtnArr);
				?>
				</div>
				<!--extract_img_wp-->
				<div class="extract_quota_box width400px">	
				<?php
					echo ($promoMediaTitle!='')?$promoMediaTitle:"notAvalue";
				?> 
				</div>				
				<div class="extract_button_box">
					<?php							
						if(@$nomain!=1 && @$makeFeatured==1)
						{ 
					?>					
					  <div class="fl mr0 makeFeatureImg">
						  <div class="small_btn">
							<?php								
							if($imageStatus != 't' || $imageStatus == '' || !isset($imageStatus) && @$nomain!=1)
							{ 
							?>						
							<a class="formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg') ?>" style="cursor:pointer" onclick="makeFeatured('<?php echo $fieldName;?>','<?php echo $mediaId;?>','<?php echo $entityId?>','1','<?php if(isset($entityMediaType)) {echo $entityMediaType; }?>','<?php echo $tableName;?>','<?php echo $listValue['mediaTitle']?>','<?php echo $listValue['mediaDescription']?>');">
								<span><div class="cat_smll_star_icon" id='makeFeatureImg<?php echo @$mediaId;?>'></div></span>
							</a>
							<?php 
							}  
							?>
						</div>
					  </div>
					  <?php 
					  } 
					  ?>
					<div class="cell width55px">
						
						<input type="hidden" id="imgIsMain<?php echo $mediaId;?>" value='<?php echo $listValue['isMain'];?>'/>
						
						<div  class="small_btn">
							<?php 
								echo anchor('javascript://void(0);', $deleImageSrc,$delBtnArr);	
							?>
						</div>
						<div class="small_btn"  >
							<?php
								$editBtnArr['title'] = $this->lang->line('edit');
								$editBtnArr['class'] = 'GalId formTip';								
								echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);
							?>
						</div>
						<?php if($listValue['isMain']=='f') { ?>	
							<div class="small_btn">
								<a class="GalId formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg') ?>" style="cursor:pointer" onclick="makePrimaryImage('<?php echo $projectEventType;?>','<?php echo $mediaId;?>','<?php echo $projectEventId;?>');">
								<span><div class="cat_smll_star_icon"></div></span>
								</a>
							</div>	
						<?php }?>
				</div>				
			</div>
			</div>
			
			</div><!-- End imgCount -->
<?php   }
		}else{
			
		}		
		if(@$showaddbutton!=1){
			
			 $promo_max_upload = $this->config->item('promo_max_upload');
			 $countPromoImag = count(@$listValues);
			 
				if($countPromoImag>0)
					$resultantEmpty = $countPromoImag;
				else
					$resultantEmpty = 0;	
				
				if($countPromoImag != $promo_max_upload)
				{
					$isdata=true;
					while ($resultantEmpty < $promo_max_upload) {
						$resultantEmpty++;
						?>						
						<div class=" cell frm_element_wrapper extract_content_bg " id="rowDataAdd<?php echo $resultantEmpty;?>">
							<div class="extract_img_wp opacity_4"> 
								<img src="<?php echo getImage('',$defaultImage);?>" class="ptr maxWH30 ma">
							</div>
							<!-- extract_img_wp -->
							<div class="extract_heading_box opacity_4">
								<?php echo (isset($addPromoheading) && $addPromoheading!='')?$addPromoheading:$this->lang->line('addPromotionalImage');?></div>
							<!-- extract_heading_box -->
							<div class="extract_button_box">
							  <div class="small_btn"><a onclick="canceltoggle(1)" href="javascript:void(0)" class="formTip GalId" divId="rowDataAdd<?php echo $resultantEmpty;?>" title="<?php echo $this->lang->line('add');?>"><div class="cat_smll_add_icon"></div></a></div>
							</div>
						</div>
						<input type="hidden" id="addVideo" name="addVideo" value="Add<?php echo $resultantEmpty;?>" />
						<?	
					}			
				}
			}
			
			if(!$isdata) {
				echo '<div id="addLink" class="cell frm_element_wrapper">';  		
					$noRecBtnArr = array('class' => 'a_orange','onclick' => '$(\'#PromoForm-Content-Box'.$browseId.'\').slideDown(\'slow\');');						
					echo anchor('javascript://void(0);', $this->lang->line('add'),$noRecBtnArr);
				echo '</div>';
			}
	  ?>
</div>  <!-- End pagingContent -->

<script type="text/javascript">

$(document).ready(function()
{
	if('<?php echo @$elementId;?>') {
		$('#lastInsertedMediaId').attr('value','<?php echo @$elementId;?>');
	}				
	<?php if(@$showaddbutton!=1) { ?>	
	$('#addLink').addClass('dn');		
	//To stop user to add more than 1 images
	if($('.imgCount').length>=10)
		$('#addIcon').addClass('dn');
	else
		$('#addIcon').removeClass('dn');			
	<?php } ?>
});


function editPromoImg(mediaAttr,browseId){
	
	var rawFileName = mediaAttr.rawFileName;
	var mediaPromoId = mediaAttr.mediaPromoId;
	var galTitle = mediaAttr.mediaTitle;
	var mediafileId = mediaAttr.mediafileId;
	var galAltText = mediaAttr.mediaDescription;
	var imageName = mediaAttr.filename;
	var passImage = mediaAttr.passimage;			
	var new_img_src = mediaAttr.showimage;
	var isMain = mediaAttr.isMain;
	var divId = mediaAttr.divId;
	var isExternal = mediaAttr.isExternal;
	
	if(rawFileName != '' && rawFileName != null && (rawFileName.length > 4) && (isExternal != 't')){
		if($('#uploadFileSection'+browseId))
			$('#uploadFileSection'+browseId).hide()
		if($('#rawFileNameContainerDiv'+browseId))
			$('#rawFileNameContainerDiv'+browseId).show()
		if($('#rawFileNameDiv'+browseId))
			$('#rawFileNameDiv'+browseId).html(rawFileName);
	}else{
		if($('#rawFileNameContainerDiv'+browseId))
			$('#rawFileNameContainerDiv'+browseId).hide()
		if($('#uploadFileSection'+browseId))
			$('#uploadFileSection'+browseId).show()
		if($('#rawFileNameDiv'+browseId))
			$('#rawFileNameDiv'+browseId).html('');
	}

	//new_img_src = $('#galImg_'+mediaPromoId).attr('src');
	new_img_src = mediaAttr.showimage;
	//alert(new_img_src);
	$('#promoImage'+browseId).attr('src',new_img_src);		
	$('#mediaId'+browseId).val(mediaPromoId);
	$('#fileId'+browseId).val(mediafileId);
	$('#mediaTitle'+browseId).val(galTitle);
	$('#mediaDescription'+browseId).val(galAltText);
	$('#isMain'+browseId).val(isMain);
	//$('#divId'+browseId).val(divId);
	$('.promoImageCount').css("display","block");
	<?php if(@$showaddbutton==1){ ?>
	$('#Uploadvideo'+browseId).addClass('dn');
	<?php } ?>
	$('#PromoForm-Content-Box'+browseId).removeClass("dn");
	$('#PromoForm-Content-Box'+browseId).slideDown("slow");
	$('#fileInput_imgJs').removeClass('required');		
}

function makeFeatured(fName,mediaId,entityId,mediaType,entityMediaType,mediaTable,mediaTitle,mediaDescription)
{			
	var data = {"entityMediaType":entityMediaType,"entityField":fName,"entityId":entityId,"mediaTitle":mediaTitle,"mediaDescription":mediaDescription,"mediaType":mediaType}; 
	//alert(data.toSource());	
	/*$('.makeFeatureImg').each(function () {
        alert('featured_ico current');
        $(this).addClass('featured_ico');                               
       // $('li.taglink').show(495);
    });
    $(this).removeClass('featured_ico'); */
	AJAX(baseUrl+language+"/mediatheme/makeFeatured/"+fName+"/"+mediaId+"/"+entityId+"/"+mediaType+"/"+entityMediaType+"/"+mediaTable,'pagingContent','',data,'<?php echo @$makeFeatured; ?>');				
}

//Function for change primary image
function makePrimaryImage(eventType,mediaEventId,EventId) {
	var sendData = {"eventType":eventType,"EventId":EventId,"mediaEventId":mediaEventId}
	$.post(baseUrl+language+'/common/makeEventPrimaryImage',sendData, function(data) {
			if(data){	
				refreshPge();
			}
	});
}
</script>

