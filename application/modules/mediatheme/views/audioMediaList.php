<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$controllerName = $this->router->class;
$promoMediaListAttributes = array(
	'name'=>'videoMediaList',
	'id'=>'videoMediaList',
	'action'=>''	 
);
$toggleId='audio';
$browseImgJs = $toggleId;
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
		$audiocount=count($listValues);
		$i_audio = 0;
		foreach($listValues as $key=>$listValue){
	
		$i_audio++;
			
			
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
				
			$fileLength = $listValue['fileLength'];
			
			$mediaId = $listValue['mediaId'];
			$imagePath = $listValue['mediaPath'];
			$imageName = $listValue['mediaName'];
			$entityId = $listValue['mediaId'];

			$style = "vertical-align:middle; padding:5px;clear:both; height:82px; width:82px; display:inline-table;";
			$styleFeatured = "vertical-align:middle; padding:5px; clear:both; outline:3px solid #FC5B1F; height:82px; width:82px; display:inline-table; overflow:hidden";
			
			$uniqueRowId="imgRow".$listValue['fileId'];
			$uniqueImgRowId="#imgRow";
				
			$img=getImage($imagePath.$imageName);
			
			if($listValue['mediaDesc']!='') 
				$mediaToolTip = $imgDesc = $listValue['mediaDesc'];
			else 
				$mediaToolTip = $imgDesc = $listValue['rawFileName']; 
			
			
					    //$imageSrc = '<img src="'.$img.'" class="formTip " title="'.$imgDesc.'" id="galImg_'.$listValue['mediaId'].'" />';						
					   // $imageSrc = '<img   src="'.$img.'" title="'.$imgDesc.'" id="galImg_'.$listValue['mediaId'].'" />';						
						//echo anchor('javascript://void(0);', $imageSrc,$editArr);
		$embedCode='';	
		if( isset($listValue['fileId']) && $listValue['fileId']>0)
			{  
				/*$videoFileDetail = getMediaDetail($listValue['fileId'],'fileName,filePath');
				
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
				$fileType = 3;
				$fileType=($listValue['isExternal']=='t')?5:$fileType;
				
				/**************assign variable for playing audio start******************/
			
					 $fileID= $listValue['fileId'];
					 $entityID= getMasterTableRecord('WorkProfile');
					 $projectID= $listValue['workProfileId'];
					 $elementID= $listValue['mediaId'];
					 //mediaId/entityId/projectId/elementId
				/**************assign variable for playing audio end******************/
				
				
				if($file=='')
				{
					$imgVideoSrc = '<img class="formTip ptr maxWH30 ma"  src="'.base_url().'images/audio.png" />';
				}
				else
				{
					$imgVideoSrc = '<img  class="formTip ptr maxWH30 ma"  id ="showVideo'.$uniqueRowId.'"   src="'.base_url().'images/audio.png" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonAudio\',\''.$fileID.'\',\''.$entityID.'\',\''.$projectID.'\',\''.$elementID.'\');" />';
				}				
			}			
			
			else 
			{
				$imgVideoSrc = '<img class="formTip ptr maxWH30 ma" width="100" src="'.base_url().'images/audio.png" />';
			}
	
					
			$editattr = array('mediafileId'=>$listValue['fileId'],
			'mediaPromoId'=>$listValue['mediaId'],
			'mediaTitle'=>$listValue['mediaTitle'],
			'mediaDesc'=>$listValue['mediaDesc'],
			'rawFileName'=>$listValue['rawFileName'],
			'isExternal'=>$listValue['isExternal'],
			'embbededURL'=>$embedCode,
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
					
<div class="label_wrapper cell bg_none"></div><!-- label_wrapper cell-->
<div class=" cell frm_element_wrapper extract_content_bg" id="<?php echo $uniqueRowId;?>">
	<div class="extract_img_wp"> 
	<?php echo $imgVideoSrc;?>
	</div>
	<!--extract_img_wp-->
	<div class="extract_heading_box"> 
	<?php
		if($mediaTitle!='') 
		echo $mediaTitle; 
		else 
		echo "notAvalue";
	?>
	</div>
<!--extract_heading_box-->
	<div class="extract_quota_box"> </div>
<!--extract_quota_box-->
<?php 
		if(strcmp($this->router->method,'launchEventForm')==0) $entityMediaType=3;//to distinush the launch event type to get deleted form launch table

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
	<!--extract_quota_box-->
	<div class="extract_button_box">
		
		<?php
			if($convsrsionFlag){ ?>
				<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
				<?php
			}
		  ?>
		<div title="Delete" class="small_btn formTip">
		<?php 
			$delBtnArr = array(
			"title"=>$this->lang->line("delete"),
			"class"=>"small_btn formTip",
			"onclick"=>"deleteTabelRowMedia(deleData".$mediaId.")",
			);						
			$deleImageSrc = '<div class="cat_smll_plus_icon"></div>';
			echo anchor('javascript://void(0);', $deleImageSrc,$delBtnArr);	
			?>		


		</div>
		<div title="Edit" class="small_btn formTip">
		
		<script>
		var editDataAudio<?php echo $mediaId;?> = <?php echo $editJsonMedia; ?>;
		</script>
			<?php
			$editBtnArr = array('title'=>'Edit',
			'class'=>"GalId".$toggleId." formTip",
			'id'=>"GalId".$toggleId, 
			'title'=>$this->lang->line('edit'),
			'onclick' => 'editMediaWs(editDataAudio'.$mediaId.',\''.$toggleId.'\');'
			);					

			$editImageSrc = '<div class="cat_smll_edit_icon"></div>';

			echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);
		?>				
		<div class="cat_smll_edit_icon"></div></a>
		</div>
	</div>
	<?php if($i_audio == $audiocount) echo '<div class="row heightSpacer"></div>'; ?>
</div>

<script>
var deleData<?php echo $mediaId;?> = <?php echo $jsonMedia; ?>;
</script>

<?php 
	 } 	
	} 
	else {		
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
		

</div>
