<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$browseImgJs = $toggleId;
$controllerName = $this->router->class;
$promoMediaListAttributes = array(
	'name'=>'promoMediaList',
	'id'=>'promoMediaList',
	'action'=>''	 
);

if(isset($fileId) && $fileId > 0){
	echo '<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
}
?>
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
			
		$writeMatcount=count($listValues);
		$i_writeMat = 0;
		foreach($listValues as $key=>$listValue){
						
		$i_writeMat++;			
			
		$mediaPath = $listValue['mediaPath'].$listValue['mediaName'];

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
		$imagePath = $listValue['mediaPath'];
		$imageName = $listValue['mediaName'];
		$entityId = $listValue['mediaId'];
		$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
		$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";
		
		$uniqueRowId="imgRow".$listValue['fileId'];
		$uniqueImgRowId="#imgRow";
			
		 if($listValue['mediaDesc']!='') 
			$mediaToolTip = $imgDesc = $listValue['mediaDesc'];
		else 
			$mediaToolTip = $imgDesc = $listValue['rawFileName'];  
						
		$img = getImage($imagePath.$imageName);
		
		$editArr = array('title'=>'Edit',
		'class'=>"formTip",
		'id'=>"GalId", 
		'mediafileId'=>$listValue['fileId'],
		'mediaPromoId'=>$listValue['mediaId'],
		'mediaTitle'=>$listValue['mediaTitle'],
		'mediaDescription'=>$listValue['mediaDesc'],
		'title'=>$mediaToolTip,
		'fileName' => $imageName ,
		'onclick' => '$(\'#writMaterForm-Content-Box\').slideDown(\'slow\');'
		);	

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
		
		$delBtnArr = array(
		"title"=>$this->lang->line("delete"),
		"class"=>"formTip",
		
		"onclick"=>"deleteTabelRowMedia(deleData".$mediaId.")",
		);						
		$deleImageSrc = '<div class="cat_smll_plus_icon"></div>';
		
		$editattr = array('mediafileId'=>$listValue['fileId'],
			'mediaPromoId'=>$listValue['mediaId'],
			'mediaTitle'=>$listValue['mediaTitle'],
			'mediaDesc'=>$listValue['mediaDesc'],
			'rawFileName'=>$listValue['rawFileName'],
			'isExternal'=>$listValue['isExternal'],
			'embbededURL'=>'',
			'browseImgJs'=>$browseImgJs,
			'fileName' => $imageName );
			$editJsonMedia=json_encode($editattr);
			
			$convsrsionFlag=false;
			$convsrsionFileType=$this->config->item('convsrsionFileType');
			if($listValue['isExternal']=='f' && in_array($listValue['fileType'],$convsrsionFileType)){
				$convsrsionFlag=true;
				if($listValue['jobStsatus'] == 'DONE'){
					$conversionStatusClass='icon_filesent';
					$conversionStatusToolTip=$this->lang->line('Converted');
				}elseif($listValue['jobStsatus'] == 'FAILS'){
					$isconverted=false;
					$conversionStatusClass='icon_filetransfer';
					$conversionStatusToolTip=$this->lang->line('conversionFailed');
				}else{
					$isconverted=false;
					$conversionStatusClass='icon_inprocess';
					$conversionStatusToolTip=$this->lang->line('converting');
				}
			}
			?>
		<script>
		var editDataWritMat<?php echo $mediaId;?> = <?php echo $editJsonMedia; ?>;
		</script>
			<?php
			$editBtnArr = array('title'=>'Edit',
			'class'=>"GalId".$toggleId." formTip",
			'id'=>"GalId".$toggleId, 
			'title'=>$this->lang->line('edit'),
			'onclick' => 'editMediaWs(editDataWritMat'.$mediaId.',\''.$toggleId.'\');');
				
		
		
		if( isset($listValue['fileId']) && $listValue['fileId']>0)
		{  
			/*$videoFileDetail = getMediaDetail($listValue['fileId'],'fileName,filePath,isExternal');
			if(is_array($videoFileDetail)){
				$file = $videoFile =  $videoFileDetail[0]->filePath.'/'.$videoFileDetail[0]->fileName;
			}
			else $file = $videoFile = '';*/
			$filePath=$listValue['filePath'];
			$isExternal=$listValue['isExternal'];
			$fpLen=strlen($filePath);
			if($fpLen > 0 && substr($filePath,-1) != '/'){
				$filePath=$filePath.'/';
			}
			$file = $videoFile =  $filePath.$listValue['fileName'];
			
			$file=($listValue['isExternal']=='t')?urlencode($listValue['filePath']):$file;
			
			$embedCode=$isExternal=='t'?$listValue['filePath']:'';
			$fileType = 2;
			$fileType=($listValue['isExternal']=='t')?'external':$fileType;
			
			/**************assign variable for playing video start******************/
			
			 $fileID= $listValue['fileId'];
			 $entityID= getMasterTableRecord('WorkProfile');
			 $projectID= $listValue['workProfileId'];
			 $elementID= $listValue['mediaId'];
			 //mediaId/entityId/projectId/elementId
			/**************assign variable for playing video end******************/
			
			if($file=='')
			{
				$imgTextSrc = '<img class="formTip ptr maxWH30 ma"  src="'.base_url().'images/text_icon.png" />';
			}
			else
			{
				$imgTextSrc = '<img class="formTip ptr maxWH30 ma"  id ="showVideo'.$uniqueRowId.'"   src="'.base_url().'images/text_icon.png" onclick="openLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonSwf\',\''.$fileID.'\',\''.$entityID.'\',\''.$projectID.'\',\''.$elementID.'\');" />';
			}				
		}			
		else 
		{
			$imgTextSrc = '<img class="formTip ptr maxWH30 ma"  width="100" src="'.base_url().'images/text_icon.png" />';
		}
		
		
		$editImageSrc = '<div class="cat_smll_edit_icon"></div>';
?>
<script>
var deleData<?php echo $mediaId;?> = <?php echo $jsonMedia; ?>;
</script>
			<div id="<?php echo $uniqueRowId;?>" class="imgCount">
			<div class="all_list_item">
			<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->
			<div class="cell frm_element_wrapper extract_content_bg" id="<?php echo $uniqueRowId;?>" class="imgCount">
			<div class="extract_img_wp"> 
			<?php echo $imgTextSrc; ?>
			</div>
			<!--extract_img_wp-->
			<div class="extract_heading_box"><?php echo $mediaTitle;?></div>
			<!--extract_heading_box-->										
			<div class="extract_button_box">
				<?php
					if($convsrsionFlag){ ?>
						<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
						<?php
					}
				  ?>
					<div class="cell pro_btns">
						<div class="small_btn">	
						<?php echo anchor('javascript://void(0);', $deleImageSrc,$delBtnArr);?>		
						</div>
						<div class="small_btn">						
						<?php echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);?>						
						</div>	<!-- small_btn -->
							
					</div> <!-- cell pro_btns -->    
				
			</div>
		</div>
	
	</div> <!-- End all_list_item -->  
<?php if($i_writeMat == $writeMatcount) echo '<div class="row heightSpacer"></div>'; ?>

</div>
<div class="clear"></div>
	
	<?php 
		} 
	} else {		
	?>

<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->
<?php
		echo '<div id="addLink"  class="cell frm_element_wrapper">';  		
		
		$noRecBtnArr = array('class' => 'a_orange',
	
						'onclick' => '$(\'#'.$toggleId.'Form-Content-Box\').slideDown(\'slow\');'
						);						
		echo anchor('javascript://void(0);', $this->lang->line('add'),$noRecBtnArr);
		
		echo '</div>';
		
		
		} ?>
		
</div>  <!-- End pagingContent -->

