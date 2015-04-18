<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$EMC='';
	$VFMC='orange';
	$EUS='dn';
	$VFS='';
	$required=isset($required)?$required:'';
	$isReloadPage=(isset($isReloadPage) && is_numeric($isReloadPage) && ($isReloadPage ==0))?0:1;
	$select_field=($required=='required')?'select_field':'';
	
	$editFlag=isset($editFlag)?$editFlag:false;

	$typeOfFile=isset($typeOfFile)?$typeOfFile:2; 
	$browseId=isset($browseId)?$browseId:'';
	$fileName=isset($fileName)?$fileName:''; 
	$isUploadEmbedOption=isset($isUploadEmbedOption)?$isUploadEmbedOption:true; 
	
	$imgSrc=(isset($imgSrc) && $imgSrc != '')?$imgSrc:base_url('images/profile_icon.png'); 
	
	$allowedMediaType=str_replace('|',',',$mediaFileTypes);
	$allowedMediaType=str_replace(',',', ',$allowedMediaType);
	
	$UFS=$EB=$EU=$UB=$UF='';

	if($editFlag){
			$UFS='dn';
			$EB=$EU='';
		}
	
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseId,
		'value'	=> $fileName,
		'id'	=> 'fileName'.$browseId,
		'type'	=> 'hidden'
	);
	
	$fileSizeInput = array(
		'name'	=> 'fileSize'.$browseId,
		'value'	=> $fileSize,
		'id'	=> 'fileSize'.$browseId,
		'type'	=> 'hidden'
	);
	
	$advertIdInput = array(
		'name'	=> 'bannerid',
		'value'	=> '',
		'id'	=> 'bannerid',
		'type'	=> 'hidden'
	);
	
	
	
	$typeOfFileInput = array(
		'name'	=> 'fileType'.$browseId,
		'value'	=> $typeOfFile,
		'id'	=> 'fileType'.$browseId,
		'type'	=> 'hidden'
	);
	
	if(isset($imgload) && $imgload==1)
	{
		$imgLoadClass = ' cell mt20';
		$inputWidth = 'width330px ';
		$browse_box="browse_box row";
	}
	else
	{
		$imgLoadClass = '';
		$inputWidth = 'width480px ';
		$browse_box="row";
	}
	
	$inputArray = array(
		'name'	=> 'fileInput'.$browseId,
		'class'	=> $inputWidth.$required,
		'value'	=> '',
		'id'	=> 'fileInput'.$browseId,
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$fileUploadPathInput = array(
		'name'	=> 'fileUploadPath'.$browseId,
		'value'	=> $filePath,
		'id'	=> 'fileUploadPath'.$browseId,
		'type'	=> 'hidden'
	);

	$fileHeightInput = array(
		'name'	=> 'fileheight',
		'id'	=> 'fileheight',	
		'class'	=> 'width178px number ',
		'value'	=> '',
		'readonly' => 'readonly',
		'maxlength'	=> 10,
		'size'	=> 50,
	);		

	$fileWidthInput = array(
		'name'	=> 'filewidth',
		'id'	=> 'filewidth',	
		'class'	=> 'width178px number ',
		'value'	=> '',
		'readonly' => 'readonly',
		'maxlength'	=> 10,
		'size'	=> 50,
	);
	
	$campaignIdInput = array(
		'name'	=> 'campaignId',
		'value'	=> $campaignId,
		'id'	=> 'campaignId',
		'type'	=> 'hidden'
	);
	
	$updateAdvertTypeInput = array(
		'name'	=> 'uploadAdvertOrder',
		'value'	=> '',
		'id'	=> 'uploadAdvertOrder',
		'type'	=> 'hidden'
	);
	$sectionIdInput = array(
		'name'	=> 'sectionIds'.$browseId,
		'value'	=> '',
		'id'	=> 'sectionIds',
		'type'	=> 'hidden'
	);
	$sectionList = getSearchIndustryList();
	echo form_input($fileNameInput);
	echo form_input($fileSizeInput);
	echo form_input($typeOfFileInput);
	echo form_input($fileUploadPathInput);
	echo form_input($advertIdInput);
	echo form_input($campaignIdInput);
	echo form_input($updateAdvertTypeInput);
	echo form_input($sectionIdInput);

	if(!isset($flag))$flag=0;
	if(isset($flag) && $flag==1)  $VFS='';
	
	$fpLen=strlen($filePath);
	if($fpLen > 0 && substr($filePath,-1) != '/'){
		$filePath=$filePath.'/';
	}
	$fileTypeFlag=isset($fileTypeFlag)?$fileTypeFlag:false;
	$SFT=$fileTypeFlag?'':'dn';
	
	//Get industry listing 
	$advertsectionInput = array(
		'name'	=> 'advertsectionInputContainer',
		'id'	=> 'advertsectionInputContainer',
		'class'	=> 'textarea_small_bg clr_darkgrey required',
		'value'	=> '',
		'cols'	=> 40,
		'rows'	=> 3,
		'readonly' => true
	);
	
	$intrestedCountriesID = array();
	if(!empty($countriesInterestWorking)) {
		$intrestedCountriesID = explode('|',$countriesInterestWorking);
	}else{
		$intrestedCountriesID[]=0;
	}
	
?>

<div id="uploadFileByJquery<?php echo $browseId;?>"></div>
<div id="FileContainer<?php echo $browseId;?>" class="fr">
	<div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
		<div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
			<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
			<div class="plupload_progress_container fl">
				<div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div>
			</div>
		</div>
		<span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span>
	</div>
	<div id="dropArea<?php echo $browseId;?>"></div>
</div>
<div id="uploadFileSection<?php echo $browseId;?>" class="row <?php echo $UFS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<div class="<?php echo $browse_box;?>">
			<div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
				<div id="FileUpload<?php echo $browseId;?>">
						<div class="fl"><?php echo form_input($inputArray); ?></div>					
						<div class="tds-button fl btn_span_hover <?php if(!isset($imgload) || $imgload==0) echo 'ml5';else echo '';?>" id="browsebtn<?php echo $browseId;?>"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
						<div class="font_size11 row width100percent"><?php $mediaTypeToShow = $browseId.'TypeToShow';echo '<div class="cell pr2">'.$this->lang->line('allowedExt').'</div><div class="cell"  id="allowedMediaType'.$browseId.'">'.$allowedMediaType.'</div>';?></div>
						<div id="fileError<?php echo $browseId;?>" class="row wordcounter orange"></div>
				</div>
				<div id="rawFileNameDiv<?php echo $browseId;?>"></div>
			</div>
			<div class="clear"></div>
		</div>  
	</div>
	
	<div class="seprator_5"></div>
	
	<div id="fileTypeRuntimeDiv<?php echo $browseId;?>"><input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" /></div>
</div>
 
<div id="dimensionsDiv<?php echo $browseId;?>" class="row">
	<div class="label_wrapper cell">
	  <label>Dimensions</label>
	</div>
	<!--label_wrapper-->
	<div class=" cell frm_element_wrapper"> 
		<div class="cell">
				 <?php echo form_input($fileWidthInput); ?>												 
		</div>                                           
		<div class="cell ml20 mr20 mt5"> X </div>											 
		<div class="cell">
			<?php echo form_input($fileHeightInput);  ?>												
		</div>
		<div class="cell ml15">
			<div class="small_select_wp_a">														
				<select id="fileUnit" name="fileUnit" class="width_122" onchange="checkUnit()" title="<?php echo $this->lang->line('requiredmSg');?>">
					<option value="px"><?php echo $this->lang->line('pixels');?></option>                                                            															
				</select>
				<div id="fileUnitError" class="dn error"><?php echo $this->lang->line('requiredmSg');?></div>
			</div>
		</div>
	<div class="clear"></div>
	<div class="seprator_13"></div>
	</div>
</div>

<!-- Div start here for advert sections -->
<div class="row">
	<div class="label_wrapper cell">
		<label><?php echo $this->lang->line('sections');?></label>
	</div>
	<div class="cell frm_element_wrapper"> 
		<?php
		//echo "<pre>";
		//print_r($industrySections);
		//echo "------------------";
		
		//echo "<pre>";
		//print_r($continentWiseCountry);
		if(isset($industrySections) && is_array($industrySections) && count($industrySections) > 0){ ?>
			<div class="cell">
				<div class="row">
					<div class="cell">
						<div class="countryListing" id="countryListing">
							<div class="shiping_select_box02 width220px height155px">	
								<div class="mr10 ml15 mt10" >
									<?php
									foreach($industrySections as $section){
										$checked=in_array($section->IndustryId, $intrestedCountriesID)?'checked':''; 
										?>
										<div id="industryUpload_<?php echo $section->IndustryId;?>">
											<div class="defaultP">
												<input type="checkbox" class="CheckBox" name="sectionCheckBox[]" id="section_<?php echo $section->IndustryId;?>" value="<?php echo $section->IndustryId; ?>" title="<?php echo $section->IndustryName; ?>" <?php echo $checked;?>  />
											</div>
											<div class="cell ml10 width135px"><?php echo $section->IndustryName;?></div>
											<div class="bdr_below_checkbox clear"></div>
										</div>
									<?php
									}
									?>
									<div class="clear seprator_9"> </div>
								</div>
							</div>	
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="cell fr mr135">
				<div class=" width200px">
					<?php echo form_textarea($advertsectionInput); ?>
				</div>
				<div class="seprator_5 clear"></div>
				<div class="note_belw_textarea"> <?php echo $this->lang->line('competitionCountriesMsg');?></div>
			</div>
		<?php } ?>
	</div> 
</div>
<!-- Div end here for advert sections -->
<script type="text/javascript">
	//Manage upload adverts sections listing
	$(document).ready(function(){	
		$(".CheckBox").click(function(){
			var sectionName = new Array();
			var sectionVal = new Array();
		
			$('.CheckBox:checkbox:checked').each(function(i){
				  sectionVal[i] = $(this).val();  
				  sectionName[i]= $(this).attr('title');
			});	
			//Set name and ids of sections
			$('#advertsectionInputContainer').val(sectionName);
			$('#sectionIds').val(sectionVal);
		});
		
		//uncheck all checked section on cancle 
		$("#CGcancelButton").click(function(){
			$('.CheckBox').parent().removeClass('ez-checked');
		});
	});
	
	

	uploadAdvertFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseId;?>',1,'<?php echo $isReloadPage;?>',0,'<?php echo $imgload;?>','','_xs');
</script>
