<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/common/tipsy-common.js"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	if($MediaFile['isExternal']=='t'){
		$fileType='external';
		$embedCode=$MediaFile['filePath'];
		$file=urlencode($embedCode);
		$fileDirPath='';
		
	}else{
		$fileType=2;
		$fileDirPath=$file=$MediaFile['filePath'].$MediaFile['fileName'];
		$embedCode='';
	}
	$isExternal=$MediaFile['isExternal'];
	$MediaFileType=isset($MediaFile['fileType'])?$MediaFile['fileType']:'';
	$jobStsatus=isset($MediaFile['jobStsatus'])?$MediaFile['jobStsatus']:'';
	
	$imgSrc = '<img class="formTip ptr maxWH30 ma" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
	
	$title=($isDefaultElement=='_interview')?$dataProject['interviewTitle']:$dataProject['introductoryTitle'];
	$description=($isDefaultElement=='_interview')?$dataProject['interviewDescription']:$dataProject['introductoryDescription'];
	
	$jsonData=($isDefaultElement=='_interview')?array(
		'interviewTitle'=>$title,
		'interviewDescription'=>$description,
		'fileId'=>$fileId,
		'fileName'=>$MediaFile['fileName'],
		'rawFileName'=>$MediaFile['rawFileName'],
		'fileSize'=>$MediaFile['fileSize'],
		'isExternal'=>$MediaFile['isExternal'],
		'embedCode'=>$embedCode
	):array(
		'introductoryTitle'=>$title,
		'introductoryDescription'=>$description,
		'fileId'=>$fileId,
		'fileName'=>$MediaFile['fileName'],
		'rawFileName'=>$MediaFile['rawFileName'],
		'fileSize'=>$MediaFile['fileSize'],
		'isExternal'=>$MediaFile['isExternal'],
		'embedCode'=>$embedCode
	);
	
	$jsonData=json_encode($jsonData);
	
	
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
		echo '<div class="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="'.$fileId.'" /></div>';
	}
	?>
	
	<script>
	 var data<?php echo $isDefaultElement;?> = <?php echo $jsonData;?>;
	</script>

<div class="extract_img_wp"> 
	<?php echo $imgSrc;?>
</div>
<div class="extract_heading_box"> <?php echo $title;?> </div>

<div class="extract_button_box">
  <?php
	if($convsrsionFlag){ ?>
		<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
		<?
	}
	if($fileId > 0){?>
		<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $elemetTable;?>','<?php echo $elementFieldId;?>',<?php echo $elementId;?>,'','','','<?php echo $fileId;?>','<?php echo $fileDirPath;?>',0,'<?php echo $isDefaultElement;?>',1)"><div class="cat_smll_plus_icon"></div></a></div>
		<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="changeSCFileFormValue(data<?php echo $isDefaultElement;?>,'<?php echo $isDefaultElement;?>')" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
		<?php
	}else{ ?>
		<div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="changeSCFileFormValue(data<?php echo $isDefaultElement;?>,'<?php echo $isDefaultElement;?>')"><div class="cat_smll_add_icon"></div></a></div>
		<?php
	}
  ?>
</div>
