<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    $deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
	$elementEntityId=getMasterTableRecord($elemetTable);
	$sectionId=$this->config->item($industryType.'SectionId');
	$thumbFolder='thumb';
	$containerSize=(isset($LID->containerSize) && is_numeric($LID->containerSize))?$LID->containerSize:$this->config->item('defaultContainerSize');
	$dirname=$dirUploadMedia.$industryType.'/'.$projectId.'/';
	$dirSize=getFolderSize($dirname);
	$remainingBytes =($containerSize - $dirSize);
	if(!$remainingBytes > 0){
		$remainingBytes =0;
	}
	$containerSize=bytestoMB($containerSize,'mb');
	$dirSize=bytestoMB($dirSize,'mb');
	$remainingSize=($containerSize-$dirSize);
	if($remainingSize < 0){
			$remainingSize = 0;
	}
	$dirSize = number_format($dirSize,2,'.','');
	$remainingSize = number_format($remainingSize,2,'.','');
	
	$projSellstatus=$LID->projSellstatus;
	$isProjectForsell=false;
	$totalElementForShall=0;
	$showForm='dn';
	$showPrice='dn';
	$imagetype=$fileConfig['defaultImage_xxs'];
	$px="";
	
	$fileTypeFlag=$indusrty=='educationMaterial'?true:false;
	$createWaterMarkFlag=($indusrty=='photographyNart')?1:0;
	if($LID->isExternalImageURL=='t'){
		 $projectImage=trim($LID->projBaseImgPath);
	}else{
		$smallImg = addThumbFolder($LID->projBaseImgPath,'_xxs');
		$projectImage = getImage($smallImg,$imagetype);
	}
	$mediaTypeIds=array();
	$mediaTypeIds[]=0;
	$required='required';
	$imgSrc=$src=getImage('',$imagetype);
	$fileTitle='';
	$isExternal='f';
	$fileName='';
	$fileType=$fileConfig['typeOfFile'];
	$fileSize=0;
	$embedCode='';
	$fileLength='00:00:00';
	$downloadPrice=00.00;
	$perViewPrice=00.00;
	$quantity=0;
	$price=00.00;
	$isDownloadPrice='f';
	$isPerViewPrice='f';
	$isPrice='f';
	$elementId=0;
	$mediaTypeId=0;
	$fileId=0;
	$isDefaultElement='f';
	$editFlag=false;
	$wordCount=0;
	$rawFileName='';
	$RFCD='dn';
	
	$fileHeight='';
	$fileWidth='';
	$fileUnit='';
	if($elements){
		//Get element count
		
		foreach($elements as $k=>$element){
			$mediaTypeIds[$k]=$element->mediaTypeId;
			if(is_numeric($projectElementId) && $element->elementId==$projectElementId){
				$editFlag=true;
				$showForm='';
				$required='';
			if($industryType=='photographyNart'){					
				$finalElementImage=$element->filePath.$element->fileName;
				if($projSellstatus=='t'){
					$thumbFolder='watermark';
				}
				
			}else{
				
				$finalElementImage=$element->imagePath;
			}
			
			$elementThumbImage = addThumbFolder($finalElementImage,'_xxs',$thumbFolder);				
							
			$src = getImage($elementThumbImage,$imagetype);
				
				if($indusrty=='writingNpublishing' || $indusrty=='educationMaterial'){
					$wordCount=$element->wordCount;
				}
				$isDefaultElement=$element->default;
				$isExternal=$element->isExternal;
				$embedCode=$isExternal=='t'?$element->filePath:'';
				$embedCode=str_replace(array('&lt;','&gt;'),array('<','>'),$embedCode);
				
				if($isDefaultElement=='f' && $isExternal=='f' && $projSellstatus=='t' && $LID->showPrice == 't' ){
					$showPrice='';
				}
				$imgSrc=$src;
				$fileTitle=$element->title;
				$fileName=$element->fileName;
				$fileType=$element->fileType;
				$fileSize=$element->fileSize;
				$fileInput=$element->fileName;
				$embbededURL=$embedCode;
				$fileLength=$element->fileLength;
				$downloadPrice=$element->downloadPrice;
				$perViewPrice=$element->perViewPrice;
				$price=$element->price;
				$quantity=$element->quantity;
				$isDownloadPrice=$element->isDownloadPrice;
				$isPerViewPrice=$element->isPerViewPrice;
				$isPrice=$element->isPrice;
				$elementId=$element->elementId;
				$mediaTypeId=$element->elementTypeId;
				$fileId=$element->fileId;
				$isDefaultElement=$element->default;
				$rawFileName=$element->rawFileName;
				
				$fileHeight=isset($element->fileHeight)?$element->fileHeight:'';
				$fileWidth=isset($element->fileWidth)?$element->fileWidth:'';
				$fileUnit=isset($element->fileUnit)?$element->fileUnit:'';
				
				if(strlen($fileName)>4){
					$RFCD='';
				}
			}
		}
	}
	
	$seller_currency=LoginUserDetails('seller_currency');
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	
	$price=($price>0)?$price:0;
	$downloadPrice=($downloadPrice>0)?$downloadPrice:0;
	$perViewPrice=($perViewPrice>0)?$perViewPrice:0;
	
	$priceDetails=getDisplayPrice($price,$seller_currency);
	$downloadPriceDetails=getDisplayPrice($downloadPrice,$seller_currency);
	$PpvPriceDetails=getDisplayPrice($perViewPrice,$seller_currency);
	
	$quantity=($quantity>0)?$quantity:0;
	
	
	if($fileType=='text' || $fileType==4){
		$showWordCount='';
		$showFileLength='dn';
		
	}else{
		$showWordCount='dn';
		$showFileLength='';
	}
$accordianHeading = $LID->topTitleBar;
$listHeading = $LID->bottomTitleBar;
	if($indusrty=='photographyNart'){
		$lengthHeading=$this->lang->line('dimensions');
		$validation="number";
		$defaultValue="";
		$px=$placeHolder='px';
		$titleLength='';
		$accordianHeading = $this->lang->line('imagesorpieces');
	    $listHeading = $this->lang->line('albumSales');
	    //$listHeading = $this->lang->line('album');
	}else{
		//$validation="time required";
		$validation="time";
		$defaultValue="00:00:00";
		$placeHolder='HH:MM:SS';
		$titleLength=$this->lang->line('lengthDurationValid');
	}
	if($accordianHeading=='Pieces') {
		$accordianHeading = $this->lang->line('uploadPieces');
	}
	
	if($indusrty=='filmNvideo' || $indusrty=='musicNaudio'){
		if(isset($LID->projSellType) && isset($LID->sellPriceType) && $LID->projSellType==1 && $LID->sellPriceType==1) {
			$listHeading = $this->lang->line('projectPricing');
		}else{
			$listHeading = $this->lang->line('projectSales');
		}
	}
	
	if($listHeading=='Project') {
		$listHeading = $this->lang->line('projectPricing');
	}
	
	if($fileType=='audio' || $fileType==3){
			$lengthHeading=$this->lang->line('uploadLength');
	}
	elseif($fileType=='text' || $fileType==4){
		$lengthHeading=$this->lang->line('wordCount');
	}
	elseif($fileType=='image' || $fileType==1){
		$lengthHeading=$this->lang->line('dimensions');
	}
	else{
		$lengthHeading=$this->lang->line('lenghtDuration');
	}
	
	//Set accordion header for auction
	if(isset($LID->projSellType) && $LID->projSellType==2) {
		$listHeading = $this->lang->line('auction');
	}
	
	$formAttributes = array(
		'name'=>'uploadmediaForm',
		'id'=>'uploadmediaForm',
		'toggleDivForm'=>'uploadElementForm'
	);
	$title = array(
		'name'	=> 'fileTitle',
		'id'	=> 'fileTitle',	
		'class'	=> 'width546px required',
		'value'	=> $fileTitle,
		'minlength'	=> 2
		/*'maxlength'	=> 50,   issue no 497*/
	);
	$fileLengthInput = array(
		'name'	=> 'fileLength',
		'id'	=> 'fileLength',	
		'class'	=> 'width180px '.$validation,
		'title'	=> $titleLength,
		'value'	=> $fileLength,
		'maxlength'	=> 10,
		'size'	=> 50,
		'placeholder'=>$placeHolder
	);
	
	
 /* For Photography N ART */ 
	
	$fileHeight = array(
		'name'	=> 'fileHeight',
		'id'	=> 'fileHeight',	
		'class'	=> 'width180px number ',
		'value'	=> $fileHeight,
		'maxlength'	=> 10,
		'size'	=> 50,
		
		
	);		
	
	$fileWidth = array(
		'name'	=> 'fileWidth',
		'id'	=> 'fileWidth',	
		'class'	=> 'width180px number ',
		'value'	=> $fileWidth,
		'maxlength'	=> 10,
		'size'	=> 50,
		
		
	);
	
