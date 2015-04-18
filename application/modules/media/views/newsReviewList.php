<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
        
$itemCount=count($elements);
$k=0;
$imagetype=$fileConfig['defaultImage_xxs'];
$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
$elementEntityId=getMasterTableRecord($elemetTable);
$sectionId=$this->config->item($industryType.'SectionId');
if($elements){
	echo '<div class="clear"></div> ';
	$embedCode='';
	$r=0;
	$elementFileSize=0;
	foreach($elements as $k=>$element){
		$r++;
		$elementFileSize=($elementFileSize+$element->fileSize);
			$smallElementImg = addThumbFolder($element->imagePath,'_xxs');
			$src = getImage($smallElementImg,$imagetype);
			$isExternal=$element->isExternal=='t'?'t':'f';
			$isWrittenFileExternal=$element->isWrittenFileExternal;
			$embedCode=$isWrittenFileExternal==2?$element->filePath:'';
			if($isWrittenFileExternal==1){
				$fileDirPath=$file=$element->filePath.$element->fileName;
				if(!is_file($file)){
					$fileDirPath=$file='';
				}
			}else{
				$fileDirPath='';
				$file='';
			}
			
			$jsonData=array(
				'imgSrc'=>$src,
				'fileTitle'=>$element->title,
				'article'=>nl2br($element->article),
				'articleSubject'=>$element->articleSubject,
				'industryId'=>$element->industryId,
				'genreId'=>$element->genreId,
				'freeGenre'=>$element->freeGenre,
				'languageId'=>$element->languageId,
				'wordCount'=>$element->wordCount,
				'isExternal'=>$isExternal,
				'isWrittenFileExternal'=>$isWrittenFileExternal,
				'rawFileName'=>$element->rawFileName,
				'fileName'=>$element->fileName,
				'fileType'=>$element->fileType,
				'fileSize'=>$element->fileSize,
				'fileInput'=>$element->fileName,
				'embbededURL'=>$embedCode,
				'fileLength'=>$element->fileLength,
				'elementId'=>$element->elementId,
				'fileId'=>$element->fileId
			);
			
			$jsonData=json_encode($jsonData);
			
			$listLabel = (isset($industryType) && ($industryType=='reviews')) ? $this->lang->line('reviewListlabel') : $this->lang->line('article');
			
			$createdDate = $element->createdDate?$element->createdDate:date('Y-m-d');
			$createdDate = date('d M Y',strtotime($createdDate));
			
			$convsrsionFlag=false;
			$convsrsionFileType=$this->config->item('convsrsionFileType');
			
			if($element->isExternal=='f' && in_array($element->fileType,$convsrsionFileType)){
				$convsrsionFlag=true;
				if($element->jobStsatus == 'DONE'){
					$conversionStatusClass='icon_filesent';
					$conversionStatusToolTip=$this->lang->line('Converted');
				}elseif($element->jobStsatus == 'FAILS'){
					$conversionStatusClass='icon_filetransfer';
					$conversionStatusToolTip=$this->lang->line('conversionFailed');
				}else{
					$conversionStatusClass='icon_inprocess';
					$conversionStatusToolTip=$this->lang->line('converting');
				}
			}
			if((isset($element->default) && $element->default == 't') ||  ($element->isExternal == 't')){
					$isPurchasedItem=false;
			}else{
				$sellExpiryDate=$isPurchasedItem=checkDownloadPPVaccess($elementEntityId,$element->elementId,$element->projId);
			}
			?>
			
			<script>
				 var data<?php echo $element->elementId;?> = <?php echo $jsonData;?>;
			</script>
			
				   
			<div class="row" id="row<?php echo $element->elementId;?>">
			  <div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $listLabel ;?> </span><?php echo $createdDate;?> </div></div>									 
			  <div id="rowData<?php echo $element->elementId;?>" class="cell frm_element_wrapper extract_content_bg">
				<div class="extract_img_wp"> 
				<?php if(!empty($element->fileId)){?>
					<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>"  title="<?php echo $element->title; ?>"  onclick="openLightBox('popupBoxWp','popup_box','/common/playCommonSwf','<?php echo $element->fileId;?>','<?php echo $element->entityId;?>','<?php echo $element->projId;?>','<?php echo $element->elementId;?>');"  />
					<?php } else {  ?>
					<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>"  title="<?php echo $element->title; ?>"  />
					<?php } ?>
				</div>
				<!--extract_img_wp-->
				<div class="extract_heading_box width_200"> <?php  echo  getSubString($element->title,25); ?> </div>
				<!--extract_heading_box-->
				<div class="extract_quota_box width_90">
					<?php 
						if($element->wordCount > 0) echo $element->wordCount.' '.$this->lang->line('words').' '; 
						elseif($element->fileLength > 0) echo number_format(($element->fileLength/1048576),2).' '.$this->lang->line('mb');
					?>
				</div>
				<div class="extract_button_box">
				  <?php
					if($element->isPublished =='t') {
						$pubMrClass = 'mr52';
					} else {
						$pubMrClass = 'mr30';
					}
					
					if($convsrsionFlag){ ?>
						<div class="fl <?php echo $pubMrClass;?> formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
						<?php
					}
					if($isPurchasedItem){
						 $elementCannotDelete = $this->lang->line('elementCannotDelete').$sellExpiryDate;
						 $deleteFunction="customAlert('".$elementCannotDelete."');";
					}else{
						  $deleteFunction="moveMediaElementInTrash('".$element->projId."','".$elemetTable."','".$element->elementId."','".$sectionId."','".$this->lang->line('sureDelMsg')."');";
					}
					
					 if($element->isPublished =='t' && $element->isBlocked !='t') 
						echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_published').'</div>';
					 else if($element->isPublished !='t' && $element->isBlocked !='t')
						echo '<div class="cell orange_color fmoss mr12">'.$this->lang->line('not_published').'</div>';
					 else if( $element->isBlocked =='t')	
						echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_blocked').'</div>';
					
				  ?>
				  <div class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="<?php echo $deleteFunction;?>"><div class="cat_smll_plus_icon"></div></a></div>
				  <?php
					 if( $element->isBlocked !='t'){	?>
						<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="changeUploadMediyaFormValue(data<?php echo $element->elementId;?>)" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
						<?php
					 }else{
							echo '<div class="small_btn">&nbsp;</div>';
					 }
				  ?>
				 <!---make video image as project conver image code start--->	
					<?php 
					if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f"){ ?> 
						<!---<div  class="small_btn formTip" title="<?php //echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php //echo $elemetTable;?>',<?php //echo $elements[$k]->projId; ?>,<?php //echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>	 
					<?php } ?>
				<!---make video image as project conver image code end---> 
				  
				</div>
			  </div>
			</div>
		<?php
	}
	
}?> 

<div class="clear"></div>
<div class="clear seprator_10"></div>
<!-- PAGINATION -->  
<?php

if($items_total >  $perPageRecord){
	?>
	<div class="row">
		<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
		<div class="cell width_569 margin_left_16 pagingWrapper">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/'.$indusrty.'/editProject/uploadMedia/'.$projectId),"divId"=>"UploadedData","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php
}

if(!$elements){ ?>
	<div class="row pl20" id="noRecordFound">
		<div class="label_wrapper cell bg-non"> </div>
		<a class="a_orange formTip" href="javascript:void(0);" onclick="javascript:$('#uploadElementForm').show();" title="<?php echo $this->lang->line('add');?>"><?php echo $this->lang->line('add');?></a> 
	</div>
	<?php
} ?>  
