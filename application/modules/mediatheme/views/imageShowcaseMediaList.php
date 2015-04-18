<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$browseImgJs = $toggleId;
$controllerName = $this->router->class;
$promoMediaListAttributes = array(
	'name'=>'promoMediaList',
	'id'=>'promoMediaList',
	'action'=>''	 
);

$defaultImage_s = $this->config->item('defaultImg_s');
$defaultImage = $this->config->item('defaultImg');
if(isset($fileId) && $fileId > 0){
	echo '<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
}
?>
<div id="pagingContent<?php echo $toggleId;?>">

	<?php
	
		if(is_array(@$listValues[0])){
			$fieldNameWorkId=array_key_exists('workId',@$listValues[0]);
			$fieldNamePId=array_key_exists('prodId',@$listValues[0]);
			$fieldNameUpId=array_key_exists('projId',@$listValues[0]);
			$fieldNameEventId=array_key_exists('eventId',@$listValues[0]);
			$fieldNameLaunchEventId=array_key_exists('launchEventId',@$listValues[0]);
			$fieldNameWorkProfileId=array_key_exists('workProfileId',@$listValues[0]);		
			
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
				$fieldName='eventId';			
					
			$reloadPage = 0;
		
			if(@$fieldNameLaunchEventId && @$entityMediaType!="mediaEvent") 
			{
				$fieldName='launchEventId';
				$entityMediaType='launchevent';
				$reloadPage = 1;
			}
		}
	
		if(!empty($listValues)||@$eventNatureId>0)
		{			
		$imgcount=count($listValues);
		$i_img = 0;
		foreach($listValues as $key=>$listValue){
						
			$i_img++;
		
			if(isset($listValue['isMain']))	{
				$imageStatus = $listValue['isMain'];
			}else{
				$imageStatus ='f';
			}
			
			if(strlen($listValue['mediaTitle']) >0){				
				$mediaTitle = getSubString($listValue['mediaTitle'],37);
			}
			else 
				$mediaTitle = $listValue['rawFileName'];
				
			$mediaId = $listValue['mediaId'];
			$imagePath = $listValue['filePath'].'/';
			$imageName = $listValue['fileName'];
			
			$mediaPath = $imagePath.$imageName;
				
			$entityId = $listValue['mediaId'];
			$style = "vertical-align:middle; padding:5px; clear:both; height:82px; width:82px; display:inline-table;";
			$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";
			
			$uniqueRowId = "imgRow".$listValue['fileId'];
			$uniqueImgRowId = "#imgRow";
			
			if($fieldName=='launchEventId') $mediaDescField = 'mediaDescription';
			else  $mediaDescField = 'mediaDesc';
			
			if($listValue[$mediaDescField]!='') 
				$mediaToolTip = $imgDesc = $listValue[$mediaDescField];
			else 
				$mediaToolTip = $imgDesc = $listValue['rawFileName']; 
				
			$editArr = array('title'=>'Edit',
						'class'=>"formTip",
						'id'=>"GalId", 
						'mediafileId'=>$listValue['fileId'],
						'mediaPromoId'=>$listValue['mediaId'],
						'mediaTitle'=>$listValue['mediaTitle'],
						'mediaDescription'=>$listValue[$mediaDescField],
					    'title'=>$mediaToolTip,
						'fileName' => $imageName						
						);				
			
			$editImageSrc = '<div class="cat_smll_edit_icon"></div>';		
			$elementFieldId = 'fileId';
			$divId = 'pagingContent'.$toggleId;
			
			$img = getImage($imagePath.'/'.$imageName);
			$extraSmallImg = addThumbFolder(@$imagePath.@$imageName,'_xxs');										
			$passImg = getImage($extraSmallImg,$defaultImage);	
			
			$editattr = array('mediafileId'=>$listValue['fileId'],
				'mediaPromoId'=>$listValue['mediaId'],
				'mediaTitle'=>$listValue['mediaTitle'],
				'passimage'=>$passImg,
				$mediaDescField=>$listValue[$mediaDescField],
				'rawFileName'=>$listValue['rawFileName'],
				'isExternal'=>$listValue['isExternal'],
				'embbededURL'=>'',
				'browseImgJs'=>$browseImgJs,
				'fileName' => $imageName);
			
			$editJsonMedia = json_encode($editattr);
			
			?>
			<script>
				var editDataImage<?php echo $mediaId;?> = <?php echo $editJsonMedia; ?>;
			</script>
			<?php
					
			$editBtnArr = array('title'=>'Edit',
			'class'=>"GalId".$toggleId." formTip",
			'id'=>"GalId".$toggleId, 
			'title'=>$this->lang->line('edit'),
			'onclick' => 'editMediaWs(editDataImage'.$mediaId.',\''.$toggleId.'\');'
			);	
						
			$jsonMediaDataArray=array("tableName"=>$tableName,
				"elementFieldId"=>$elementFieldId,
				"fileId"=>$listValue["fileId"],
				"divId"=>$divId,
				"mediaId"=>$mediaId,			
				"filePathImage"=> $listValue['filePath'].'/',
				"method"=>$this->router->fetch_method(),
				"fieldName"=>$fieldName,
				"fieldValue"=>$listValue[$fieldName],
				"reloadPage"=>$reloadPage,
				"delBrowseId"=>@$toggleId			
			);
			$jsonMedia=json_encode($jsonMediaDataArray);
			
				
			$delBtnArr = array(
				"title"=>$this->lang->line("delete"),
				"class"=>"formTip",
				"onclick"=>"deleteTabelRowMedia(deleData".$mediaId.",'imgRow')",
			);	
								
			$deleImageSrc = '<div class="cat_smll_plus_icon"></div>';
			
		?>			 
		
		<script>
		var deleData<?php echo $mediaId;?> = <?php echo $jsonMedia; ?>;
		</script>
		
			<div id="<?php echo $uniqueRowId;?>" class="imgCount">
			<div class="all_list_item">
			  	<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->
			  <div class="cell frm_element_wrapper extract_content_bg" id="<?php echo $uniqueRowId;?>" class="imgCount">
				<div class="extract_img_wp">
					<?php
						$img = getImage($extraSmallImg,$defaultImage_s);
						
					    $imageSrc = '<img  class="ptr maxWH30 ma" src="'.$img.'"  id="galImg_'.$listValue['mediaId'].'" />';						
						echo anchor('javascript://void(0);', $imageSrc,$editArr);
					?>		
														
				</div>		
		<div class="extract_heading_box">				
			<?php
			if($mediaTitle!='') 
				echo $mediaTitle; 
			else 
				echo "notAvalue";
			?>			
		</div> <!-- End extract_heading_box -->
	
		<div class="extract_button_box">			 
			 <div class="cell pro_btns"> 
				 <div class="small_btn">
					<?php 
					echo anchor('javascript://void(0);', $deleImageSrc,$delBtnArr);	
					?>		
				 </div>
				<div class="small_btn">						
					<?php 
					echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);
					?>						
				</div>	<!-- small_btn -->
			</div> <!-- cell pro_btns -->
		</div> <!-- End extract_button_box --> 
	</div>
</div>
</div>

<div class="clear"></div>
<?php 
	
	} 	

	if(@$entityMediaType=='launchevent'||@$eventNatureId>0)
	{		
		$promo_max_upload = $this->config->item('promo_max_upload');
		$countPromoImag = count(@$listValues);		
			 
		if($countPromoImag>0)
			$resultantEmpty = $countPromoImag;
		else
			$resultantEmpty = 0;	
				
				if($countPromoImag != $promo_max_upload)
				{
					while ($resultantEmpty < $promo_max_upload) {
						$resultantEmpty++;
						?>	
						<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->					
						<div class=" cell frm_element_wrapper extract_content_bg " id="rowDataAdd<?php echo $resultantEmpty;?>">
							<div class="extract_img_wp opacity_4"> 
								<img src="<?php echo getImage('',$defaultImage);?>" class="formTip ptr maxWH30 ma" original-title="">
							</div>
							<!-- extract_img_wp -->
							<div class="extract_heading_box opacity_4">
								<?php echo (isset($addPromoheading) && $addPromoheading!='')?$addPromoheading:$this->lang->line('add').'&nbsp;'.$this->lang->line('promoImage');?></div>
							<!-- extract_heading_box -->
							<div class="extract_button_box">
							  <div class="small_btn"><a onclick="cancelMediatoggle('<?php echo $toggleId;?>',1);" href="javascript:void(0)" class="formTip" divId="rowDataAdd<?php echo $resultantEmpty;?>" title="<?php echo $this->lang->line('add');?>"><div class="cat_smll_add_icon"></div></a></div>
							</div>
						</div>
						<input type="hidden" id="addVideo" name="addVideo" value="Add<?php echo $resultantEmpty;?>" />
						<?	
					}			
				}
			}
			if($i_img == $imgcount) echo '<div class="row heightSpacer"></div>';
} 
else {	
?>
<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->
<?php
	echo '<div id="addLink"  class="cell frm_element_wrapper">';  	
	$noRecBtnArr = array('class' => 'a_orange','onclick' => '$(\'#'.$toggleId.'Form-Content-Box\').slideDown(\'slow\');');						
	echo anchor('javascript://void(0);', $this->lang->line('add'),$noRecBtnArr);	
	echo '</div>';	
} 
?>
</div>  <!-- End pagingContent -->

<script type="text/javascript">

$(document).ready(function() {
	if('<?php echo @$elementId;?>'){
		$('#lastInsertedMediaId').attr('value','<?php echo @$elementId;?>');
	}
});

</script>