/* End */	
	
	if($indusrty=='photographyNart'){
		$fileLengthInput['min'] = 1;
		$fileLengthInput['title'] = $this->lang->line('validDimension');
	}
	
	$priceInput = array(
		'name'	=> 'price',
		'value'	=> $price,
		'id'	=> 'price',
		'type'	=> 'text',
		'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionEProduct','#displayPriceEProduct')",
		'readonly'=>true
	);
	if($isPrice=='t'){
		$priceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$priceInput['min']='0.1';
		$IPC='checked';
		$removeProjectDiv = '';
	}else{
		$priceInput['class']='fl price_input_disable font_opensansSBold clr_666';
		$priceInput['readonly']='readonly';
		$IPC=''; 
		$removeProjectDiv = 'dn';
	}
	
	$downloadPriceInput = array(
		'name'	=> 'downloadPrice',
		'value'	=> $downloadPrice,
		'id'	=> 'downloadPrice',
		'type'	=> 'text',
		'onkeyup'=>"getDisplayPrice(this,'".$seller_currency."','#totalCommisionEDownLoad','#displayPriceEDownLoad')",
		'readonly'=>true
	);
	
	if($isDownloadPrice=='t'){
		$downloadPriceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$downloadPriceInput['min']='0.1';
		$IDPC='checked';
	}else{
		$downloadPriceInput['class']='fl price_input_disable font_opensansSBold clr_666';
		$downloadPriceInput['readonly']='readonly';
		$IDPC=''; 
	}
	$perViewPriceInput = array(
		'name'	=> 'perViewPrice',
		'value'	=> $perViewPrice,
		'id'	=> 'perViewPrice',
		'type'	=> 'text',
		'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionEPPV','#displayPriceEPPV')",
		'readonly'=>true
	);	
	if($isPerViewPrice=='t'){
		$perViewPriceInput['class']='fl price_input font_opensansSBold clr_666 NumGrtrZero required';
		$perViewPriceInput['min']='0.1';
		$IPVPC='checked';
	}else{
		$perViewPriceInput['class']='fl price_input_disable font_opensansSBold clr_666 number';
		$perViewPriceInput['readonly']='readonly';
		$IPVPC=''; 
	}
	

	
	$wordCountInput = array(
		'name'	=> 'wordCount',
		'id'	=> 'wordCount',	
		'class'	=> 'width180px numberGreaterZero',
		'value'	=> $wordCount>0?$wordCount:'',
		'maxlength'	=> 11
	);
	
	$projectidInput = array(
		'name'	=> 'projectid',
		'type'	=> 'hidden',
		'id'	=> 'projectid',
		'value'	=> $projectId
	);
	$elementIdAttr = array(
		'name'	=> 'elementId',
		'id'	=> 'elementId',
		'type'	=> 'hidden',
		'value'	=> $elementId
	);
	$mediaTypeIdAttr = array(
		'name'	=> 'mediaTypeId',
		'id'	=> 'mediaTypeId',
		'type'	=> 'hidden',
		'value'	=> $mediaTypeId
	);
	$fileIdAttr = array(
		'name'	=> 'fileId',
		'id'	=> 'fileId',
		'type'	=> 'hidden',
		'value'	=> $fileId
	);
	
	$rawFileNameInput = array(
		'name'	=> 'rawFileName',
		'id'	=> 'rawFileName',
		'type'	=> 'hidden',
		'value'	=> $rawFileName
	);
	
	$imgSrc = array(
		'name'	=> 'imgSrc',
		'id'	=> 'imgSrc',
		'type'	=> 'hidden',
		'value'	=> $imgSrc
	);
	
	$FTG = array(
		'name'	=> 'fileTypeFlag',
		'id'	=> 'fileTypeFlag',
		'type'	=> 'hidden',
		'value'	=> $fileTypeFlag?1:0
	);
	$createWaterMarkFlagInput = array(
		'name'	=> 'createWaterMarkFlag',
		'id'	=> 'createWaterMarkFlag',
		'type'	=> 'hidden',
		'value'	=> $createWaterMarkFlag
	);
	
	$isDefaultElement = array(
		'name'	=> 'isDefaultElement',
		'id'	=> 'isDefaultElement',
		'type'	=> 'hidden',
		'value'	=> $isDefaultElement
	);
	
	$projSellstatusInput = array(
		'name'	=> 'projSellstatus',
		'id'	=> 'projSellstatus',
		'type'	=> 'hidden',
		'value'	=> $projSellstatus
	);
	
	$industrySection = array(
		'name'	=> 'industrySection',
		'id'	=> 'industrySection',
		'type'	=> 'hidden',
		'value'	=> $industryType
	);
	
	$quantityInput = array(
		'name'	=> 'quantity',
		'value'	=> $quantity,
		'id'	=> 'quantity',
		'type'	=> 'text',
		'class'	=> 'fl price_input font_opensansSBold clr_666 NumGrtrZero required'
	);
	
	$projSellTypeInput = array(
		'name'	=> 'projSellType',
		'id'	=> 'projSellType',
		'type'	=> 'hidden',
		'value'	=> $LID->projSellType
	);
	
	$sellPriceTypeInput = array(
		'name'	=> 'sellPriceType',
		'id'	=> 'sellPriceType',
		'type'	=> 'hidden',
		'value'	=> $LID->sellPriceType
	);
	
	$topTitle=explode(' ',$LID->topTitleBar);
	$topTitle=$topTitle[0];
	$bottomTitle=explode(' ',$LID->bottomTitleBar);
	$bottomTitle=$bottomTitle[0];
	//$titleHeading=$topTitle.' '.$this->lang->line('title');
	$titleHeading=$this->lang->line('title');
	//$topPriceHeading=$topTitle.' '.$this->lang->line('price');
	$topPriceHeading=$this->lang->line('project_prices');
	//$bottomPriceHeading=$bottomTitle.' '.$this->lang->line('price');
	$bottomPriceHeading=$this->lang->line('project_prices');
	
	$ARS = array(
		'name'	=> 'availableRemainingSpace',
		'value'	=> $remainingBytes,
		'id'	=> 'availableRemainingSpace',
		'type'	=> 'hidden'
	);

	$userBrowser = get_user_browser();
	$showFormIE=$showForm;
	if($userBrowser == 'ie'){
	 $showFormIE='';
	}
?>
<div class="contactBoxWp dn" id="contactBoxWp">
	<div id="contactContainer" class="contactContainer"></div>
