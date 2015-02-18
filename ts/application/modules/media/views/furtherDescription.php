<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$thumbFolder='thumb';
	$containerSize=(isset($LID->containerSize) && is_numeric($LID->containerSize))?$LID->containerSize:$this->config->item('defaultContainerSize');
	$projSellstatus=$LID->projSellstatus;
	
	$dirname=$dirUploadMedia.$industryType.'/'.$projectId.'/';
	$dirSize=getFolderSize($dirname);
	$remainingBytes =($containerSize - $dirSize);
	if(!$remainingBytes > 0){
		$remainingBytes =0;
	}
	$dirSize=bytestoMB($dirSize,'mb');
	$reminingSize=($containerSize-$dirSize);
	
	$containerSize=bytestoMB($containerSize,'mb');
	
	if($reminingSize < 0){
			$reminingSize = 0;
	}
	$dirSize = number_format($dirSize,2,'.','');
	$reminingSize = number_format($reminingSize,2,'.','');
	
	$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
	$imagetype=$fileConfig['defaultImage'];
	$fileType=$fileConfig['typeOfFile'];
	$showForm='dn';
	$mediaTypeIds=array();
	$mediaTypeIds[]=0;
	$title='';
	$fileLength='';
	$imgSrc=$src=getImage('',$imagetype);
	$productionCompany='';
	$tags=''; 
	$description='';
	$elementId=0;
	$browseId='Element';
	$cpd='';
	//$imgReqired='required';
	$imgReqired='';
	if($elements){
		foreach($elements as $k=>$element){
			$mediaTypeIds[$k]=$element->mediaTypeId;
			if(is_numeric($projectElementId) && $element->elementId==$projectElementId){
				$showForm='';
				if($indusrty=='photographyNart'){
					$src=getImage($element->filePath.$element->fileName,$imagetype);
				}else{
					
					if($indusrty=='filmNvideo'){
						if(empty($element->imagePath)){	
						$smallElementsImg = getVideoThumbFolder(@$element->filePath.$element->fileName,'_xxs');		
						$src = getImage($smallElementsImg,$imagetype);
						}else{
							$smallElementsImg = addThumbFolder($element->imagePath,'_xxs');
							$src = getImage($smallElementsImg,$imagetype);
						}
					}else{
						$src=getImage($element->imagePath,$imagetype);
					}
				}
				$title=$element->title;
				$fileLength=$element->fileLength;
				$imgSrc=$src;
				$fileType=$element->fileType;
				$tags=$element->tags;
				$description=$element->description;
				$productionCompany=$element->productionCompany;
				$elementId=$element->elementId;
				if(($description==null || empty($description)) && ($tags==null || empty($tags)) && ($element->fileName==null || empty($element->fileName))){
					$cpd='';
					//$imgReqired='required';
					$imgReqired='';
				}else{
					$cpd='dn';
					$imgReqired='';
				}
			}
		}
	}

$formAttributes = array(
	'name'=>'FDEF',
	'id'=>'FDEF',
	'toggleDivForm'=>'updateFurtherDescriptionForm'
);	

$productionCompany = array(
	'name'	=> 'productionCompany',
	'id'	=> 'productionCompany'.$browseId,
	'class'	=> 'width556px',
	'value'	=> $productionCompany,
	/*'placeholder'	=> $label['projNameTitle'],*/
	//'minlength'	=> 2,
	'maxlength'	=> 50
);

$titleInput = array(
	'name'	=> 'title',
	'type'	=> 'hidden',
	'id'	=> 'title'.$browseId,
	'value'	=> $title
);

$fileLengthInput = array( 
	'name'	=> 'fileLength',
	'type'	=> 'hidden',
	'id'	=> 'fileLength'.$browseId,
	'value'	=> $fileLength
);

$projectidInput = array(
	'name'	=> 'projectid',
	'type'	=> 'hidden',
	'id'	=> 'projectid',
	'value'	=> @$LID->projectid?@$LID->projectid:0
);

$elementIdInput = array(
	'name'	=> 'elementId',
	'type'	=> 'hidden',
	'id'	=> 'elementId',
	'value'	=> $elementId
);

$imgSrcInput = array(
		'name'	=> 'imgSrc',
		'id'	=> 'imgSrc'.$browseId,
		'type'	=> 'hidden',
		'value'	=> $imgSrc
	);
	
if(!$LID->projRating > 0){
	$projectToggle_icon='toggle_icon';
	$FDSshow='';
	
	$elementToggle_icon='';
	$FDESshow='dn';
	$toggleDivId='';
	$elementTabClass='opacity_4';
}else{
	//$projectToggle_icon='';
	//$FDSshow='dn';
	$projectToggle_icon='toggle_icon';
	$FDSshow='';
	
	$elementToggle_icon='toggle_icon';
	$FDESshow='';
	$toggleDivId='FDES';
	$elementTabClass='';
}
$projectEntityId=getMasterTableRecord('Project');
//$accordianHeading = ($LID->topTitleBar=='Lessons')?$this->lang->line('lessonDescription'):$this->lang->line('pieceDescription');
//$listHeading = $this->lang->line('ProjectDescription');
$accordianHeading = ($LID->topTitleBar=='Lessons')?$this->lang->line('lessonDescription'):$this->lang->line('piecesCoverPages');
$listHeading = $this->lang->line('projectCoverPages');
      if($indusrty =='filmNvideo') { 	
		 $labelCompany= $label['productioncompany'];
	  } else if (($indusrty =='writingNpublishing') || ($indusrty =='educationMaterial') ) { 
		     $labelCompany = $label['publisher'];
	  } else if ($indusrty=='photographyNart' ) {  
	     	$labelCompany = $label['gallery'];
	     	$accordianHeading = $this->lang->line('imageDescription');
	  } else  { 
		   $labelCompany = $label['productionHouse'];
	  }
	  
	$userBrowser = get_user_browser();
	$showFormIE=$showForm;
	if($userBrowser == 'ie'){
		$showFormIE='';
	}
