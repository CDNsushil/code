<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/common/tipsy-common.js"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$isExternal=@$MediaFile['isExternal']?$MediaFile['isExternal']:'f';
	$embedCode=$isExternal=='t'?$MediaFile['filePath']:'';
	if($isExternal=='t'){
		$src=(isset($defaultImage) && $defaultImage!='')?$defaultImage:'';
		$file=getUrl($embedCode);
		$fileType='external';
		$fileDirPath='';
	}else{
		$file=$MediaFile['filePath'].$MediaFile['fileName'];
		$fileDirPath=$file=is_file($file)?$file:'';
		$fileType=trim(strtolower(@$MediaFile['fileType']));
	}
	
	$fileLength=isset($MediaFile['fileLength'])?$MediaFile['fileLength']:'00:00:00';
	$fileLengthExplode=explode(':',$fileLength);
	$hh=(isset($fileLengthExplode[0]) && is_numeric($fileLengthExplode[0]))?$fileLengthExplode[0]:'00';
	$mm=(isset($fileLengthExplode[1]) && is_numeric($fileLengthExplode[1]))?$fileLengthExplode[1]:'00';
	$ss=(isset($fileLengthExplode[2]) && is_numeric($fileLengthExplode[2]))?$fileLengthExplode[2]:'00';
	
	$MediaFileType=isset($MediaFile['fileType'])?$MediaFile['fileType']:'';
	$jobStsatus=isset($MediaFile['jobStsatus'])?$MediaFile['jobStsatus']:'';
	$fileWidth=isset($MediaFile['fileWidth'])?$MediaFile['fileWidth']:0;
	$fileHeight=isset($MediaFile['fileHeight'])?$MediaFile['fileHeight']:0;
	$wordCount=isset($dataProject['wordCount'])?$dataProject['wordCount']:0;
	$fileUnit=isset($MediaFile['fileUnit'])?$MediaFile['fileUnit']:'px';
						
	$Data=array(
					'imgSrc'=>$src,
					'fileTitle'=>@$dataProject['title'],
					'isExternal'=>$isExternal,
					'rawFileName'=>@$MediaFile['rawFileName'],
					'fileName'=>@$MediaFile['fileName'],
					'fileSize'=>@$MediaFile['fileSize'],
					'fileInput'=>@$MediaFile['fileName'],
					'fileType'=>@$MediaFile['fileType'],
					'embbededURL'=>$embedCode,
					'fileLength'=>$fileLength,
					'hh'=>$hh,
					'mm'=>$mm,
					'ss'=>$ss,
					'downloadPrice'=>@$dataProject['downloadPrice']?@$dataProject['downloadPrice']:00.00,
					'perViewPrice'=>@$dataProject['perViewPrice']?@$dataProject['perViewPrice']:00.00,
					'price'=>@$dataProject['price']?@$dataProject['price']:00.00,
					'quantity'=>(isset($dataProject['quantity']) && $dataProject['quantity'] >0)?$dataProject['quantity']:1,
					'isDownloadPrice'=>@$dataProject['isDownloadPrice']=='t'?'t':'f',
					'isPerViewPrice'=>@$dataProject['isPerViewPrice']=='t'?'t':'f',
					'isPrice'=>@$dataProject['isPrice']=='t'?'t':'f',
					'elementId'=>$elementId,
					'mediaTypeId'=>@$dataProject['mediaTypeId'],
					'fileId'=>$fileId,
					'isDefaultElement'=>$isDefaultElement
	);
	if($elemetTable=='WpElement'){$jsonData['wordCount']=@$dataProject['wordCount'];}
	$jsonData=json_encode($Data);
	

	if($MediaFileType=='audio'|| $MediaFileType==3){
		$lenghtString=($fileLength=='0:0:0' || $fileLength=='00:00:00')?'':$fileLength;
	}
	elseif($MediaFileType=='text' || $MediaFileType==4){
		$lenghtString=($wordCount > 0)?$wordCount.'&nbsp;'.$this->lang->line('words'):'';
	}
	elseif($MediaFileType=='image' || $MediaFileType==1){
		$lenghtString=($fileHeight > 0 && $fileWidth > 0)?$fileHeight.' x '.$fileWidth.' '.$fileUnit:''; 
	}
	else{
		$lenghtString=($fileLength=='0:0:0' || $fileLength=='00:00:00')?'':$fileLength;
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
		var data<?php echo $dataProject['mediaTypeId']?> = <?php echo $jsonData;?>;
	</script>

<div class="extract_img_wp">
	<?php
		if(trim(strtolower($MediaFile['fileType']))=='video' || $MediaFile['fileType']==2 || $MediaFile['fileType']==3 || trim(strtolower($MediaFile['fileType']))=='audio'){
			?>
			<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $dataProject['title']?>" onclick="openLightBox('loginLightBoxWp','loginFormContainer','/common/playMediaFile','<?php echo $file?>','<?php echo $fileType;?>',5);" />
			<?php
		}else{ ?>
			<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>" title="<?php echo $dataProject['title']?>"  />
		<?}
		?>
</div>
<!--extract_img_wp-->
<div class="extract_heading_box width_240"><?php echo getSubString($dataProject['title'],25)?></div>
<div class="extract_quota_box"><?php echo $lenghtString;?></div>
<?php if($isDefaultElement=='f' && ($Data['isDownloadPrice']=='t' || $Data['isPerViewPrice']=='t' || $Data['isPrice']=='t')){?>
		<div class="extract_quota_box width30px">
			<?php if($isExternal=='f'){
				$priceTag="<div class='priceTag'>";
							if( $Data['isDownloadPrice']=='t'){	
								$priceTag.="<div class='price'>
									".$this->lang->line('download')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format( $Data['downloadPrice'],2)."
								</div>";
							}
							if( $Data['isPerViewPrice']=='t'){		
								$priceTag.="<div class='price'>
									".$this->lang->line('ppv')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format( $Data['perViewPrice'],2)."
								</div>";
							}
							if( $Data['isPrice']=='t'){		
								$priceTag.="<div class='price'>
									".$this->lang->line('product')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format( $Data['price'],2)."
								</div>";
							}	
							$priceTag.="</div>";
				?>
				<div class="projectticketicon formTip" title="<?php echo $priceTag;?>" ></div>
				
				<?php
			}
			?>
		</div> 
		<?php
	}
	?>
<!--extract_quota_box-->

<div class="extract_button_box">
  <?php
	if($convsrsionFlag){ ?>
		<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
		<?
	}
  ?>
  <div class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $elemetTable;?>','<?php echo $elementFieldId;?>','<?php echo $elementId;?>','','','','<?php echo $fileId;?>','<?php echo $fileDirPath;?>',1,'<?php echo $deleteCache;?>',1)"><div class="cat_smll_plus_icon"></div></a></div>
  <div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="changeUploadMediyaFormValue(data<?php echo $dataProject['mediaTypeId']?>)" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
</div>