</div>
<div class="row form_wrapper">
    <div class="row">
      <div class="cell frm_heading">
        <h1>
			<?php //echo $label['uploadMedia'];
			if($projSellstatus=='t') {
				echo $label['uploadMediaPricingHead'];
				$topClass = 'mt12';
			} else {
				echo $label['uploadMediaHead'];
				$topClass = 'pt2';
			}
			?>
		</h1>
      </div>
      <?php echo $header; ?>
    </div>
    <div class="row tab_wp pt2">
			<?php 
					$toggleDivId='uploadPriceDetails';
					$tabClass='';
					if($projSellstatus=='t' && !$isProjectForsell){
							//$toggleDivId='';
							//$tabClass='opacity_4';
							$toggleDivId='uploadPriceDetails';
							$tabClass='';
					}
			if($projSellstatus=='t'){
			 ?>
			<!-----header of project price details----->  
			<div id="ProjectPriceDetails" class="row <?php echo $tabClass;?>">
				<div class="cell tab_left">
				  <div class="tab_heading "> <?php echo $listHeading; ?> </div>
				  <!--tab_heading-->
				</div>
				<div class="cell tab_right "> 
				<span class="according_heading"><?php echo string_decode($LID->projName); ?></span>
				  <div class="tab_btn_wrapper">
					<div class="tds-button-top"> <a> <span><div id="projectToggelDiv" toggleDivId="<?php echo $toggleDivId;?>" class="projectToggleIcon toggle_icon"></div></span> </a> </div>
				  </div>
				  <div class=" according_heading mr20 fr"><?php echo $this->lang->line('used').' '.$dirSize.' '.$this->lang->line('mb');?>  &nbsp;
					 <?php echo $this->lang->line('free').' '.$remainingSize.' '.$this->lang->line('mb');?>
					</div>
				</div>
			  </div>
			 <?php } ?>
		
		<div class="clear"></div>
		
		<div id="FileContainer" class="form_wrapper toggle frm_strip_bg">
			
			<!-----div of upload Price Details----->  
			
			<div id="uploadPriceDetails" class="form_wrapper toggle">
				<?php 
				if($projSellstatus=='t'){?>
				<div class="row">
					<div class="tab_shadow"> </div>
				</div>
				<div class="clear"></div>

				<?php
				if(isset($LID->projSellType) && $LID->projSellType==2) {
					//set element id as project id
					if(empty($LID->elementId)) {
						$LID->elementId = $LID->projectid;
					}
					//load auction form
					echo Modules::run("auction/auctionForm",array('entityId'=>$entityId,'projectId'=>$LID->projectid,'elementId'=>$LID->elementId)); 
				} else {
					//load sales project form 
					$this->load->view('projectPrice',array('data'=>$LID,'bottomPriceHeading'=>$bottomPriceHeading));
				} ?>	
					<div id="shippingList" class="dn">
						<div class="seprator_25 clear row"></div>
						<?php echo Modules::run("shipping/shippingList",$LID->projectid,$entityId); ?>
					</div>
					<div class="seprator_25 clear row"></div>
					<?php echo Modules::run("counsumptiontax/counsumptiontaxForm",$entityId,$LID->projectid,$LID->projectid); ?>
					<div class="row">
					  <div class="label_wrapper cell bg-non"> </div>
					  <!--label_wrapper-->
					  <div class=" cell frm_element_wrapper">
						<div class="Req_fld cell mr20"><?php echo $this->lang->line('requiredFields');?> </div> <div class="Req_fld_all cell"><?php echo $this->lang->line('applyToAllProduct');?></div>
						<div class="row">
							<div class="cell">*&nbsp;</div>
							<div class="cell" >
								<?php echo $this->lang->line('allReqFieldMsg');?>
							</div>
						</div>
						<div class="row height25">
							<div class="cell">*&nbsp;</div>
							<div class="cell width535px" >
								<?php //echo $this->lang->line('shippingMediaMsg');
								if($industryType=='photographyNart'){
									echo $this->lang->line('shippingProductAlbumMsg');
								} else {
									echo $this->lang->line('shippingProductMediaMsg');
								}
								?>
							</div>
						</div>
					  </div>
					</div> <!--from_element_wrapper-->
					 <div class="seprator_25 clear"></div>
					<?
				}
				/*else{ 
					
					if(isset($LID->isExternalImageURL) && $LID->isExternalImageURL=='t'){
						$projectImage=trim($LID->projBaseImgPath);
					}else{
						
						//----------make element default project image code start---------//
						if(!empty($LID->projBaseImgPath)){
							$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
							$projectImage = getImage($projThumbImage,$imagetype,1);
						}else{
							
							$getPojrectImage = getProjectElementImage($LID->projectid,$elemetEntityId);	
							if(is_array($getPojrectImage)){
								if($getPojrectImage['isExternal']=="t"){
									$projectImage =  checkExternalImage($getPojrectImage['filePath'],'_s');
								}
							}else{
								if($getPojrectImage){
									$projThumbImage = $getPojrectImage;
								}else{
									$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
								}
								$projectImage = getImage($projThumbImage,$imagetype,1);
							}
						}
						//----------make element default project image code start---------//
					}
					
					$src = $projectImage;
				?>
					<div class="row">
					  <div class="label_wrapper cell">
						<label><?php echo $this->lang->line('note');?></label>
					  </div>
					  <!--label_wrapper-->
					  <div class=" cell frm_element_wrapper">
						<div class="cell width410px free_media_screen"><?php echo $this->lang->line('freeMediaInformation');?></div>
						<div class="picture_size_box">
						  <div class="browse_thumb_wrapper cell margin_0 ">
							<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
							  <tbody>
								<tr>
								  <td><img class="" src="<?php echo $src;?>" /></td>
								</tr>
							  </tbody>
							</table>
						  </div>
						  
						</div><!--right div-->
					  </div>
					</div>
					<?php
				}*/
				?>
		 </div>
	
			  
			  <!-----header of upload element----->  
			  <div class="row ">
					<div class="cell tab_left">
					  <div class="tab_heading"> <?php echo $accordianHeading; ?> </div>
					  <!--tab_heading-->
					</div>
					<div class="cell tab_right"> <span class="according_heading"><?php echo string_decode($LID->projName); ?></span>
					
					  <div class="tab_btn_wrapper">
						<div class="tds-button-top"><a><span><div class="projectToggleIcon toggle_icon" toggleDivId="uploadElement"></div></span></a></div>
						
					  </div>
					  <?php if($projSellstatus!='t') { ?>
						<div class="according_heading mr20 fr"><?php echo $this->lang->line('used').' '.$dirSize.' '.$this->lang->line('mb');?>  &nbsp;
							<?php echo $this->lang->line('free').' '.$remainingSize.' '.$this->lang->line('mb');?>
						</div>
						<?php }?>
					</div>
				</div><!--row-->
				  
			   <!--row-->
			  <div class="clear"></div>
			  
			  <!-----div of upload element-----> 
			   
			  <div id="uploadElement">
				<div class="row">
				  <div class="tab_shadow"> </div>
				</div>
				
				<div  class="fr">
					<div class="fileInfo" id="fileInfo">
						<div id="progressBar" class="plupload_progress">
							<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
							<div class="plupload_progress_container fl"><div id="plupload_progress_bar" class="plupload_progress_bar"></div>
						</div>
					</div>
					<span id="percentComplete" class="percentComplete fl"></span></div>
					<div id="dropArea"></div>
				</div>
				
				<div id="uploadElementForm" class="<?php echo $showFormIE;?>">
						<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
						<div class="upload_media_left_box">
							<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
							
								  <div class="row">
									<div class="label_wrapper cell">
									  <label class="select_field"><?php echo $titleHeading;?></label>
									</div>
									<!--label_wrapper-->
									<div class=" cell frm_element_wrapper">
									  <?php echo form_input($title); ?>
										<div class="row wordcounter"><?php echo form_error($title['name']); ?></div>
									</div>
								  </div>
								  
								<!--<div class="row <?php //echo $RFCD;?>" id="rawFileNameContainerDiv">
									<div class="label_wrapper cell">
									  <label class="select_field"><?php //echo $this->lang->line('file');?></label>
									</div>
									<!--label_wrapper-->
									<!--<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv">
										<?php //echo $rawFileName;?>
									</div>
								 </div>-->
								  
								  <?php 								  
									
									/*$data=array(
												'typeOfFile'=>$fileType,
												'fileType'=>$fileConfig['fileType'],
												'fileMaxSize'=>$remainingBytes,
												'isEmbed'=>$isExternal,
												'fileName'=>$fileName,
												'fileSize'=>$fileSize,
												'filePath'=>$filePath,
												'embedCode'=>$embedCode,
												'required'=>'required',
												'label'=>$this->lang->line('file'),
												'editFlag'=>$editFlag,
												'fileTypeFlag'=>$fileTypeFlag,
												'mediaAddPopup'=>1,
												'projSellType'=>$LID->projSellType,
												'sellPriceType'=>$LID->sellPriceType,
												'view'=>'uploadMediaFileForm'
												);
									if($indusrty=='writingNpublishing'){
										$data['flag']=1;
									}*/
									
									//$this->load->view("common/uploadMediaFileForm",$data);
									//echo Modules::run("common/formInputField",$data);							
								
								/*if($indusrty=='writingNpublishing' || $indusrty=='educationMaterial'){
									?>
									<div id="wordCountDiv" class="row width_791 <?php echo $showWordCount?>">
										<div class="label_wrapper cell">
										  <label id="changeItAccFile"><?php echo $this->lang->line('wordCount');?></label>
										</div>
										<div class=" cell frm_element_wrapper pt3 ">
										  <?php 
										  echo form_input($wordCountInput);?>
										</div>
									</div>
									<?php
								}
								elseif($indusrty=='photographyNart'){?>
										<div class="row">
											<div class="label_wrapper cell">
											  <label><?php echo $lengthHeading;?></label>
											</div>
											<!--label_wrapper-->
											<div class=" cell frm_element_wrapper">
												<div class="cell width180px mr5">
													<?php echo form_input($fileHeight);  ?>												
												</div>	                                             
											    <div class="cell ml20 mr5 mt5"> X </div>											 
												<div class="cell width180px  ml10 mr5">
														 <?php echo form_input($fileWidth); ?>												 
												</div>
												<div class="cell ml15">
													<div class="small_select_wp_a">														
														<select id="fileUnit" name="fileUnit" class="width_122" onchange="checkUnit()" title="<?php echo $this->lang->line('requiredmSg');?>">
															<option value=""><?php echo $this->lang->line('selectUnits');?></option>
															<option value="px" <?php if($fileUnit=='px') echo 'selected';?>><?php echo $this->lang->line('pixels');?></option>                                                            															
															<option value="mm" <?php if($fileUnit=='mm') echo 'selected';?>><?php echo $this->lang->line('millimeters');?></option>
															<option value="inch" <?php if($fileUnit=='inch') echo 'selected';?>><?php echo $this->lang->line('inch');?></option>
														</select>
														<div id="fileUnitError" class="dn error"><?php echo $this->lang->line('requiredmSg');?></div>
													</div>
												</div>
											<div class="clear"></div>
											<div class="seprator_13"></div>
											</div>
										</div>
									<?php }
									
									if($indusrty=='filmNvideo' || $indusrty=='musicNaudio' || $indusrty=='educationMaterial') {
									$fileLengthExplode=explode(':',$fileLength);
									$hh=(isset($fileLengthExplode[0]) && is_numeric($fileLengthExplode[0]))?$fileLengthExplode[0]:'00';
									$mm=(isset($fileLengthExplode[1]) && is_numeric($fileLengthExplode[1]))?$fileLengthExplode[1]:'00';
									$ss=(isset($fileLengthExplode[2]) && is_numeric($fileLengthExplode[2]))?$fileLengthExplode[2]:'00';
									$hhList=numbersList($startFrom=0, $Upto=23, $interval=1);
									$mmList=$ssList=numbersList($startFrom=0, $Upto=59, $interval=1);
									?>
									<div id="fileLengthDiv" class="row <?php echo $showFileLength?>">
										<div class="label_wrapper cell">
										  <label id="fileLengthLabel"><?php echo $lengthHeading;?></label>
										</div>
										<!--label_wrapper-->
										<div class=" cell frm_element_wrapper">
											<div class="row">
												<div class="cell">
													<div class="row pr">
														<?php echo form_dropdown('hh', $hhList, $hh,'id="hh" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">HH</div>
												</div>
												<div class="cell pr">
													<div class="row pr">
														<?php echo form_dropdown('mm', $mmList, $mm,'id="mm" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">MM</div>
												</div>
												<div class="cell pr">
													<div class="row pr">
														<?php echo form_dropdown('ss', $ssList, $ss,'id="ss" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">SS</div>
													
												</div>
											</div>
											<?php // echo form_input($fileLengthInput); ?>
											<div class="row wordcounter"><?php echo form_error($fileLengthInput['name']); ?></div>
											<div class="seprator_5"></div>
										</div>
									</div>
									<?php
								}*/
								
								if(($projSellstatus=='t') && ($LID->showPrice == 't' ) && ($LID->sellPriceType==2 || $indusrty=='educationMaterial') && $LID->projSellType!=2){
								?>
									<div id="showInUploadCase" class="row <?php echo $showPrice;?> pt15"> 
										<div class="label_wrapper cell mt21">
											<label class="select_field"><?php echo $topPriceHeading;?></label>
										</div>
										<!--label_wrapper-->
										<div class=" cell frm_element_wrapper">
											<div class="row ">
												<div class="fl width_330 height_21"> </div>
												<div class="font_opensansSBold ml26 fl widht_63 orange_clr_imp mt-4 lineH16"> <?php echo $this->lang->line('tsCommision');?> </div>
												<div class="font_opensansSBold ml26 fl pt5  clr_white text_alignR consumebg_top height_15"> <?php echo $this->lang->line('displayPrice');?> </div>
												<div class="clear"></div>
											</div>
											<div class="consumebg">
												<div class="row">
													<div class="fl">
														<div class="price_trans_wp">
															<div class="price_trans_checkbox_wp Fleft">
																<div class="defaultP mt2 ml20 ">
																	
																	<input type="checkbox" <?php echo $IDPC;?> name="isDownloadPrice" id="isDownloadPrice" ceckboxId="downloadPrice" value="t" price="<?php echo $downloadPrice;?>" class="readonly"/>
																</div>
															</div>
															<div class="price_trans_heading text_alignL pl0 font_opensansSBold Fleft width_100"> <?php echo $this->lang->line('download');?> </div>
															<div class="font_opensansSBold ml80 fl width100px"> 
																<?php echo form_input($downloadPriceInput); ?>
															</div>
															<div class="font_opensansSBold ml26 fl widht_63 pt2 text_alignC" id="totalCommisionEDownLoad">
																<?php echo $downloadPriceDetails['currencySign'].' '.$downloadPriceDetails['totalCommision']?>
															</div>
															<div class="font_opensansSBold ml26 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceEDownLoad">
																<?php echo $downloadPriceDetails['currencySign'].' '.$downloadPriceDetails['displayPrice']?>
															</div>
														</div>
													</div>
												</div>
												<?php if($indusrty == 'filmNvideo' ) $displayPPV=''; else $displayPPV='dn';?>
												<div class="row <?php echo $displayPPV;?>">
													<div class="fl">
														<div class="price_trans_wp">
															<div class="price_trans_checkbox_wp Fleft">
																<div class="defaultP mt2 ml20 ">
																	<input type="checkbox" <?php echo $IPVPC;?> name="isPerViewPrice" id="isPerViewPrice" ceckboxId="perViewPrice" value="t" price="<?php echo $perViewPrice;?>" class="readonly" />
																</div>
															</div>
															<div class="price_trans_heading text_alignL pl0 font_opensansSBold Fleft width_100"> <?php echo $this->lang->line('ppv');?> </div>
															<div class="font_opensansSBold ml80 fl width100px"> 
																<?php echo form_input($perViewPriceInput);?>
															</div>
															<div class="font_opensansSBold ml26 fl widht_63 pt2 text_alignC" id="totalCommisionEPPV">
																<?php echo $PpvPriceDetails['currencySign'].' '.$PpvPriceDetails['totalCommision']?>
															</div>
															<div class="font_opensansSBold ml26 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceEPPV">
																<?php echo $PpvPriceDetails['currencySign'].' '.$PpvPriceDetails['displayPrice']?>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="fl">
														<div class="price_trans_wp">
															<div class="price_trans_checkbox_wp Fleft">
																<div class="defaultP mt2 ml20 ">
																	<input type="checkbox" <?php echo $IPC;?> name="isPrice" id="isPrice" ceckboxId="price" value="t" price="<?php echo $price;?>" class="readonly" />
																</div>
															</div>
															<div class="price_trans_heading text_alignL pl0 font_opensansSBold Fleft width_100"> <?php echo $this->lang->line('product');?> </div>
															<div class="font_opensansSBold ml80 fl width100px"> 
																 <?php echo form_input($priceInput);?>
															</div>
															<div class="font_opensansSBold ml26 fl widht_63 pt2 text_alignC" id="totalCommisionEProduct">
																<?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?>
															</div>
															<div class="font_opensansSBold ml26 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPriceEProduct">
																<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?>
															</div>
														</div>
													</div>
												</div>												
												<div class="clear"> </div>
											</div>
											
											<div class="row">
												<div class="fl width_330 height_21"> </div>
												<div class="font_opensansSBold ml26 fl widht_63 height4 pt2"> </div>
												<div class="font_opensansSBold ml26 fl pt2 consumebg widht_72 clr_white text_alignR pr19 pl16 consumebg_bottom"> </div>
												<div class="clear"></div>
											</div>
											<div id="pricesError" class="row width_330 mt-14 dark_Grey dn">
												<?php echo $this->lang->line('chooseAtleastPrice');?>
											</div>
											<?php ?>
											<div class="row <?php echo $removeProjectDiv;?>" id="removeProductPiece">
												<div class="fl">
													<div class="price_trans_heading text_alignL pl20 font_opensansSBold Fleft"> <?php echo $this->lang->line('removeProductAfter');?> </div>
													<div class="font_opensansSBold ml50 fl"> 
															 <?php echo form_input($quantityInput); ?>
													</div>
													<div class="font_opensansSBold ml5 fl widht_63 pt2"><?php echo $this->lang->line('sale(s)');?></div>
												</div>
												<div>
													<div class="price_trans_heading text_alignL pl20 font_opensansSBold Fleft"> <?php echo $this->lang->line('applyShippingCharge');?> </div>
												</div>
												
											</div>
										</div>
									</div>
									<?php } ?> 
									
								<!-- Display file fields-->
								
								 <div class="row <?php echo $RFCD;?>" id="rawFileNameContainerDiv">
									<div class="label_wrapper cell">
									  <label class="select_field"><?php echo $this->lang->line('file');?></label>
									</div>
									<!--label_wrapper-->
									<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv">
										<?php echo $rawFileName;?>
									</div>
								 </div>
								 
								<div id="downloadPriceSection">
								<?php 
								$data=array(
										'typeOfFile'=>$fileType,
										'fileType'=>$fileConfig['fileType'],
										'fileMaxSize'=>$remainingBytes,
										'isEmbed'=>$isExternal,
										'fileName'=>$fileName,
										'fileSize'=>$fileSize,
										'filePath'=>$filePath,
										'embedCode'=>$embedCode,
										'required'=>'required',
										'label'=>$this->lang->line('file'),
										'editFlag'=>$editFlag,
										'fileTypeFlag'=>$fileTypeFlag,
										'mediaAddPopup'=>1,
										'projSellType'=>$LID->projSellType,
										'sellPriceType'=>$LID->sellPriceType,
										'view'=>'uploadMediaFileForm'
										);
								if($indusrty=='writingNpublishing'){
									$data['flag']=1;
								}
								$this->load->view("common/uploadMediaFileForm",$data);?>
								</div>
								<?php
								if($indusrty=='writingNpublishing' || $indusrty=='educationMaterial'){
									?>
									<div id="wordCountDiv" class="row width_791 <?php echo $showWordCount?>">
										<div class="label_wrapper cell">
										  <label id="changeItAccFile"><?php echo $this->lang->line('wordCount');?></label>
										</div>
										<div class=" cell frm_element_wrapper pt3 ">
										  <?php 
										  echo form_input($wordCountInput);?>
										</div>
									</div>
									<?php
								}
								elseif($indusrty=='photographyNart'){?>
										<div class="row" id="fileDimentionDiv">
											<div class="label_wrapper cell">
											  <label><?php echo $lengthHeading;?></label>
											</div>
											<!--label_wrapper-->
											<div class=" cell frm_element_wrapper">
												<div class="cell width180px mr5">
													<?php echo form_input($fileHeight);  ?>												
												</div>	                                             
											    <div class="cell ml20 mr5 mt5"> X </div>											 
												<div class="cell width180px  ml10 mr5">
														 <?php echo form_input($fileWidth); ?>												 
												</div>
												<div class="cell ml15">
													<div class="small_select_wp_a">														
														<select id="fileUnit" name="fileUnit" class="width_122" onchange="checkUnit()" title="<?php echo $this->lang->line('requiredmSg');?>">
															<option value=""><?php echo $this->lang->line('selectUnits');?></option>
															<option value="px" <?php if($fileUnit=='px') echo 'selected';?>><?php echo $this->lang->line('pixels');?></option>                                                            															
															<option value="mm" <?php if($fileUnit=='mm') echo 'selected';?>><?php echo $this->lang->line('millimeters');?></option>
															<option value="inch" <?php if($fileUnit=='inch') echo 'selected';?>><?php echo $this->lang->line('inch');?></option>
														</select>
														<div id="fileUnitError" class="dn error"><?php echo $this->lang->line('requiredmSg');?></div>
													</div>
												</div>
											<div class="clear"></div>
											<div class="seprator_13"></div>
											</div>
										</div>
									<?php }?>
								
								<div id="fileDurationDiv">
								<?php
								if($indusrty=='filmNvideo' || $indusrty=='musicNaudio' || $indusrty=='educationMaterial') {
									$fileLengthExplode=explode(':',$fileLength);
									$hh=(isset($fileLengthExplode[0]) && is_numeric($fileLengthExplode[0]))?$fileLengthExplode[0]:'00';
									$mm=(isset($fileLengthExplode[1]) && is_numeric($fileLengthExplode[1]))?$fileLengthExplode[1]:'00';
									$ss=(isset($fileLengthExplode[2]) && is_numeric($fileLengthExplode[2]))?$fileLengthExplode[2]:'00';
									$hhList=numbersList($startFrom=0, $Upto=23, $interval=1);
									$mmList=$ssList=numbersList($startFrom=0, $Upto=59, $interval=1);
									?>
									<div id="fileLengthDiv" class="row <?php echo $showFileLength?>">
										<div class="label_wrapper cell">
										  <label id="fileLengthLabel"><?php echo $lengthHeading;?></label>
										</div>
										<!--label_wrapper-->
										<div class=" cell frm_element_wrapper">
											<div class="row">
												<div class="cell">
													<div class="row pr">
														<?php echo form_dropdown('hh', $hhList, $hh,'id="hh" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">HH</div>
												</div>
												<div class="cell pr">
													<div class="row pr">
														<?php echo form_dropdown('mm', $mmList, $mm,'id="mm" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">MM</div>
												</div>
												<div class="cell pr">
													<div class="row pr">
														<?php echo form_dropdown('ss', $ssList, $ss,'id="ss" class="width80px l0px"');?>
													</div>
													<div class="greyMsg pt5 pl15">SS</div>
													
												</div>
											</div>
											<?php // echo form_input($fileLengthInput); ?>
											<div class="row wordcounter"><?php echo form_error($fileLengthInput['name']); ?></div>
											<div class="seprator_5"></div>
										</div>
									</div>
									<?php
								}							
								?>
								</div>								
								<!--from_element_wrapper-->
								
								 <div class="row">
									<div class="label_wrapper cell bg-non">
										&nbsp;
									</div>
									<!--label_wrapper-->
									<div class="cell frm_element_wrapper">
										<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?> </div>
										<div class="price_btn_position pr">
											<?php
												echo form_input($projectidInput);
												echo form_input($elementIdAttr);
												echo form_input($mediaTypeIdAttr);
												echo form_input($fileIdAttr);
												echo form_input($imgSrc);
												echo form_input($isDefaultElement);
												echo form_input($FTG);
												echo form_input($projSellstatusInput);
												echo form_input($projSellTypeInput);
												echo form_input($sellPriceTypeInput);
												echo form_input($industrySection);
												echo form_input($ARS);
												echo form_input($rawFileNameInput);
												echo form_input($createWaterMarkFlagInput);
											?>								
											<?php
												$button=array('ajaxSave', 'ajaxCancel','buttonId'=>'');
												echo Modules::run("common/loadButtons",$button); 
											 ?>
										</div>
										<div class="row makeShowcaseBetter">
											*&nbsp;<?php echo $this->lang->line('allReqFieldMsg');?><br>
											
											*&nbsp;<?php echo $this->lang->line('makeShowcaseBetterMsgChange');?>
											 <a href="<?php echo site_url(lang()).'/media/'.$indusrty.'/editProject/furtherDescription/'.$projectId;?>">Further Description</a> or <a href="<?php echo site_url().'media/'.$indusrty.'/editProject/additionalInformation/'.$projectId;?>">PR Material</a>.<br>
											
											*&nbsp;<?php echo $this->lang->line('previewPublishInfoChange');?> <a href="<?php echo site_url(lang()).'/media/'.$indusrty.'/'.$projectId;?>">Index page</a>.
										</div>
									</div>
								</div>
							
							<?php echo form_close(); ?>
						</div>
						<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
						<!--upload_media_left_box-->
						<div class="seprator_25 clear"></div> 
				</div>	
				<div class="row height24">
					<div class="cell bg_none">
						&nbsp;
					</div>
					<div class="fr mr20 font_opensans">	
					<div class="fr orange f12 ">Publish from your <a href="<?php echo base_url('media/'.$indusrty.'/'.$projectId);?>" class="orgGreyonHover underline"><?php echo $this->lang->line($indusrty);?> Index page</a>.</div>
					</div>
				</div>
			   <?php 
					$k=0;
					if($EelementType){
						$embedCode='';
						$default=true;
						$elementFileSize=0;
						$elementLength='0:00';
						$mainFile=0;
						
						foreach($EelementType as $key=>$type){
							$typeName='';
							if($type->default=='f'){
								$mainFile++;
								if($default){
									if($elements)$elementLength=$elements[$k]->fileLength;
									$default=false;
									if($indusrty!='photographyNart'){
										?>
										<div class="seprator_40 clear"></div>
										<?
									}
								}
							}
							$k=array_search($type->elementTypeId, $mediaTypeIds);
							
							if(is_numeric($k)){
								$isExternal=$elements[$k]->isExternal;
								
								if($indusrty=='photographyNart'){
									//$src=($isExternal=='t'?($elements[$k]->filePath):(getImage($elements[$k]->filePath.$elements[$k]->fileName,$imagetype)));
									
									if($isExternal=='t'){
										$src=checkExternalImage($elements[$k]->filePath,'_xxs');
									}else{
										$smallElementsImg = addThumbFolder($elements[$k]->filePath.$elements[$k]->fileName,'_xxs');
										$src = getImage($smallElementsImg,$imagetype);
									}									
								
								}else{
									
									
									if($indusrty=='filmNvideo'){
										if(empty($elements[$k]->imagePath)){	
										$smallElementsImg = getVideoThumbFolder(@$elements[$k]->filePath.$elements[$k]->fileName,'_xxs');		
										$src = getImage($smallElementsImg,$imagetype);
										}else{
											$smallElementsImg = addThumbFolder($elements[$k]->imagePath,'_xxs');
											$src = getImage($smallElementsImg,$imagetype);
										}
									}else{	
										$smallElementsImg = addThumbFolder($elements[$k]->imagePath,'_xxs');
										$src = getImage($smallElementsImg,$imagetype);
									}
									
									//$src=getImage($elements[$k]->imagePath,$imagetype);
									/*$smallElementsImg = addThumbFolder($elements[$k]->imagePath,'_xxs');
									$src = getImage($smallElementsImg,$imagetype);*/
								}
								
								
								$embedCode=$isExternal=='t'?$elements[$k]->filePath:'';
								if($isExternal=='t'){
									$file=getUrl($embedCode);
									$fileType='external';
									$fileDirPath='';
								}else{
									$fileType=trim(strtolower($elements[$k]->fileType));
									if($projSellstatus=='t' && $type->default=='f'){
										$isProjectForsell=true;
										$totalElementForShall++;
									}
									$fileDirPath=$file=$elements[$k]->filePath.$elements[$k]->fileName;
									if(!is_file($fileDirPath)){
										$fileDirPath='';
										$file='';
									}
								}
								$elementFileSize=($elementFileSize+$elements[$k]->fileSize);								
								
								if($elements[$k]->fileType == 'audio visual' || $elements[$k]->fileType == 'video' || $elements[$k]->fileType == 2){
									 $mediaUnitLabel = $this->lang->line('uploadDuration');
									 $mediaUnitTitle = $this->lang->line('lengthDurationValid');
									 $mediaUnitAddClass = 'time';
									 $mediaUnitRemoveClass = 'number';
									 
								 }
								else if($elements[$k]->fileType == 'audio' || $elements[$k]->fileType == 3){
									 $mediaUnitLabel = $this->lang->line('uploadLength');
									 $mediaUnitTitle = $this->lang->line('lengthFileValid');
									 $mediaUnitAddClass = 'time';
									 $mediaUnitRemoveClass = 'number';
								}
								else{
									 $mediaUnitLabel = $this->lang->line('wordCount'); 
									 $mediaUnitTitle = $this->lang->line('plzEnterNum');
									 $mediaUnitAddClass = 'number';
									 $mediaUnitRemoveClass = 'time';
								}
								
								$fileLength=$elements[$k]->fileLength;
								$fileLengthExplode=explode(':',$fileLength);
								$hh=(isset($fileLengthExplode[0]) && is_numeric($fileLengthExplode[0]))?$fileLengthExplode[0]:'00';
								$mm=(isset($fileLengthExplode[1]) && is_numeric($fileLengthExplode[1]))?$fileLengthExplode[1]:'00';
								$ss=(isset($fileLengthExplode[2]) && is_numeric($fileLengthExplode[2]))?$fileLengthExplode[2]:'00';
								
								$jsonData=array(
									'seller_currency'=>$seller_currency,
									'imgSrc'=>$src,
									'fileTitle'=>string_decode($elements[$k]->title),
									'isExternal'=>$isExternal,
									'rawFileName'=>$elements[$k]->rawFileName,
									'fileName'=>$elements[$k]->fileName,
									'fileType'=>$elements[$k]->fileType,
									'fileSize'=>$elements[$k]->fileSize,
									'fileInput'=>$elements[$k]->fileName,
									'embbededURL'=>$embedCode,
									'fileLength'=>$elements[$k]->fileLength,
									'hh'=>$hh,
									'mm'=>$mm,
									'ss'=>$ss,
									'downloadPrice'=>$elements[$k]->downloadPrice,
									'perViewPrice'=>$elements[$k]->perViewPrice,
									'price'=>$elements[$k]->price,
									'quantity'=>$elements[$k]->quantity,
									'isDownloadPrice'=>$elements[$k]->isDownloadPrice,
									'isPerViewPrice'=>$elements[$k]->isPerViewPrice,
									'isPrice'=>$elements[$k]->isPrice,
									'elementId'=>$elements[$k]->elementId,
									'mediaTypeId'=>$type->elementTypeId,
									'fileId'=>$elements[$k]->fileId,
									'isDefaultElement'=>$type->default,
									'fileHeight' => ($elements[$k]->fileHeight>0)?$elements[$k]->fileHeight:'',
									'fileWidth' => ($elements[$k]->fileWidth>0)?$elements[$k]->fileWidth:'',
									'fileUnit' 	=> $elements[$k]->fileUnit								
								);
								if($indusrty=='writingNpublishing' || $indusrty=='educationMaterial'){
									$jsonData['wordCount']=$elements[$k]->wordCount;
								}
								$jsonData=json_encode($jsonData); 
								
								$convsrsionFlag=false;
								$convsrsionFileType=$this->config->item('convsrsionFileType');
								if($elements[$k]->isExternal=='f' && in_array($elements[$k]->fileType,$convsrsionFileType)){
									$convsrsionFlag=true;
									if($elements[$k]->jobStsatus == 'DONE'){
										$conversionStatusClass='icon_filesent';
										$conversionStatusToolTip=$this->lang->line('Converted');
									}elseif($elements[$k]->jobStsatus == 'FAILS'){
										$conversionStatusClass='icon_filetransfer';
										$conversionStatusToolTip=$this->lang->line('conversionFailed');
									}else{
										$conversionStatusClass='icon_inprocess';
										$conversionStatusToolTip=$this->lang->line('converting');
									}
								}
								
								if((isset($elements[$k]->default) && $elements[$k]->default == 't') ||  ($elements[$k]->isExternal == 't')){
									$isPurchasedItem=false;
								}else{
									$sellExpiryDate=$isPurchasedItem=checkDownloadPPVaccess($elementEntityId,$elements[$k]->elementId,$elements[$k]->projId);
								}
								?>
								<div class="row" id="row<?php echo $elements[$k]->elementId;?>">
									<script>
										 var data<?php echo $type->elementTypeId;?> = <?php echo $jsonData;?>;
									</script>

								  <div class="label_wrapper cell">
									<?php 
									if ($indusrty=='photographyNart' ){
										$imageNo=$key+1;
										?>
										<label class=""><?php echo $this->lang->line('imageorpiece').' '.$imageNo;?></label>
										<?php 
									}else{ ?>
										<label class=""><?php echo $elements[$k]->type;?></label>
										<?php 
									} ?>
								  </div>
								  <!--label_wrapper-->
								  <div id="rowData<?php echo $type->elementTypeId;?>" class=" cell frm_element_wrapper extract_content_bg">
									<div class="extract_img_wp"> 
										<?php 
										if(trim(strtolower($elements[$k]->fileType))=='video' || trim(strtolower($elements[$k]->fileType))=='audio visual' || $elements[$k]->fileType==2){ ?>
											<!----------This condition show video------------>
											<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" onclick="openPlayerLightBox('popupBoxWp','popup_box','/common/playCommonVideo','<?php echo $elements[$k]->fileId;?>','<?php echo $elements[$k]->entityId;?>','<?php echo $elements[$k]->projId;?>','<?php echo $elements[$k]->elementId;?>');" />
										<?php
										}else{
										if(trim(strtolower($elements[$k]->fileType))=='audio' || $elements[$k]->fileType==3){ 	?>
											<!----------This condition show audio------------>
											<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" onclick="openPlayerLightBox('popupBoxWp','popup_box','/common/playCommonAudio','<?php echo $elements[$k]->fileId;?>','<?php echo $elements[$k]->entityId;?>','<?php echo $elements[$k]->projId;?>','<?php echo $elements[$k]->elementId;?>');" />
									
										
											<?php
										}else{  if(trim(strtolower($elements[$k]->fileType))=='text' || $elements[$k]->fileType==4){?>
											<!----------This condition show text------------>
												<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" onclick="openPlayerLightBox('popupBoxWp','popup_box','/common/playCommonSwf','<?php echo $elements[$k]->fileId;?>','<?php echo $elements[$k]->entityId;?>','<?php echo $elements[$k]->projId;?>','<?php echo $elements[$k]->elementId;?>');" />
												<!---<img class="formTip ptr maxWH30 ma" src="<?php //echo $src;?>" title="<?php //echo $elements[$k]->title; ?>"  />--->
										 
										<?php } else{ if(trim(strtolower($elements[$k]->fileType))=='image' || $elements[$k]->fileType==1){?>
											<!----------This condition show images------------>
											
											<?php if($elements[$k]->isExternal=='f'){ ?>
												<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" onclick="openPlayerLightBox('popupBoxWp','popup_box','/common/openCommonImage','<?php echo $elements[$k]->fileId;?>','<?php echo $elements[$k]->entityId;?>','<?php echo $elements[$k]->projId;?>','<?php echo $elements[$k]->elementId;?>');" />
											<?php }else{ 
												//$imagesThumbImage='';
												//$src = getImage($imagesThumbImage,$this->config->item('photographyNartImage_xxs'));
												?>
													<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" onclick="openPlayerLightBox('popupBoxWp','popup_box','/common/openCommonImage','<?php echo $elements[$k]->fileId;?>','<?php echo $elements[$k]->entityId;?>','<?php echo $elements[$k]->projId;?>','<?php echo $elements[$k]->elementId;?>');" />
											<?php } ?>
											
											
											<?php } else{?>  
											
												<img class="formTip ptr maxWH30 ma"  src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" />
											
											<?php } } }	
										}
										?>
									</div>
									<!--extract_img_wp-->
									<div class="extract_heading_box width200px"> <?php echo getSubString($elements[$k]->title,30) ; ?> </div>
									<!--extract_heading_box-->
									<?php 
									if($elements[$k]->fileType=='audio' || $elements[$k]->fileType==3){
										$lenghtString=($elements[$k]->fileLength=='0:0:0' || $elements[$k]->fileLength=='00:00:00')?'':$elements[$k]->fileLength;
									}
									elseif($elements[$k]->fileType=='text' || $elements[$k]->fileType==4){
										$lenghtString=($elements[$k]->wordCount > 0)?$elements[$k]->wordCount.' '.$this->lang->line('words'):'';
									}
									elseif($elements[$k]->fileType=='image' || $elements[$k]->fileType==1){
										$lenghtString=($elements[$k]->fileHeight > 0 && $elements[$k]->fileWidth > 0)? $elements[$k]->fileHeight.' x '.$elements[$k]->fileWidth.' '.substr(@$elements[$k]->fileUnit,0,2):''; 
									}
									else{
										$lenghtString=($elements[$k]->fileLength=='0:0:0' || $elements[$k]->fileLength=='00:00:00')?'':$elements[$k]->fileLength;
									}
									
									if($industryType=='filmNvideo'){	
										$durationWidth = 'width65px';
									} else {
										$durationWidth = 'width89px';
									}
									?>
								
								<div class="extract_quota_box <?php echo $durationWidth;?> ml-8 pl9"><?php echo $lenghtString;?></div>
									<!--extract_quota_box-->
									<?php if($isProjectForsell && ($elements[$k]->isDownloadPrice=='t' || $elements[$k]->isPerViewPrice=='t' || $elements[$k]->isPrice=='t')){
										if(!empty($lenghtString)){
											if($industryType=='filmNvideo'){	
												$pl = 'pl30';
											} else {
												$pl = 'pl12';
											}	
										}else{
											if($industryType=='writingNpublishing'){	
												$pl = 'pl5';
											} else {
												$pl = 'pl30';
											}
										}
										?>
										<div class="extract_quota_box width28px <?php echo $pl;?>">
											<?php
											$priceTag="<div class='priceTag'>";
											if( $elements[$k]->isDownloadPrice=='t'){	
												$priceTag.="<div class='price'>
													".$this->lang->line('download')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format($elements[$k]->downloadPrice,2)."
												</div>";
											}
											if( $elements[$k]->isPerViewPrice=='t'){	
												$priceTag.="<div class='price'>
													".$this->lang->line('ppv')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format($elements[$k]->perViewPrice,2)."
												</div>";
											}
											if( $elements[$k]->isPrice=='t'){	
												$priceTag.="<div class='price'>
													".$this->lang->line('product')." ".$this->lang->line('price').": ".$this->lang->line('EURO').number_format($elements[$k]->price,2)."
												</div>";
											}
											
											$priceTag.="</div> ";
											?>											
											<div class="fl projectticketicon formTip" title="<?php echo $priceTag;?>"> </div>
										</div>
										<?php }	?>
										
										
										
										
										<!--extract_quota_box-->
									<div class="extract_button_box">
										<?php
											if($convsrsionFlag){ ?>
												<div class="fl mr25 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
												<?
											}
										
										if($isPurchasedItem){
											 $elementCannotDelete = $this->lang->line('elementCannotDelete').$sellExpiryDate;
											 $deleteFunction="customAlert('".$elementCannotDelete."');";
										  }else{
											  $deleteFunction="moveMediaElementInTrash('".$elements[$k]->projId."','".$elemetTable."','".$elements[$k]->elementId."','".$sectionId."','".$this->lang->line('sureDelMsg')."');";
										  }
										 //TO shoe text accroding to publish/unpublish/hide property of a button
										 if($elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t') 
											echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_published').'</div>';
										 else if($elements[$k]->isPublished !='t' && $elements[$k]->isBlocked !='t')
											echo '<div class="cell orange_color fmoss mr12">'.$this->lang->line('not_published').'</div>';
										 else if( $elements[$k]->isBlocked =='t')	
											echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_blocked').'</div>';
										?>
									  <div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="<?php echo $deleteFunction;?>"><div class="cat_smll_plus_icon"></div></a></div>
									  <?php
										 if( $elements[$k]->isBlocked !='t'){ ?>
											<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>">
												<a href="javascript:void(0)" <?php if($projSellstatus=='t') {?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>),manageFileForm('<?php echo $type->type;?>',data<?php echo $type->elementTypeId;?>)" <?php } else { ?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>)" <?php }?>>
												<div class="cat_smll_edit_icon"></div>
												</a>
											</div>
										<?php
										 }else{
												echo '<div class="small_btn">&nbsp;</div>';
										 }?>
										<!---make video image as project conver image code start--->	
										<?php 
										if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f" && $elements[$k]->default=="f"){ ?> 
											<!---<div  class="small_btn formTip" title="<?php //echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php //echo $elemetTable;?>',<?php //echo $elements[$k]->projId; ?>,<?php //echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>--->	 
										<?php } ?>
										<!---make video image as project conver image code end--->
									</div>
								  </div>
								</div>
								<?php
							}else{
								$src=getImage('',$imagetype);
								$jsonData=array(
												'seller_currency'=>$seller_currency,
												'imgSrc'=>$src,
												'fileTitle'=>$type->type.' '.$label['of'].' '.string_decode($LID->projName),
												'isExternal'=>'f',
												'rawFileName'=>'',
												'fileName'=>'',
												'fileType'=>$fileConfig['typeOfFile'],
												'fileSize'=>0,
												'fileInput'=>'',
												'embbededURL'=>'',
												'fileLength'=>$defaultValue,
												'hh'=>'00',
												'mm'=>'00',
												'ss'=>'00',
												'downloadPrice'=>00.00,
												'perViewPrice'=>00.00,
												'price'=>00.00,
												'quantity'=>0,
												'isDownloadPrice'=>'f',
												'isPerViewPrice'=>'f',
												'isPrice'=>'f',
												'elementId'=>0,
												'mediaTypeId'=>$type->elementTypeId,
												'fileId'=>0,
												'fileHeight' => '',
												'fileWidth' => '',
												'fileUnit' 	=> '',	
												'isDefaultElement'=>$type->default
											);
								if($indusrty=='writingNpublishing' || $indusrty=='educationMaterial'){
									$jsonData['wordCount']=0;
								}
								
								$jsonData=json_encode($jsonData);
								?>
								<script>var data<?php echo $type->elementTypeId;?> = <?php echo $jsonData;?>;</script>
								<div class="row">
								  <div class="label_wrapper cell">
									<?php 
									if ($indusrty=='photographyNart' ){
										$imageNo=$key+1;
										$labelforHeading = $this->lang->line('add').' '.$this->lang->line('imageorpiece').' '.$imageNo.' '.$label['of'].' '.$LID->projName;
										?>
										<label class=""><?php echo  $this->lang->line('imageorpiece').' '.$imageNo;?></label>
										<?php 
									}else{ 
										$labelforHeading = $this->lang->line('add').' '.$type->type.' '.$label['of'].' '.$LID->projName;
										?>
									<label class=""><?php echo $type->type;?></label>
									<?php } ?>
								  </div>
								  <!--label_wrapper-->
								  <div id="rowData<?php echo $type->elementTypeId;?>" class=" cell frm_element_wrapper extract_content_bg ">
									<div class="extract_img_wp opacity_4"> 
										<a href="javascript:void(0)" <?php if($projSellstatus=='t') {?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>),manageFileForm('<?php echo $type->type;?>',data<?php echo $type->elementTypeId;?>)" <?php } else { ?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>)" <?php }?> class="formTip" title="<?php echo $this->lang->line('add');?>">
											<img class="formTip ptr maxWH30 ma" src="<?php echo $src; ?>" />
										</a>
									</div>
									<!--extract_img_wp-->
									<div class="extract_heading_box opacity_4"><?php echo  string_decode($labelforHeading); ?></div>
									<!--extract_heading_box--> 
									<?php 
									if (($defaultValue!='00:00:00') && ($defaultValue!='')) { ?>
										<div class="extract_quota_box opacity_4"> <?php echo $defaultValue.' '.$px;?> </div> <?php 
									} ?>
									<!--extract_quota_box-->
									<div class="extract_button_box">
										<div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>">
											<a href="javascript:void(0)" <?php if($projSellstatus=='t') {?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>),manageFileForm('<?php echo $type->type;?>',data<?php echo $type->elementTypeId;?>)" <?php } else { ?> onclick="changeUploadMediyaFormValue(data<?php echo $type->elementTypeId;?>)" <?php }?>><div class="cat_smll_add_icon"></div></a></div>
									</div>
								  </div>
								</div>
								<?php
							}
						}
					}
					
					$totalElementForShallInput = array(
						'name'	=> 'totalElementForShall',
						'id'	=> 'totalElementForShall',
						'type'	=> 'hidden',
						'value'	=> $totalElementForShall
					);
					echo form_input($totalElementForShallInput);
				?>
				
				<div class="seprator_25 clear row"></div>
			</div>			
			
		</div>
		<div class="row">
			<div class="tab_shadow"></div>
		</div>
	</div>