?> 

<div class="row form_wrapper">
   <div class="row">
		<div class="cell frm_heading">
			<h1>
				<?php //echo $label['furtherDescription'];
				echo $label['coverPages'];
				?>
			</h1>
		</div>
		<?php echo $header; ?>
	</div>
 <!--second tab-->
   
    <?php
		$formAttributess = array(
			'name'=>'FDF',
			'id'=>'FDF',
			'toggleDivForm'=>'FDS'
		);
		
		
		$browseProjectId = 'Project';
		
		
		$projPreviewStatus = array(
			'name'	=> 'projPreviewStatus',
			'id'	=> 'projPreviewStatus',
			'class'	=> 'formTip',
			'type'	=> 'checkbox',
			'value'	=> 't',
			'title' =>  $this->lang->line('PreviewAudioTooltip')
		);

		$PreviewStatus=@$LID->projPreviewStatus=='t'?true:false;

		if($PreviewStatus){
			$projPreviewStatus['checked']=true;
		}

		$productionHouse = array(
			'name'	=> 'productionHouse',
			'id'	=> 'productionHouse'.$browseProjectId,
			'class'	=> 'width556px',
			'value'	=> $LID->productionHouse,
			'minlength'	=> 2,
			'maxlength'	=> 50
		);
		
		
		if(isset($LID->isExternalImageURL) && $LID->isExternalImageURL=='t'){
			$projectImage=trim($LID->projBaseImgPath);
		}else{
			
			//----------make element default project image code start---------//
			if(!empty($LID->projBaseImgPath)){
				$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
				$projectImage = getImage($projThumbImage,$imagetype,1);
			}else{
				
				$getPojrectImage = getProjectElementImage($LID->projectid,$entityId);	
				if(is_array($getPojrectImage)){
					if($getPojrectImage['isExternal']=="t"){
						$projectImage = checkExternalImage($getPojrectImage['filePath'],'_s');
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
				
		
		/*$projectImage= addThumbFolder($LID->projBaseImgPath,'_s');

		$projectImage=getImage($projectImage,$imagetype);*/
		
		//echo "<pre>";
		//print_r($LID);
		//echo "</pre>"; die;
	?>
    
    <div class="row tab_wp pt2">
		<!--first div header start-->
      <div class="row ">
        <div class="cell tab_left">
          <div class="tab_heading"><?php echo $listHeading; ?></div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
          <span class="according_heading"><?php echo $LID->projName; ?></span>
          <div class="tab_btn_wrapper">
            <div class="tds-button-top">
              <a class="formTip"> <span>
              <div class="projectToggleIcon <?php echo $projectToggle_icon;?>" toggleDivId="FDS"></div>
              </span> </a> 
              </div>
          </div>
          
        </div>
      </div>
    
      <!--row-->
      <div class="clear"></div>
      <!--first div start-->
      <div class="form_wrapper toggle frm_strip_bg <?php echo $FDSshow;?>" id="FDS" >
		  <div class="row"><div class="tab_shadow"></div></div>
			<div class="row" id="FileContainer<?php echo $browseProjectId;?>">
				<?php 
				echo form_open_multipart($this->uri->uri_string(),$formAttributess); 
					$img='<img src="'.$projectImage.'" />';
					
					// remove iamge requred form project
					/*if(strlen($LID->projBaseImgPath) > 4){ 
							$imgRequired='';
					}else{
						$imgRequired='required';
					}*/
					
					$imgRequired='';
					$inputArray = array(
						'name'	=> 'fileInput'.$browseProjectId,
						'class'	=> 'mt9 '.$imgRequired,
						'value'	=> '',
						'id'	=> 'fileInput'.$browseProjectId,
						'type'	=> 'text',
						'readonly' => true
					);
					//echo $img;
					$data=array('fileType'=>$this->config->item('imageAccept'),
					'fileMaxSize'=>$this->config->item('imagemaxSize'),'fileUploadPath'=>$fileUploadPath,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('coverImage'),'browseId'=>$browseProjectId,'view'=>'uploadMultipleImageForm');
					echo Modules::run("common/formInputField",$data);
				?>
				
				<div class="row">
					<div class="label_wrapper cell">
						<label><?php echo $labelCompany;?></label>
					</div><!--label_wrapper-->
					<div class="cell frm_element_wrapper">
						<?php echo form_input($productionHouse); ?>							
					</div>
				</div>
				<?php 
				
				    $wordOption = array('minVal'=>'0','maxVal'=>'600');
					$value=@$LID->projDescription;
					$value=htmlentities($value);
					$data=array('name'=>'projDescription'.$browseProjectId,'id'=>'projDescription'.$browseProjectId,'value'=>$value,'required'=>'', 'labelText'=>$this->lang->line('projectFD'), 'view'=>'description', 'descLimit'=>'descLimit'.$browseProjectId,'wordOption'=>$wordOption);
					echo Modules::run("common/formInputField",$data);
				?>
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $label['project_rating'];?></label></div>
					<div class="cell frm_element_wrapper" >
						<div class="formTip fl" title="<?php echo $this->lang->line('ratingMsg');?>"><?php 
							$projRating=@$LID->projRating;
							$Rating = getRatingList(1,lang(),'selectRating');
							echo form_dropdown('projRating', $Rating, $projRating,'id="projRating" class="required"');
						?>
						</div>
						<div class="row wordcounter">
							<span class="tag_word_orange"><?php echo $this->lang->line('adultsMaterialNotAllowed');?></span>
						</div>
					</div>
				</div>
				<?php
				if($indusrty=='musicNaudio'){?>
					<div class="row">
						<div class="cell label_wrapper"><label><?php echo $label['previewFeature'];?></label></div>
						<div class="cell frm_element_wrapper mt5" >
							<div class="cell defaultP">
								<?php echo form_input($projPreviewStatus); ?>
							</div>
							<div class="cell">
							  <?php // echo $label['previewFeatureMsg'];?>
							</div>
						</div>
					</div>
					<?
				}?>          
				<div class="row">
					<div class="label_wrapper cell"><div class="lable_heading"><h1 class="formTip" title="<?php echo $this->lang->line('supportingMaterialToolTip');?>"><?php echo $label['supportingMedia'];?></h1></div></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper"></div>
				</div><!--from_element_wrapper-->
				
				<input id="isUpdatedSupportingMedia" name="isUpdatedSupportingMedia" type="hidden" value="0">
				<?php
				
				if($label['linkToScript'] && !empty($label['linkToScript'])){?>
					<div class="row">
						<div class="label_wrapper cell">
							<label><?php echo $label['linkToScript'];?></label>
						</div><!--label_wrapper-->
						
						<div class=" cell frm_element_wrapper">
							<div class="row">
								<?php $displaySearch=(isset($suportLinks[1]['id']) && $suportLinks[1]['id'] > 0)?'dn':'';?>
								
								<div id="linkToScriptSearchInputDiv" class="cell search_box_wrapper <?php echo $displaySearch;?>">
									<input id="linkToScript" name="linkToScript" type="text" class="search_text_box" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
									<div class="search_btn ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToScript').val(),'media','linkToScript');">
										<img src="<?php echo base_url('images/btn_search_box.png');?>">
									</div>
								</div>
								
								
								<div id="linkToScriptDiv" class="cell pt8 pl20 pr20 width200px"><?php if(isset($suportLinks[1]['title'])) echo $suportLinks[1]['title'];?></div>
								 <div id="SupportingRow<?php if(isset($suportLinks[1]['id'])) echo $suportLinks[1]['id'];?>" class="cell pt8">
									 <?php
										if(isset($suportLinks[1]['id']) && $suportLinks[1]['id'] >0){ ?>
											<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteSupportedMedia('<?php echo $suportLinks[1]['id'];?>','linkToScript')"><div class="cat_smll_plus_icon"></div></a></div>
											<?php 
										}
									 ?>
								 </div>
								<input id="linkToScriptentityid_from" name="entityid_from" type="hidden" value="<?php echo isset($suportLinks[1]['entityid_from'])?$suportLinks[1]['entityid_from']:0;?>">
								<input id="linkToScriptelementid_from" name="elementid_from" type="hidden" value="<?php echo isset($suportLinks[1]['elementid_from'])?$suportLinks[1]['elementid_from']:0;?>">
							</div>
						</div>
					</div><!--from_element_wrapper-->
					<?php
				}
				if($label['linkToSoundtrack'] && !empty($label['linkToSoundtrack'])){ ?>
					<div class="row">
						<div class="label_wrapper cell">
							<label ><?php echo $label['linkToSoundtrack'];?></label>
						</div><!--label_wrapper-->

						<div class=" cell frm_element_wrapper">
							<div class="row">
								
								<?php $displaySearch=(isset($suportLinks[2]['id']) && $suportLinks[2]['id'] > 0)?'dn':'';?>
								<div id="linkToSoundtrackSearchInputDiv" class="cell search_box_wrapper <?php echo $displaySearch;?>">
									<input id="linkToSoundtrack" name="linkToSoundtrack" type="text" class="search_text_box" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
									<div class="search_btn ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToSoundtrack').val(),'media','linkToSoundtrack');">
										<img src="<?php echo base_url('images/btn_search_box.png');?>">
									</div>
								</div>
								
								<div id="linkToSoundtrackDiv" class="cell pt8 pl20 pr20 width200px"><?php if(isset($suportLinks[2]['title'])) echo $suportLinks[2]['title'];?></div>
								 <div id="SupportingRow<?php if(isset($suportLinks[2]['id'])) echo $suportLinks[2]['id'];?>" class="cell pt8">
									 <?php
										if(isset($suportLinks[2]['id']) && $suportLinks[2]['id'] >0){ ?>
											<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteSupportedMedia('<?php echo $suportLinks[2]['id'];?>','linkToSoundtrack')"><div class="cat_smll_plus_icon"></div></a></div>
											<?php 
										}
									 ?>
								 </div> 
								<input id="linkToSoundtrackentityid_from" name="entityid_from" type="hidden" value="<?php echo isset($suportLinks[2]['entityid_from'])?$suportLinks[2]['entityid_from']:0;?>">
								<input id="linkToSoundtrackelementid_from" name="elementid_from" type="hidden" value="<?php echo isset($suportLinks[2]['elementid_from'])?$suportLinks[2]['elementid_from']:0;?>">
							</div>
						</div>
					</div><!--from_element_wrapper-->
					<?php
				}
				if($label['linkToPoster'] && !empty($label['linkToPoster'])){?>
					<div class="row">
						<div class="label_wrapper cell">
							<label><?php echo $label['linkToPoster'];?></label>
						</div><!--label_wrapper-->

						<div class=" cell frm_element_wrapper">
							<div class="row">
								<?php $displaySearch=(isset($suportLinks[3]['id']) && $suportLinks[3]['id'] > 0)?'dn':'';?>
								<div id="linkToPosterSearchInputDiv" class="cell search_box_wrapper <?php echo $displaySearch;?>">
									<input id="linkToPoster" name="linkToPoster" type="text" class="search_text_box" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
									<div class="search_btn ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToPoster').val(),'media','linkToPoster');">
										<img src="<?php echo base_url('images/btn_search_box.png');?>">
									</div>
								</div>
								
								<div id="linkToPosterDiv" class="cell pt8 pl20 pr20 width200px"><?php if(isset($suportLinks[3]['title'])) echo $suportLinks[3]['title'];?></div>
								 <div id="SupportingRow<?php if(isset($suportLinks[3]['id'])) echo $suportLinks[3]['id'];?>" class="cell pt8">
									 <?php
										if(isset($suportLinks[3]['id']) && $suportLinks[3]['id'] >0){ ?>
											<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteSupportedMedia('<?php echo $suportLinks[3]['id'];?>','linkToPoster')"><div class="cat_smll_plus_icon"></div></a></div>
											<?php 
										}
									 ?>
								 </div>
								<input id="linkToPosterentityid_from" name="entityid_from" type="hidden" value="<?php echo isset($suportLinks[3]['entityid_from'])?$suportLinks[3]['entityid_from']:0;?>">
								<input id="linkToPosterelementid_from" name="elementid_from" type="hidden" value="<?php echo isset($suportLinks[3]['elementid_from'])?$suportLinks[3]['elementid_from']:0;?>">
							</div>
						</div>
					
					
					</div><!--from_element_wrapper-->
					<?php
				}?>
                 <div class="seprator_10 clear"></div>            
				<div class="row">
				  <div class="label_wrapper cell bg-non"> </div>
				  <!--label_wrapper-->
				  <div class=" cell frm_element_wrapper pt15">
						<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?> </div>
						<?php echo form_input($projectidInput); ?>
						<?php
							$button=array('ajaxSave', 'buttonId'=>$browseProjectId);
							echo Modules::run("common/loadButtons",$button); 
						?>
						<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div></div>
					  <div class="seprator_25 clear"></div>
					  
				  </div>
			
					
			</div>
		  <?php echo form_close(); ?>
		  </div>
		  <?php
				echo Modules::run("creativeinvolved/associativeCreatives",$LID->projectid,$projectEntityId,$this->lang->line('mediaProductionTeam')); 
		  ?>
		  
				 <div class="row seprator_25"></div>
      <div class="clear"></div>
      
    </div>
    
    
    
  </div>
	
	<!---second tab div start--->
	
	<div class="row tab_wp  ">
		
		<!--second div header start-->
		
      <div id="elementTab" class="row <?php echo $elementTabClass;?>">
        <div class="cell tab_left">
          <div class="tab_heading"><?php echo $accordianHeading; ?></div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
			<span class="according_heading"><?php echo $LID->projName; ?></span>
          <div class="tab_btn_wrapper">
            <div class="tds-button-top">
                <a class="formTip" >
					<span><div class="projectToggleIcon <?php echo $elementToggle_icon?>" id="elementToggelDiv" toggleDivId="<?php echo $toggleDivId;?>" ></div></span>
				</a>
             </div>
          </div>
          
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      
		<!--second div start-->
		
      <div class="form_wrapper toggle frm_strip_bg <?php echo $FDESshow;?>" id="FDES">
			<div class="row"><div class="tab_shadow"></div></div>
			<div id="updateFurtherDescriptionForm" class="<?php echo $showFormIE;?>">
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box" id="FileContainer<?php echo $browseId;?>">		
					
					<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
						 <div id="copyProjectData" class="row <?php echo $cpd;?>">
							<div class="label_wrapper cell  bg-non">&nbsp;</div><!--label_wrapper-->
							<div class="cell frm_element_wrapper">
								<div class="tds-button btn_span_hover" onclick="copyProjectInformationIntoelement(<?php echo $LID->projectid;?>,<?php echo $projectEntityId;?>,<?php echo $entityId;?>);"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0)"><span><?php echo $this->lang->line('copy');?></span></a> </div>
								<div class="info_line_text"><?php echo $this->lang->line('copyInformation');?></div>							
							</div>
						</div>
						   
						<?php  
							
							$img='<img id="img'.$browseId.'" src="'.$src.'" />';
							$inputArray = array(
								'name'	=> 'fileInput'.$browseId,
								'class'	=> 'width480px '.$imgReqired,
								'value'	=> '',
								'id'	=> 'fileInput'.$browseId,
								'type'	=> 'text',
								'readonly' => true
							);
							
							if($indusrty=='photographyNart'){
								$inputArray = '';
							}
							
							$data=array('fileType'=>$this->config->item('imageAccept'),'fileMaxSize'=>$remainingBytes,'fileUploadPath'=>$fileUploadPath,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('image'),'browseId'=>$browseId,'view'=>'uploadMultipleImageForm');
							echo Modules::run("common/formInputField",$data);
					
													
						?>
						<div class="row">
							<div class="label_wrapper cell">							
					     	      <label ><?php echo $labelCompany;?></label>
					        </div><!--label_wrapper-->
							<div class="cell frm_element_wrapper">
								<?php echo form_input($productionCompany); ?>							
							</div>
						</div>
						
						<?php 
							$value=$tags;
							$value=htmlentities($value);
							$data=array('name'=>'tags'.$browseId,'id'=>'tags'.$browseId,'value'=>$value,'required'=>'', 'labelText'=>'project_tags', 'view'=>'tag_words');
							echo Modules::run("common/formInputField",$data);
						 
							$value=$description;
							$wordOption = array('minVal'=>'0','maxVal'=>'100');
							$value=htmlentities($value);
							$data=array('name'=>'description'.$browseId,'id'=>'description'.$browseId,'value'=>$value,'required'=>'', 'labelText'=>'description', 'view'=>'description', 'descLimit'=>'descLimit'.$browseId,'wordOption'=>$wordOption);
							echo Modules::run("common/formInputField",$data);
						
							echo form_input($elementIdInput);
							echo form_input($imgSrcInput);
							echo form_input($titleInput);
							echo form_input($fileLengthInput); 
						?>
						<div class="row">
						  <div class="label_wrapper cell bg-non"> </div>
						  <!--label_wrapper-->
						  
						  <div class=" cell frm_element_wrapper pt15">
							<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?> </div>
									<?php
										$button=array('ajaxSave', 'ajaxCancel','buttonId'=>$browseId);
										echo Modules::run("common/loadButtons",$button); 
									 ?>
							<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div></div>
							</div>
							
						</div>
						<div class="seprator_25 clear"></div>
					<?php echo form_close(); ?>
				
				
					<div class="row" id="productionTeamDiv">
						<?php
							echo Modules::run("creativeinvolved/associativeCreatives",$elementId,getMasterTableRecord($elementTbl),$this->lang->line('mediaProductionTeam')); 
						 ?>
					</div>
				</div>
				<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
				
				<div class="row seprator_25 clear"></div>
			</div> 
			 <?php
					
					$k=0;
					$default=true;
					if($EelementType){
						foreach($EelementType as $key=>$type){
							$typeName='';
							
							
							if($type->default=='f'){
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
											//$src=$elements[$k]->filePath;
											$src = checkExternalImage($elements[$k]->filePath,'_xxs');
										
										}else{
											if($projSellstatus=='t'){
												$thumbFolder='watermark';
											}
											$smallElementsImg = addThumbFolder($elements[$k]->filePath.$elements[$k]->fileName,'_xxs',$thumbFolder);
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
										
										
										/*$smallElementsImg = addThumbFolder($elements[$k]->imagePath,'_xxs');
										$src = getImage($smallElementsImg,$imagetype);*/
									}
									
								
								if($isExternal=='t'){
									$file=urlencode($elements[$k]->filePath);
									$fileType='external';
								}else{
									$file=$elements[$k]->filePath.$elements[$k]->fileName;
								}
								
								if($elements[$k]->fileType=='audio' || $elements[$k]->fileType==3){
									$lenghtString=($elements[$k]->fileLength=='0:0:0' || $elements[$k]->fileLength=='00:00:00')?'':$elements[$k]->fileLength;
								}
								elseif($elements[$k]->fileType=='text' || $elements[$k]->fileType==4){
									$lenghtString=($elements[$k]->wordCount > 0)?$elements[$k]->wordCount.'&nbsp;'.$this->lang->line('words'):'';
								}
								elseif($elements[$k]->fileType=='image' || $elements[$k]->fileType==1){
									$lenghtString=($elements[$k]->fileHeight > 0 && $elements[$k]->fileWidth > 0)? $elements[$k]->fileHeight.'&nbsp;x&nbsp;'.$elements[$k]->fileWidth.'&nbsp;'.substr(@$elements[$k]->fileUnit,0,2):''; 
								}
								else{
									$lenghtString=($elements[$k]->fileLength=='0:0:0' || $elements[$k]->fileLength=='00:00:00')?'':$elements[$k]->fileLength;
								}
								$jsonData=array(
									'entityId'=>$entityId,
									'title'=>$elements[$k]->title,
									'fileLength'=>$lenghtString,
									'imgSrc'=>$src,
									'rawFileName'=>$elements[$k]->rawFileName,
									'tags'=>$elements[$k]->tags,
									'description'=>$elements[$k]->description,
									'productionCompany'=>$elements[$k]->productionCompany,
									'elementId'=>$elements[$k]->elementId
								);
								//echo '<pre />';print_r($elements);die;
								$jsonData=json_encode($jsonData);
								if(strlen($elements[$k]->tags)==0 && strlen($elements[$k]->description)==0 &&  strlen($elements[$k]->productionCompany)==0){
									$smallIcon='cat_smll_add_icon';
									$titleIcon='add';
								}else{
									$smallIcon='cat_smll_edit_icon';
									$titleIcon='edit';
								}
									
								?>
								<div class="row" id="row<?php echo $elements[$k]->elementId;?>">
									<script>
										 var data<?php echo $elements[$k]->elementId;?> = <?php echo $jsonData;?>;
									</script>

								  <div class="label_wrapper cell">
									<?php if ($indusrty=='photographyNart' ){
										$imageNo=$key+1;
										?>
									<label class=""><?php echo $this->lang->line('imageorpiece').'&nbsp'.$imageNo;?></label>
									<?php }else{ ?>
									<label class=""><?php echo $elements[$k]->type;?></label>
									<?php } ?>
								  </div>
								  <!--label_wrapper-->
								  <div id="rowData<?php echo  $elements[$k]->elementId;?>" class=" cell frm_element_wrapper extract_content_bg">
									<div class="extract_img_wp"> 
										<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>" title="<?php echo $elements[$k]->title; ?>" />
									</div>
									<!--extract_img_wp-->
									<div class="extract_heading_box"> <?php echo getSubString($elements[$k]->title,25); ?> </div>
									<!--extract_heading_box-->
									<div class="extract_quota_box width89px ml-8 pl9"><?php echo $lenghtString; ?></div>
									
									<?php
									if($elements[$k]->isBlocked != 't'){	?>
											<div class="extract_button_box">
											<?php 
											//TO shoe text accroding to publish/unpublish/hide property of a button
											 if($elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t') 
												echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_published').'</div>';
											 else if($elements[$k]->isPublished !='t' && $elements[$k]->isBlocked !='t')
												echo '<div class="cell orange_color fmoss mr12">'.$this->lang->line('not_published').'</div>';
											 else if( $elements[$k]->isBlocked =='t')	
												echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_blocked').'</div>';
											?>
											<div class="small_btn formTip" title="<?php echo $this->lang->line($titleIcon);?>"><a href="javascript:void(0)" onclick="changeFurtherDescriptionFormValue(data<?php echo $elements[$k]->elementId;?>)"><div class="<?php echo $smallIcon;?>"></div></a></div>
											<?php 
											//echo $indusrty;
											//print_r($elements[$k]);
											//&& $elements[$k]->default=="f"
											//make video image as project conver image code start
											
												// This for film&video section
												if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f" && $elements[$k]->isPublished =='t' && $elements[$k]->isExternal =='f' && $elements[$k]->isBlocked !='t' && $indusrty=='filmNvideo'){ ?> 
														<div  class="small_btn formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php echo $elemetTable;?>',<?php echo $elements[$k]->projId; ?>,<?php echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>	 
												<?php } 
												
												//This for rest of section not for photographyNart
												if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f" && $elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t' && $indusrty=='photographyNart'){ ?> 
														<div  class="small_btn formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php echo $elemetTable;?>',<?php echo $elements[$k]->projId; ?>,<?php echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>	 
												<?php }
												
												//This for rest of section not for filmNvideo & photographyNart
												if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f" && $elements[$k]->imagePath!="" && $elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t' && $indusrty!='photographyNart' && $indusrty!='filmNvideo'){ ?> 
														<div  class="small_btn formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php echo $elemetTable;?>',<?php echo $elements[$k]->projId; ?>,<?php echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>	 
												<?php }
												
											//make video image as project conver image code end
											?>
											</div><?php 
										} ?>
									
									
								  </div>
								</div>
								<?php
							}else{
								$src=getImage('',$imagetype);
								?>
								<div class="row">
								  <div class="label_wrapper cell">
									<?php if ($indusrty=='photographyNart' ){
										$imageNo=$key+1;
										$labelforHeading = $this->lang->line('add').' '.$this->lang->line('imageorpiece').'&nbsp'.$imageNo.' '.$label['of'].' '.$LID->projName;
										?>
									<label class=""><?php echo  $this->lang->line('imageorpiece').'&nbsp'.$imageNo;?></label>
									<?php }else{ 
										$labelforHeading = $this->lang->line('add').' '.$type->type.' '.$label['of'].' '.$LID->projName;
										?>
									<label class=""><?php echo $type->type;?></label>
									<?php } ?>
								  </div>
								  <!--label_wrapper-->
								  <div class="cell frm_element_wrapper extract_content_bg">
									<div class="extract_img_wp opacity_4"> 
										<img class="formTip ptr maxWH30 ma" src="<?php echo $src; ?>"  />
									</div>
									<!--extract_img_wp-->
									<div class="extract_heading_box opacity_4"> <?php echo  $labelforHeading; ?> </div>
									<!--extract_heading_box-->
									<div class="extract_quota_box"> &nbsp; </div>
									<!--extract_quota_box-->
								  </div>
								</div>
								<?php
							}
						}
					}
		   ?>
		   <div class="clear"></div>
		   <div class="seprator_25 row"></div><!--from_element_wrapper-->
		</div>
    
      <!--tab_wp-->
      <!--row-->
      <div class="clear"></div>
      <!--form_wrapper toogle frm_strip_bg-->
      <div class="clear"></div>
      <div class="row"><div class="tab_shadow"></div></div>
    </div>
    
  
  <!--right_column-->
  <div class="clear"></div>
