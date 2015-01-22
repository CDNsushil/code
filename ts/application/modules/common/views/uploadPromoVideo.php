<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/common/tipsy-common.js"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$userId=isLoginUser();
	$deleteCache='';
	if (array_key_exists('projId', $dataProject)) {    
		$delflag=1;
		$entityRelatedId = $dataProject['projId'];		
	}
	
	if (array_key_exists('workId', $dataProject)) {
		$delflag=1;
		$entityRelatedId = $dataProject['workId'];  
		$deleteCache='work_'.$entityRelatedId.'_'.$userId;  
	}
	
	if (array_key_exists('prodId', $dataProject)) {
		$delflag=2;
		$entityRelatedId = $dataProject['prodId'];   
		$deleteCache='product_'.$entityRelatedId.'_'.$userId;   
	}
	$isExternal= isset($MediaFile['isExternal'])?$MediaFile['isExternal']:'f';

	if(!isset($dataProject['mediaId']))
		$mediaId = 0;
	else
		$mediaId = $dataProject['mediaId'];
		
	$mediaTitle = @$dataProject['mediaTitle'];
	$mediaDescription = @$dataProject['mediaDescription'];
	$mediaDetail = getMediaDetail(@$thumbFileId);
	
	if(is_array($mediaDetail) && !empty($mediaDetail))
	{
		$thumbImgPath = $mediaDetail[0]->filePath;
		$thumbImgName = $mediaDetail[0]->fileName;
	}
	else
	{
		$thumbImgPath = '';
		$thumbImgName = '';
	}	
	

	$fileId = $dataProject['fileId'];
	$fileType = $mediaType = $dataProject['mediaType']; 
	$filePath=isset($MediaFile['filePath'])?$MediaFile['filePath']:'';
	$fileName=isset($MediaFile['fileName'])?$MediaFile['fileName']:'';
	$rawFileName=isset($MediaFile['rawFileName'])?$MediaFile['rawFileName']:'';
	$MediaFileType=isset($MediaFile['fileType'])?$MediaFile['fileType']:'';
	$jobStsatus=isset($MediaFile['jobStsatus'])?$MediaFile['jobStsatus']:'';
	
	//CHECKS IF EMBEDDED CODE IS USED THEN SHOW ACCORDINGLY
	$embedCode = $fileType=='embed'?$MediaFile['filePath']:'';
	
	if($isExternal=='t')
	{
		$uploadName = $file=urlencode($embedCode);
		$fileType='5';
	}
	else
	{
		$file=@$MediaFile['filePath'].'/'.@$MediaFile['fileName'];	
		$fileType=$MediaFile['fileType'];
		$uploadName=$thumbImgName;
	}
	
	$thumbSrc = $thumbImgPath.'/'.$thumbImgName;
			$smallImg = addThumbFolder(@$thumbSrc,'_xxs');
			$formthumbFinalImg = getImage($smallImg,$this->config->item('defaultImg'));
			
			if($mediaType==2) {
				$thumbFinalImg = getImage($smallImg,$this->config->item('defaultVideoImg'));
				$previewUrl = '/upcomingprojects/previewVideo/'.$mediaId;
				$mediaTypeValue = 'Video';
				$mediaClass = ' film_icon ';
			}
			else if($mediaType==3) {
				$thumbFinalImg = getImage($smallImg,$this->config->item('defaultAudioImg'));
				$previewUrl = '/upcomingprojects/previewAudio/'.$mediaId;
				$mediaTypeValue = 'Audio';
				$mediaClass = ' audio_icon ';
			}
			else{
				$thumbFinalImg = getImage($smallImg,$this->config->item('defaultDocImg'));
				$previewUrl = '/upcomingprojects/previewVideo/'.$mediaId;
				$mediaTypeValue = 'Text';
				$mediaClass = ' writing_icon ';
			}
	$embedCode=$isExternal=='t'?str_replace(array('&lt;','&gt;'),array('<','>'),$filePath):'';
	$Data = array(
		'mediaId'=>$elementId,
		'mediaTitle'=>$mediaTitle,
		'mediaDescription'=>$mediaDescription,
		'isExternal'=>$isExternal,
		'fileId'=>$fileId,
		'thumbFileId'=>@$thumbFileId,
		'mediaType'=>$mediaType,
		'filePath'=>$file,
		'rawFileName'=>$rawFileName,
		'embbededURL'=>$embedCode,
		'mediaTypeValue'=>$mediaTypeValue,
		'uploadName'=>$uploadName,
		'thumbSrc'=>$thumbFinalImg
	);
	
	$jsonData=json_encode($Data);
	
	
	$fileDirPath='';
	
	if($isExternal=='t')
	{
		$file=urlencode($filePath);
		$fileType='external';
	}
	else
	{
		
		$fpLen=strlen($filePath);
		if($fpLen > 0 && substr($filePath,-1) != '/'){
			$filePath=$filePath.'/';
		}
		$fileDirPath=$filePath.$fileName;
	}
	
	
	$convsrsionFlag=false;
	$convsrsionFileType=$this->config->item('convsrsionFileType');
	if($isExternal=='f' && in_array($MediaFileType,$convsrsionFileType)){
		$convsrsionFlag=true;
		if($jobStsatus == 'DONE'){
			$conversionStatusClass='icon_filesent';
			$conversionStatusToolTip=$this->lang->line('Converted');
		}elseif($jobStsatus == 'FAILS'){
			$conversionStatusClass='icon_filetransfer';
			$conversionStatusToolTip=$this->lang->line('conversionFailed');
		}else{
			$conversionStatusClass='icon_inprocess';
			$conversionStatusToolTip=$this->lang->line('converting');
		}
	}
	
	if(isset($fileId) && $fileId > 0){
		echo '<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
	}
	?>
	<script>
		var data<?php echo $mediaId;?>=<?php echo $jsonData;?>;
	</script>
	
<div class="cell width_569">
	<div class="extract_img_wp">
		
		<?php if($mediaType==4){ ?>
		<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>"  title="<?php echo $dataProject['mediaTitle']?>" onclick="javascript://void(0);" />
		<?php } else{ ?>
		<img class="formTip ptr maxWH30 ma" src="<?php echo $thumbFinalImg;?>" title="<?php echo $dataProject['mediaTitle']?>"  onclick="openLightBox('loginLightBoxWp','loginFormContainer','/common/playMediaFile','<?php echo $file?>','<?php echo $fileType;?>',5);" />
		<?php } ?>
	</div>
	<!--extract_img_wp-->
	<div class="extract_heading_box"><?php echo $dataProject['mediaTitle']?></div>
	<!--extract_heading_box-->
	<div class="extract_button_box">
		<?php
			if($convsrsionFlag){ ?>
				<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
				<?
			}
		?>
		<div class="small_btn">
			<a onclick="deleteTabelRow('<?php echo $elemetTable;?>','<?php echo $elementFieldId;?>','<?php echo $elementId;?>','','','','<?php echo $fileId;?>','<?php echo $fileDirPath;?>',1,'<?php echo $deleteCache;?>',1);" href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a>
		</div>
		<div class="small_btn">
			<a onclick ="editMediaFile(data<?php echo $mediaId;?>);" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
		</div>
	</div>
</div>
<div class="clear"></div>