</div>

<!-- Upload first save media popup-->

<?php
/* Upload first save media popup Start*/
	$isShowMediaPopup=$this->session->userdata('isShowMediaPopup');
	if($isShowMediaPopup && $isShowMediaPopup==1){
		$this->session->unset_userdata('isShowMediaPopup');
		$uploadData['descriptionUrl'] = site_url(lang()).'/media/'.$indusrty.'/editProject/furtherDescription/'.$projectId;
		$uploadData['prMaterialUrl'] = site_url(lang()).'/media/'.$indusrty.'/editProject/additionalInformation/'.$projectId;
		$uploadData['indexUrl'] = site_url(lang()).'/media/'.$indusrty.'/'.$projectId;
		$uploadData['popupSection'] = 'media';
		
		//$uploadData['industryType'] = $indusrty;
		//$uploadData['projectId'] = $projectId;
		//$popup_media = $this->load->view('common/afterSavePopup',$uploadData, true);
		$popup_media = $this->load->view('common/afterSavePopup',$uploadData, true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				 loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}else{
		
	}
/* Upload first save media popup End*/

// browser is IE Start
	if(isset($showForm) && $showForm=='dn' && $userBrowser == 'ie'){?>
		<script> toggleWithDelay('#uploadElementForm');</script>
		<?php 
	}
// browser is IE END


$userContainerId = (isset($LID->userContainerId) && ($LID->userContainerId!='')) ? $LID->userContainerId : 0;

?>

<input name="userContainerId" id="userContainerId" value="<?php echo $userContainerId ?>" type="hidden">
<script>
	$(document).ready(function(){
		
		/* load upload media suggetion box*/
		
		$(".readonly").click(function(){
			var value = $(this).attr('price');
			var ceckboxId = $(this).attr('ceckboxId');
			var checked = $(this).attr('checked');
			if(checked == 'checked'){
				$('#'+ceckboxId).removeAttr("readonly");
				$('#'+ceckboxId).attr("class",'fl price_input font_opensansSBold clr_666 NumGrtrZero required');
			}else{
				$('#'+ceckboxId).attr("readonly",true);
				$('#'+ceckboxId).attr("class",'fl price_input_disable font_opensansSBold clr_666');
				$('#'+ceckboxId).val(value);
				$("label[for="+ceckboxId+"]").remove();
			}
		});
		
		$(".ajaxCancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			var toggleDivFormID = $(this).closest("form").attr('id');
			$('#'+toggleDivFormID)[0].reset();
			$("#"+toggleDivForm).slideToggle('slow');
		});

		$("#uploadmediaForm").validate({
		
			messages: {
				fileHeight: '<?php echo $this->lang->line('validDimension');?>',
				fileWidth: '<?php echo $this->lang->line('validDimension');?>'				
			},
			submitHandler: function() {
				
				var loadView = 'uploadFileDetails';
				var totalElementForShall = $('#totalElementForShall').val();
				var isExternal = $('#isExternal').val();
				var mediaTypeId = $('#mediaTypeId').val();
				var imgSrc = $('#imgSrc').val();
				var divId='rowData'+mediaTypeId;
				var elemetTable = '<?php echo $elemetTable;?>';
				var elementFieldId = '<?php echo $elementFieldId;?>';
				var elementId = $('#elementId').val();
				var fileId = $('#fileId').val();
				var isDefaultElement = $('#isDefaultElement').val();
				var isDownloadPrice =  (($('#isDownloadPrice').attr('checked')) ? 't' : 'f') ;
				var isPerViewPrice = (($('#isPerViewPrice').attr('checked')) ? 't' : 'f') ;
				var isPrice = (($('#isPrice').attr('checked')) ? 't' : 'f') ;
				var rawFileName = $('#fileInput').val();
				
				// Change for PhotoGraphy N Art
				var fileWidth = $('#fileWidth').val();
				var fileHeight = $('#fileHeight').val();
				var fileUnit = $('#fileUnit').val();
				
				var projSellstatus = $('#projSellstatus').val();
				var projSellType = $('#projSellType').val();
				var sellPriceType = $('#sellPriceType').val();
				var industrySection = $('#industrySection').val();
				
				if(projSellstatus=='t' && projSellType==1 && (sellPriceType==2 || industrySection=='educationMaterial')){
					if(isDownloadPrice=='t' || isPrice=='t' || isPerViewPrice=='t') {
						$('#pricesError').hide();
					} else {
						$('#pricesError').show();
						return false;
					}
				}
					
				if(fileWidth=='')	
					fileWidth=0;			
				
				if(fileHeight=='')
				  fileHeight=0;
				  
				var mediaFileType= $('#fileType').val();
				mediaFileType = (mediaFileType=='audio visual' || mediaFileType=='video')?'2':mediaFileType;
				
				var hh=$('#hh').val();
				var mm=$('#mm').val();
				var ss=$('#ss').val();
				
				if(parseInt(hh) >=0 || parseInt(mm) >=0 || parseInt(ss) >=0){
					var fileLength=hh+':'+mm+':'+ss;
				}else{
					var fileLength='00:00:00';
				}
				
				if(fileHeight!=0 && fileWidth!=0) {
					  if(fileUnit=='')
					  {
						  //alert('Please select unit')
						   $('#fileUnit').addClass('required');
						  return false;
					  }
					  else  $('#fileUnit').removeClass('required');
					  
				}
				if($('#wordCount')){
					var wordCount = $('#wordCount').val();
					wordCount = (wordCount && wordCount > 0)?wordCount:0;
					if(wordCount > 0){
						var data = {"projId":$('#projectid').val(),"mediaTypeId":$('#mediaTypeId').val(),"title":$('#fileTitle').val(),"wordCount":wordCount,"downloadPrice":$('#downloadPrice').val(),"perViewPrice":$('#perViewPrice').val(),"price":$('#price').val(),"isDownloadPrice":isDownloadPrice,"isPerViewPrice":isPerViewPrice,"isPrice":isPrice,"quantity":$('#quantity').val(),"modifyDate":"<?php echo date('Y-m-d h:i:s');?>"};
					}else{
						var data = {"projId":$('#projectid').val(),"mediaTypeId":$('#mediaTypeId').val(),"title":$('#fileTitle').val(),"downloadPrice":$('#downloadPrice').val(),"perViewPrice":$('#perViewPrice').val(),"price":$('#price').val(),"isDownloadPrice":isDownloadPrice,"isPerViewPrice":isPerViewPrice,"isPrice":isPrice,"quantity":$('#quantity').val(),"modifyDate":"<?php echo date('Y-m-d h:i:s');?>"};
					}
				}else{
					var data = {"projId":$('#projectid').val(),"mediaTypeId":$('#mediaTypeId').val(),"title":$('#fileTitle').val(),"downloadPrice":$('#downloadPrice').val(),"perViewPrice":$('#perViewPrice').val(),"price":$('#price').val(),"isDownloadPrice":isDownloadPrice,"isPerViewPrice":isPerViewPrice,"isPrice":isPrice,"quantity":$('#quantity').val(),"modifyDate":"<?php echo date('Y-m-d h:i:s');?>"};
				}
				
				if(elementId > 0){
					var action='<?php echo $this->lang->line('updated');?>';
				}else{
					var action='<?php echo $this->lang->line('added');?>';
				}
				
				if(isExternal=='t'){
					var fileData = {"filePath":$('#embbededURL').val(),"fileName":'',"fileLength":fileLength,"fileSize":0,"fileType":mediaFileType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>,"fileHeight":fileHeight,"fileWidth":fileWidth,"fileUnit":fileUnit}; 
				}else{
					if(elementId > 0){
						var rawFileName = $('#rawFileName').val();
						var fileData = {"fileLength":fileLength,"fileType":mediaFileType,"fileHeight":fileHeight,"fileWidth":fileWidth,"fileUnit":fileUnit}; 
					}else{
						var fileSize = $('#fileSize').val();
						fileSize =parseInt(fileSize);
						var fileData = {"filePath":'<?php echo $filePath; ?>',"rawFileName":rawFileName,"fileName":$('#fileName').val(),"fileLength":fileLength,"fileSize":fileSize,"fileType":mediaFileType,"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>,"fileHeight":fileHeight,"fileWidth":fileWidth,"fileUnit":fileUnit}; 
						var availableRemainingSpace = $('#availableRemainingSpace').val();
						availableRemainingSpace =parseInt(availableRemainingSpace);
						availableRemainingSpace =parseInt(availableRemainingSpace);
						availableRemainingSpace =(availableRemainingSpace-fileSize);
						if(!availableRemainingSpace > 0){
							availableRemainingSpace = 0;
						}
						$('#availableRemainingSpace').val(availableRemainingSpace);
					}
				}
				
				var returnFlag=AJAX('<?php echo base_url(lang()."/common/UpdateMediaTable");?>',divId,fileData,data,fileId,elementId,elemetTable,elementFieldId,imgSrc,isDefaultElement,loadView,'<?php echo $deleteCache;?>');
				if(returnFlag){
					var updateData={"projLastModifyDate":'<?php echo date('Y-m-d h:i:s');?>'};
					var where={"projId":$('#projectid').val()};
					AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'Project',where,'');
					
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> '+action+' <?php echo $indusrty;?>.</div>');
					timeout = setTimeout(hideDiv, 5000);
					
					$("#uploadFileByJquery").click();
					$("#uploadElementForm").slideToggle('slow');
					
					if(isExternal=='t' || elementId > 0){
						refreshPge();
					}
					
				}
			 }
		});
		
	// ADD BY AMIT	
		$('#fileWidth').change(function(){
			var fileWidth = $('#fileWidth').val();
			var fileHeight = $('#fileHeight').val();
			var fileUnit = $('#fileUnit').val();		
			if(fileWidth <=0 ){				
				if(fileHeight >= 0){				
					$('#fileWidth').addClass('dimensions error numberGreaterZero');					
				} else {
					$('#fileHeight').removeClass('dimensions error numberGreaterZero');					  
				}			       
			      
			   } else if(fileWidth>=0) {				
				if(fileHeight <=0){ 					
					$('#fileHeight').addClass('dimensions error numberGreaterZero');						
				}else {						  
					$('#fileWidth').removeClass('dimensions error numberGreaterZero');						  
				}	
				
				  }		       
			});
			
			$('#fileHeight').change(function(){
			
			var fileWidth = $('#fileWidth').val();
			var fileHeight = $('#fileHeight').val();
				
			
			if(fileHeight <=0 ){				
				if(fileWidth >= 0){				
					$('#fileHeight').addClass('dimensions error numberGreaterZero');
					
			      } else {
					  $('#fileWidth').removeClass('dimensions error numberGreaterZero');					  
					  }
			       
			      
			} else if(fileHeight>=0) {				
				      if(fileWidth <=0){ 					
						$('#fileWidth').addClass('dimensions error numberGreaterZero');						
						
					  }else {
						  
						  $('#fileHeight').removeClass('dimensions error numberGreaterZero');
						  
						  }	
				
				}		       
			});
			
		$('#isprojPrice').click(function(){
			if($('#isprojPrice').is(':checked') === true) {
				$('#shippingList').show();
			}else{
				$('#shippingList').hide();
			}
		});
		
		//manage elements product checkbox
		$('#isPrice').click(function(){
			var rawFileName = $('#rawFileNameDiv').html();
			var industrySection = $('#industrySection').val();
			if($('#isPrice').is(':checked') === true && (rawFileName.length<4 || rawFileName == null)) {
				$('#removeProductPiece').show();
				$('#fileDurationDiv').show();
				$('#uploadFileSection').show();
				$('#downloadPriceSection').show();
				$('#fileDimentionDiv').show();
				$('#pricesError').hide();
				if($('#selectFileType3').is(':checked') === true || industrySection=='writingNpublishing') {
					$('#wordCountDiv').show();	
				}
			}else{
				$('#removeProductPiece').hide();
				if($('#isPrice').is(':checked') === true){
					$('#rawFileNameContainerDiv').show();
					$('#removeProductPiece').show();
					$('#fileDurationDiv').show();
					$('#fileDimentionDiv').show();
					//$('#uploadFileSection').show();
					$('#downloadPriceSection').show();
					if($('#selectFileType3').is(':checked') === true || industrySection=='writingNpublishing') {
						$('#wordCountDiv').show();	
					}
					if(industrySection=='photographyNart') {
						$('#EmbeddedURL').hide();
					}
				}else{
					//$('#fileDurationDiv').hide();
					if($('#isDownloadPrice').is(':checked') === false && (industrySection!='filmNvideo' || $('#isPerViewPrice').is(':checked') === false)){
						$('#fileDurationDiv').hide();						
						$('#downloadPriceSection').hide();
						$('#fileDimentionDiv').hide();
						$('#uploadFileSection').hide();
						$('#wordCountDiv').hide();	
					}
				}
			}
		});
		
		//manage elements PPV checkbox
		$('#isPerViewPrice').click(function(){
			var rawFileName = $('#rawFileNameDiv').html();
			var industrySection = $('#industrySection').val();
			if($('#isPerViewPrice').is(':checked') === true && (rawFileName.length<4 || rawFileName == null)) {
				$('#pricesError').hide();
				$('#downloadPriceSection').show();
				$('#fileDurationDiv').show();
				$('#uploadFileSection').show();
				//$('#EmbeddedURL').hide();
			}else{
				if($('#isPerViewPrice').is(':checked') === true){
					$('#rawFileNameContainerDiv').show();
					$('#fileDurationDiv').show();
				}else{
					if($('#isPrice').is(':checked') === false && $('#isDownloadPrice').is(':checked') === false){
						$('#fileDurationDiv').hide();
						$('#uploadFileSection').hide();
					}
				}
			}
		});
		
		//manage elements download checkbox
		$('#isDownloadPrice').click(function(){
			var rawFileName = $('#rawFileNameDiv').html();
			var industrySection = $('#industrySection').val();
			if(($('#isDownloadPrice').is(':checked') === true) && (rawFileName.length<4 || rawFileName == null)) {
				$('#downloadPriceSection').show();
				$('#fileDimentionDiv').show();
				$('#fileDurationDiv').show();
				$('#uploadFileSection').show();
				$('#fileInput').addClass('required');
				//$('#EmbeddedURL').hide();
				$('#pricesError').hide();
				if(industrySection=='photographyNart'){
					$('#fileDimentionDiv').show();
				}

				if($('#selectFileType3').is(':checked') === true || industrySection=='writingNpublishing') {
					$('#wordCountDiv').show();	
				}
			}else{
				if($('#isDownloadPrice').is(':checked') === true){
					$('#rawFileNameContainerDiv').show();
					$('#fileDimentionDiv').show();
					$('#fileDurationDiv').show();
					if($('#selectFileType3').is(':checked') === true || industrySection=='writingNpublishing') {
						$('#wordCountDiv').show();	
					}
					if(industrySection=='photographyNart') {
						$('#EmbeddedURL').hide();
					}
				}else{
					//$('#fileDurationDiv').hide();
					if($('#isPrice').is(':checked') === false && (industrySection!='filmNvideo' || $('#isPerViewPrice').is(':checked') === false)){
						//$('#downloadPriceSection').hide();
						$('#fileDurationDiv').hide();
						$('#fileDimentionDiv').hide();
						$('#wordCountDiv').hide();	
						$('#uploadFileSection').hide();
					}
				}
			}
		});
		
		//Hide shipping fields when 
		<?php if(isset($LID->projSellType) && $LID->projSellType==2) { ?>
			if($('#isprojPrice').is(':checked') === false) {
				$('#shippingList').show();
			}
		<?php }?>
			
	// END		
	});
	function uploadMathod(obj){
		var Id = $(obj).attr('id');
		if(Id == 'uploadSelected'){
			if($('#isDefaultElement').val()=='f'){
				if('#showInUploadCase'){
					$('#showInUploadCase').show();
				}
			}
		}else{
			if('#showInUploadCase'){
				$('#showInUploadCase').hide();
			}
		}
	}
	
   
   function manageFileForm(type,data) {
		var pieceType=type.split(" ");
		var projSellstatus = $('#projSellstatus').val();
		var projSellType = $('#projSellType').val();
		var sellPriceType = $('#sellPriceType').val();
		var industrySection = $('#industrySection').val();
	
		if(pieceType[0]!='Extract' && pieceType[0]!='Trailer' && pieceType[0]!='Sample' && projSellstatus!='t'){
			$('#downloadPriceSection').hide();
			$('#fileDurationDiv').hide();
		}else{
			$('#downloadPriceSection').show();
			$('#fileDurationDiv').show();
		}
		
		if(data.isPrice=='t'){		
			$('#removeProductPiece').show();
		} else {
			$('#removeProductPiece').hide();
		}
		
		if(data.isDownloadPrice!='t' && projSellType==1 && pieceType[0]!='Extract' && pieceType[0]!='Trailer' && pieceType[0]!='Sample' && (sellPriceType==2 || industrySection=='educationMaterial')){	
			$('#wordCountDiv').hide();	
			$('#fileDurationDiv').hide();
			$('#uploadFileSection').hide();
			if(industrySection=='photographyNart'){
				$('#fileDimentionDiv').hide();
			}
		} else {
			if(data.rawFileName==null || data.rawFileName.length<4) {
				//$('#EmbeddedURL').hide();
				$('#uploadFileSection').show();
				if(industrySection=='photographyNart'){
					$('#fileDimentionDiv').show();
				}
				$('#fileInput').addClass('required');
			}
		}
		
		if(data.rawFileName !=null && data.rawFileName.length>4) {
			$('#fileDurationDiv').show();
			$('#fileDimentionDiv').show();
		}
		
		if(projSellstatus=='t' && pieceType[0]!='Extract' && pieceType[0]!='Trailer' && pieceType[0]!='Sample') {
			$('#embedButton').hide();
			
			if(industrySection=='educationMaterial') {
				$('#uploafFileButton').css({ "float": "right", "margin-right": "3px" });
			} 
		} else {
				$('#uploafFileButton').css({ "float": "left", "margin-right": "8px" });
		}
		
		if(industrySection=='photographyNart') {
			$('#EmbeddedURL').hide();
		}
   }
  
</script> 
