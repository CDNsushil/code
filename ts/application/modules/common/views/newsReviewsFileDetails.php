<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$MediaFileType=isset($MediaFile['fileType'])?$MediaFile['fileType']:'';
	$jobStsatus=isset($MediaFile['jobStsatus'])?$MediaFile['jobStsatus']:'';
	$isExternal=@$MediaFile['isExternal']=='t'?'t':'f';
	$isWrittenFileExternal=@$dataProject['isWrittenFileExternal'];
	$embedCode=$isWrittenFileExternal==2?@$MediaFile['filePath']:'';
	if($isWrittenFileExternal==1){
		$fileDirPath=$file=@$MediaFile['filePath'].@$MediaFile['fileName'];
		if(!is_file($file)){
			$fileDirPath=$file='';
		}
	}else{
		$fileDirPath='';
		$file='';
	}
	$Data=array(
					'imgSrc'=>$src,
					'fileTitle'=>@$dataProject['title'],
					'article'=>@$dataProject['article'],
					'articleSubject'=>@$dataProject['articleSubject'],
					'industryId'=>@$dataProject['industryId'],
					'genreId'=>@$dataProject['genreId'],
					'freeGenre'=>@$dataProject['freeGenre'],
					'languageId'=>@$dataProject['languageId'],
					'wordCount'=>@$dataProject['wordCount'],
					'isExternal'=>@$isExternal=='t'?'t':'f',
					'isExternal'=>@$isExternal=='t'?'t':'f',
					'isWrittenFileExternal'=>@$isWrittenFileExternal,
					'rawFileName'=>@$MediaFile['rawFileName'],
					'fileName'=>@$MediaFile['fileName'],
					'fileType'=>@$MediaFile['fileType'],
					'fileSize'=>@$MediaFile['fileSize'],
					'fileInput'=>@$MediaFile['fileName'],
					'embbededURL'=>@$embedCode,
					'fileLength'=>@$MediaFile['fileLength']?@$MediaFile['fileLength']:'00:00:00:00',
					'elementId'=>@$elementId,
					'fileId'=>@$fileId
	);
	$jsonData=json_encode($Data);
	
	$createdDate = @$dataProject['createdDate']?@$dataProject['createdDate']:date('Y-m-d');
	$createdDate = date('d M Y',strtotime($createdDate));
	
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
	
	if($append){ ?>
		<div class="row" id="row<?php echo $elementId;?>">
			  <div class="label_wrapper cell"> <div class="labeldiv"> <span><?php echo $this->lang->line('article');?></span> <?php echo $createdDate;?> </div></div>
			  <div id="rowData<?php echo $elementId;?>" class=" cell frm_element_wrapper extract_content_bg">
		<?php
	}
	?>
	<script>
		var data<?php echo $elementId?> = <?php echo $jsonData;?>;
	</script>
	<div class="extract_img_wp">
		<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>" title="<?php echo getSubString($dataProject['title'],25)?>"  />
	</div>
	<!--extract_img_wp-->
	<div class="extract_heading_box"><?php echo $dataProject['title']?></div>
	<!--extract_heading_box-->
	<div class="extract_quota_box">
		<?php 
			if($dataProject['wordCount'] > 0) echo $dataProject['wordCount'].'&nbsp;'.$this->lang->line('words').'&nbsp;'; 
			if(@$MediaFile['fileLength'] > 0) echo number_format((@$MediaFile['fileLength']/1073741824),2).'&nbsp;'.$this->lang->line('gb');
		?>
		<?php //echo @$MediaFile['fileLength'];?></div>

	<!--extract_quota_box-->

	<div class="extract_button_box">
	  <?php
			if($convsrsionFlag){ ?>
				<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
				<?
			}
		?>
	  <div class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $elemetTable;?>','<?php echo $elementFieldId;?>',<?php echo $elementId;?>,'','','',<?php echo $fileId;?>,'<?php echo $fileDirPath;?>',1,'<?php echo $deleteCache;?>',1)"><div class="cat_smll_plus_icon"></div></a></div>
	  <div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="changeUploadMediyaFormValue(data<?php echo $elementId;?>)" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
	</div>
<?php
if($append){ ?>
	</div>
	<?php
}
?>