</div>
<?php
	// browser is IE Start
	if(isset($showForm) && $showForm=='dn' && $userBrowser == 'ie'){?>
		<script> toggleWithDelay("#updateFurtherDescriptionForm");</script>
		<?php 
	}
   // browser is IE END
?>

<script>
	
	function changeFurtherDescriptionFormValue(data){ 	
		var section='<?php echo $browseId;?>';
		var poijSection='<?php echo $browseProjectId;?>';
		$('label.error').remove();
		$('input.error').each(function(index){
				var inputClass =$(this).attr('class').replace('error', '');
				$(this).attr('class',inputClass);
		});
		
		if((data.description==null || data.description=='') && (data.tags==null || data.tags=='') && (data.productionCompany==null || data.productionCompany=='')){
			$("#copyProjectData").show();
			$('#fileInput'+section).attr('class','width480px formTip');
		}else{
			$("#copyProjectData").hide();
			$('#fileInput'+section).attr('class','width480px formTip');
		}
		
		if(!$('#updateFurtherDescriptionForm').is(":visible")){
			$("#updateFurtherDescriptionForm").slideToggle('slow');
		}
		
		var urlCreativeinvolved = baseUrl+language+'/creativeinvolved/associativeCreatives';
		AJAX(urlCreativeinvolved,'productionTeamDiv',data.elementId,data.entityId,'<?php echo $this->lang->line('mediaProductionTeam');?>');
		
		if($('#title'+section) )
			$('#title'+section).val(data.title);
			
		if($('#fileLength'+section) )
			$('#fileLength'+section).val(data.fileLength);
			
		if($('#imgSrc'+section) ){
			$('#imgSrc'+section).val(data.imgSrc);
			$('#img'+section).attr('src',data.imgSrc);
		}
			
		if($('#tags'+section))
			$('#tags'+section).val(data.tags);
		if($('#description'+section))
			$('#description'+section).val(data.description);
		if($('#productionCompany'+section))
			$('#productionCompany'+section).val(data.productionCompany);
		
		if($('#elementId')){
			$('#elementId').val(data.elementId);
			
		if($('#fileInput'+section)){
			$('#fileInput'+section).val('');
		}
			
		if($('#fileName'+section))
			$('#fileName'+section).val(data.fileName);
			
			
		}
	}
	
	function copyProjectInformationIntoelement(projectid,projectEntityId,elementEntityId){
		var section='<?php echo $browseId;?>';
		var poijSection='<?php echo $browseProjectId;?>';
			var indusrty ='<?php echo $indusrty;?>';
			var elemetTable = '<?php echo $elementTbl;?>';
			var elementId = $('#elementId').val();
			var title = $('#title'+section).val();
			var fileLength = $('#fileLength'+section).val();
			var imgSrc = $('#imgSrc'+section).val();
			var divId='rowData'+elementId;
			var loadView = 'furtherElementDetails';
			var url = baseUrl+language+"/"+"common/copyProjectInformationIntoelement";
			var returnFlag=AJAX(url,divId,projectid,projectEntityId,elemetTable,elementId,elementEntityId,title,fileLength,imgSrc,loadView,'<?php echo $deleteCache;?>');
			if(returnFlag){		
				//$("#updateFurtherDescriptionForm").slideToggle('slow');
				$('#messageSuccessError').html('<div class="successMsg">You have successfully updated project further description.</div>');
				timeout = setTimeout(hideDiv, 5000);
				var imgSrcProj = ((indusrty == 'photographyNart' )? imgSrc : '<?php echo $projectImage?>');
				//var imgSrcProj = '<?php echo $projectImage;?>';
				var rawFileName = $('#fileInput'+poijSection).val();
				var tags = '<?php echo  @$LID->projTag;?>';
				var description = $('#projDescription'+poijSection).val();
				var productionCompany = $('#productionHouse'+poijSection).val();
				
				var Updatedata = {"entityId":'<?php echo @$entityId;?>',"title":title,"fileLength":fileLength,"imgSrc":imgSrcProj,"rawFileName":rawFileName,"tags":tags,"description":description,"productionCompany":productionCompany,"elementId":elementId}; 
				changeFurtherDescriptionFormValue(Updatedata);
				
				/*setTimeout( function() {
					changeFurtherDescriptionFormValue(Updatedata);
				}, 500 );*/
			}
	
	}
	
		

	$(document).ready(function(){
		var section='<?php echo $browseId;?>';
		var poijSection='<?php echo $browseProjectId;?>';
		$(".ajaxCancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			console.log(toggleDivForm);
			var toggleDivFormID = $(this).closest("form").attr('id');
			$('#'+toggleDivFormID)[0].reset();
			$("#"+toggleDivForm).slideToggle('slow');
		});
		
		$("#FDEF").validate({
			submitHandler: function() {
			
				var elementId = $('#elementId').val();
				if(elementId > 0){
					var elemetTable = '<?php echo $elementTbl;?>';
					var elementFieldId = '<?php echo $elementFieldId;?>';
					var imageField = 'imagePath';
					var title = $('#title'+section).val();
					var fileLength = $('#fileLength'+section).val();
					var imgSrc = $('#imgSrc'+section).val();
					
					var tags = $('#tags'+section).val();
					var description = $('#description'+section).val();
					var productionCompany = $('#productionCompany'+section).val();
					var rawFileName = ($('#fileInput'+section))?$('#fileInput'+section).val():'';
					var imagePath = ($('#fileName'+section))?$('#fileName'+section).val():'';
					imagePath = '<?php echo $fileUploadPath?>'+imagePath;
					if(rawFileName){
						var isfile=rawFileName.lastIndexOf(".");
					}else{
						rawFileName= '';
						var isfile=0;
					}
					
					if(isfile > 0){
						var data = {"imagePath":imagePath,"rawFileName":rawFileName,"productionCompany":productionCompany,"tags":tags,"description":description}; 

					}else{
						var data = {"productionCompany":productionCompany,"tags":tags,"description":description}; 
					}
					var divId='rowData'+elementId;
					var loadView = 'furtherElementDetails';
					var url = baseUrl+language+"/"+"common/UpdateTable";
					
					if(tags.length>0 || description.length>0 || productionCompany.length>0 || rawFileName.length>0 ){
						AJAX(url,divId,data,elementId,elemetTable,elementFieldId,imgSrc,title,fileLength,imageField,loadView,'<?php echo $deleteCache;?>');
						
						var updateData={"projLastModifyDate":'<?php echo date('Y-m-d h:i:s');?>'};
						var where={"projId":$('#projectid').val()};
						var returnFlag=AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'Project',where,'');
						if(returnFlag){
							$("#uploadFileByJquery"+section).click();
							if(isfile==0){
								$("#updateFurtherDescriptionForm").slideToggle('slow');
							}
							$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
							timeout = setTimeout(hideDiv, 5000);
						}
							
						
					}else{
						alert("<?php echo $this->lang->line('fillAtleastOneInfo')?>");
						return false;
					}
				}else{
						alert('record not updated');
				}
			 }
		});
		
		$("#FDF").validate({
			submitHandler: function() {
				
				
				var projId = $('#projectid').val();
			
				if(projId > 0){
					var elemetTable = 'Project';
					var elementFieldId = 'projId';
					var imageFieldProj = 'projBaseImgPath';
					var imgSrcProj = '<?php echo $projectImage;?>';
					var projDescription = $('#projDescription'+poijSection).val();
					var productionHouseProj = $('#productionHouse'+poijSection).val();
					var projRating = $('#projRating').val();
					var rawFileNameProj = $('#fileInput'+poijSection).val();
					var projBaseImgPath = $('#fileName'+poijSection).val();
					projBaseImgPath = '<?php echo $fileUploadPath?>'+projBaseImgPath;
					var isfile=rawFileNameProj.lastIndexOf(".");
					var elementEntityId = '<?php echo $entityId?>';
					
					if(isfile > 0){
						var data = {"projBaseImgPath":projBaseImgPath,"rawFileName":rawFileNameProj,"productionHouse":productionHouseProj,"projDescription":projDescription,"projRating":projRating,"elementEntityId":elementEntityId}; 
					}else{
						var data = {"productionHouse":productionHouseProj,"projDescription":projDescription,"projRating":projRating,"elementEntityId":elementEntityId}; 
					}
					//var divId='image'+poijSection;
					var divId ='';
					var loadView = 'reloadImage';
					var url = baseUrl+language+"/"+"common/UpdateTable";
					var SMreturnFlag=false;
						
						var returnFlag=AJAX(url,divId,data,projId,elemetTable,elementFieldId,imgSrcProj,'','',imageFieldProj,loadView,'<?php echo $deleteCache;?>');
						if(returnFlag){
							$("#uploadFileByJquery"+poijSection).click();
							var isUpdatedSupportingMedia = $('#isUpdatedSupportingMedia').val();
							if(isUpdatedSupportingMedia==1){	
								var dataSupportingMediaFlag=false;
								var entityid_to = '<?php echo $entityId;?>';
								var elementid_to = '<?php echo $projectId;?>';
								
								
								var linkToScriptentityid_from = $('#linkToScriptentityid_from').val();
								var linkToScriptelementid_from = $('#linkToScriptelementid_from').val();
								
								if(linkToScriptentityid_from > 0 && linkToScriptelementid_from > 0){
									var dataSupportingMediaFlag=true;
									var linkToScript = {"entityid_to":entityid_to,"elementid_to":elementid_to,"entityid_from":linkToScriptentityid_from,"elementid_from":linkToScriptelementid_from,"order":"1"};
								}else{
									var linkToScript = 0;
								}
								
								var linkToSoundtrackentityid_from = $('#linkToSoundtrackentityid_from').val(); 
								var linkToSoundtrackelementid_from = $('#linkToSoundtrackelementid_from').val();
								
								if(linkToSoundtrackentityid_from > 0 && linkToSoundtrackelementid_from > 0){
									var dataSupportingMediaFlag=true;
									var linkToSoundtrack = {"entityid_to":entityid_to,"elementid_to":elementid_to,"entityid_from":linkToSoundtrackentityid_from,"elementid_from":linkToSoundtrackelementid_from,"order":"2"};
								}else{
									var linkToSoundtrack = 0;
								}
								
								var linkToPosterentityid_from = $('#linkToPosterentityid_from').val(); 
								var linkToPosterelementid_from = $('#linkToPosterelementid_from').val();
								
								if(linkToPosterentityid_from > 0 && linkToPosterelementid_from > 0){
									var dataSupportingMediaFlag=true;
									var linkToPoster = {"entityid_to":entityid_to,"elementid_to":elementid_to,"entityid_from":linkToPosterentityid_from,"elementid_from":linkToPosterelementid_from,"order":"3"};
								}else{
									var linkToPoster = 0;
								}
								
								if(dataSupportingMediaFlag){
									var dataSupportingMedia = {0:linkToScript,1:linkToSoundtrack,2:linkToPoster};
									SMreturnFlag=AJAX(baseUrl+language+"/"+"/media/suportLinksAdd","",dataSupportingMedia);
								}
							}
							
							var updateData={"projLastModifyDate":'<?php echo date('Y-m-d h:i:s');?>'};
							var where={"projId":$('#projectid').val()};
							AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'Project',where,'');
							
							if($('#elementTab').attr('class') != 'row'){
								$('#elementTab').attr('class','row');
								$('#elementToggelDiv').attr('toggleDivId','FDES');
							}
							
							$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
							timeout = setTimeout(hideDiv, 5000);
							
							if(SMreturnFlag){
								timeout = setTimeout(refreshPge, 500);
							}
						}
						
					
				}else{
						alert('record not updated');
				}
			 }
		});
	});
	
</script>
