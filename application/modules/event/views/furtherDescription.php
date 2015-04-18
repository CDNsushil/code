<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$thumbFolder='thumb';
	$containerSize=(isset($FD->containerSize) && is_numeric($FD->containerSize))?$FD->containerSize:$this->config->item('defaultContainerSize');
	
	$dirname=$dirUploadMedia;
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
	
	$imagetype=$this->config->item('defaultEventImg_s');
	
	$eventImage='';
	
	if(($FD->isExternal !='t') && !empty($FD->fileName) && !empty($FD->filePath)){
		$filePath=trim($FD->filePath);
		$fileName=trim($FD->fileName);
		if(is_dir($filePath) && $fileName !=''){
			$fpLen=strlen($filePath);
			if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
				$filePath=$filePath.DIRECTORY_SEPARATOR;
			}
			$eventImage=$filePath.$fileName;
			$eventImage= addThumbFolder($eventImage,'_s');
		}
	}
	
	$eventImage=getImage($eventImage,$imagetype);
	
	$defaultposter=$this->config->item('defaultposter');
	$posterImage='';
	if(($FD->posterImage != null) && !empty($FD->posterImage)){
		$posterImage=$FD->posterImage;
	}

	$posterImage=getImage($posterImage,$defaultposter);
	
	$browseId1='_coverImage';
	$browseId2='_posterImage';
	
	$formAttributes = array(
		'name'=>'form'.$browseId2,
		'id'=>'form'.$browseId2,
		'toggleDivForm'=>'FDS'
	);
	
	
	
	$browseId1stInput = array(
		'name'	=> 'browseId1st',
		'value'	=> $browseId1,
		'id'	=> 'browseId1st',
		'type'	=> 'hidden'
	);	

	$browseId2ndInput = array(
		'name'	=> 'browseId2nd',
		'value'	=> $browseId2,
		'id'	=> 'browseId2nd',
		'type'	=> 'hidden'
	);
	
	$eventOrLaunchIdInput = array(
		'name'	=> 'eventOrLaunchId',
		'id'	=> 'eventOrLaunchId',
		'type'	=> 'hidden',
		'value'	=> $eventOrLaunchId
	);
	$eventTypeInput = array(
		'name'	=> 'eventType',
		'id'	=> 'eventType',
		'type'	=> 'hidden',
		'value'	=> $eventType
	);
?> 

<div class="row form_wrapper">
   <div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('furtherDescription');?></h1>
		</div>
		<?php 
			$navArray['NatureId'] = $FD->NatureId;
			$navArray['EventId'] = (isset($FD->EventId) && is_numeric($FD->EventId) )?$FD->EventId:0;
			$navArray['LaunchEventId'] = (isset($FD->LaunchEventId) && is_numeric($FD->LaunchEventId) )?$FD->LaunchEventId:0;
			$navArray['currentMathod'] = $currentMathod;
			$navArray['eventOrLaunchId'] = $eventOrLaunchId;
			echo Modules::run("event/menuNavigation",$navArray);
		?> 
	</div>
    <div class="row tab_wp ">
      <div class="row ">
        <div class="cell tab_left">
          <div class="tab_heading"><?php echo $this->lang->line('furtherDescription');?></div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
          <span class="according_heading"><?php echo $FD->Title; ?></span>
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      <div class="form_wrapper toggle frm_strip_bg" id="FDS" >
		  <div class="row"><div class="tab_shadow"></div></div>
			
				<?php 
				echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
					echo form_input($eventOrLaunchIdInput);
					echo form_input($eventTypeInput);
					?>
					<div id="upload2ndFileDiv">
						<?php
							echo form_input($browseId1stInput);
							echo form_input($browseId2ndInput);
						?>
					</div>
					<?php
					
					$img='<img src="'.$eventImage.'" />';
					
					$imgRequired='';
					$inputArray = array(
						'name'	=> 'fileInput'.$browseId1,
						'class'	=> 'mt9 ',
						'value'	=> '',
						'id'	=> 'fileInput'.$browseId1,
						'type'	=> 'text',
						'readonly' => true
					);
					$data=array('fileType'=>$this->config->item('imageAccept'),'fileMaxSize'=>$this->config->item('imagemaxSize'),'fileUploadPath'=>$dirUploadMedia,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('coverImage'),'browseId'=>$browseId1);
					
					echo '<div class="row" id="FileContainer'.$browseId1.'"></div>';
					$this->load->view("common/uploadMultipleImageForm",$data);
					
					$img='<img src="'.$posterImage.'" />';
					
					$imgRequired='';
					$inputArray = array(
						'name'	=> 'fileInput'.$browseId2,
						'class'	=> 'mt9 ',
						'value'	=> '',
						'id'	=> 'fileInput'.$browseId2,
						'type'	=> 'text',
						'readonly' => true
					);
					$data=array('fileType'=>$this->config->item('imageAccept'),'fileMaxSize'=>$this->config->item('imagemaxSize'),'fileUploadPath'=>$dirUploadMedia,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('posterImage'),'browseId'=>$browseId2,'infoMsg'=>$this->lang->line('posterImageInfo'));
					
					echo '<div class="row" id="FileContainer'.$browseId2.'"></div>';
					$this->load->view("common/uploadMultipleImageForm",$data);
					
				
				    $wordOption = array('minVal'=>'0','maxVal'=>'600');
					$value=$FD->Description;
					$value=htmlentities($value);
					$data=array('name'=>'Description','id'=>'Description','value'=>$value,'required'=>'', 'labelText'=>$this->lang->line('furtherDescription'), 'view'=>'description', 'descLimit'=>'descLimit','wordOption'=>$wordOption);
					echo Modules::run("common/formInputField",$data);
				?>
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('eventRating');?></label></div>
					<div class="cell frm_element_wrapper" >
						<div class="formTip fl" title="<?php echo $this->lang->line('ratingMsg');?>"><?php 
							$Rating=$FD->Rating;
							$RatingList = getRatingList(1,lang(),'selectRating');
							echo form_dropdown('Rating', $RatingList, $Rating,'id="Rating" class="required"');
						?>
						</div>
						<div class="row wordcounter">
							<span class="tag_word_orange"><?php echo $this->lang->line('adultsMaterialNotAllowed');?></span>
						</div>
					</div>
				</div>
				         
				<div class="row">
					<div class="label_wrapper cell"><div class="lable_heading"><h1 class="formTip" title="<?php echo $this->lang->line('supportingMaterialToolTip');?>"><?php echo $this->lang->line('supportingMedia');?></h1></div></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper"></div>
				</div><!--from_element_wrapper-->
				
				<input id="isUpdatedSupportingMedia" name="isUpdatedSupportingMedia" type="hidden" value="0">
				
					<div class="row">
						<div class="label_wrapper cell">
							<label><?php echo $this->lang->line('linkToScript');?></label>
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
								<input id="linkToScriptentityid_from" name="linkToScriptentityid_from" type="hidden" value="<?php echo isset($suportLinks[1]['entityid_from'])?$suportLinks[1]['entityid_from']:0;?>">
								<input id="linkToScriptelementid_from" name="linkToScriptelementid_from" type="hidden" value="<?php echo isset($suportLinks[1]['elementid_from'])?$suportLinks[1]['elementid_from']:0;?>">
							</div>
						</div>
					</div><!--from_element_wrapper-->
					
					<div class="row">
						<div class="label_wrapper cell">
							<label ><?php echo $this->lang->line('linkToSoundtrack');?></label>
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
								<input id="linkToSoundtrackentityid_from" name="linkToSoundtrackentityid_from" type="hidden" value="<?php echo isset($suportLinks[2]['entityid_from'])?$suportLinks[2]['entityid_from']:0;?>">
								<input id="linkToSoundtrackelementid_from" name="linkToSoundtrackelementid_from" type="hidden" value="<?php echo isset($suportLinks[2]['elementid_from'])?$suportLinks[2]['elementid_from']:0;?>">
							</div>
						</div>
					</div><!--from_element_wrapper-->
					
					<div class="row">
						<div class="label_wrapper cell">
							<label><?php echo $this->lang->line('linkToPoster');?></label>
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
								<input id="linkToPosterentityid_from" name="linkToPosterentityid_from" type="hidden" value="<?php echo isset($suportLinks[3]['entityid_from'])?$suportLinks[3]['entityid_from']:0;?>">
								<input id="linkToPosterelementid_from" name="linkToPosterelementid_from" type="hidden" value="<?php echo isset($suportLinks[3]['elementid_from'])?$suportLinks[3]['elementid_from']:0;?>">
							</div>
						</div>
					
					
					</div><!--from_element_wrapper-->
					
                <div class="seprator_10 clear"></div>            
				<div class="row">
				  <div class="label_wrapper cell bg-non"> </div>
				  <!--label_wrapper-->
				  <div class=" cell frm_element_wrapper pt15">
						<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?> </div>
						<div class="fr padding-right0 ">
							 <div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="button" id="saveButton_FD" onclick="FDcheckSubmit();"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
						</div>
						<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div></div>
					  <div class="seprator_25 clear"></div>
					  
				  </div>
			
					
			</div>
		  <?php echo form_close(); ?>
		  
		  <?php
				echo Modules::run("creativeinvolved/associativeCreatives",$eventOrLaunchId,$entityId,$this->lang->line('keyPersonnel')); 
		  ?>
		  
				 <div class="row seprator_25"></div>
      <div class="clear"></div>
      
    </div>
    
    
    <div class="row"><div class="tab_shadow"></div></div>
  </div>
  <!--right_column-->
  <div class="clear"></div>
</div>
<input type="hidden" name="totalFileToupload" id="totalFileToupload" value="0" />
<script>
	function FDcheckSubmit(){
		
		var fileName2 =  $("#fileName<?php echo $browseId2?>").val();
		if(fileName2 == undefined){
			fileName2 = '';
		}
		
		if(fileName2.length >= 4){
			$("#uploadFileByJquery<?php echo $browseId2?>").click();
		}else{
			var fileError1 = $("#fileError<?php echo $browseId1?>").html();
			if(fileError1 == undefined){
				fileError1 = '';
			}
			fileError1=$.trim(fileError1);
			var fileError2 = $("#fileError<?php echo $browseId2?>").html();
			if(fileError2 == undefined){
				fileError2 = '';
			}
			fileError2=$.trim(fileError2);
			
			if(fileError1 !='' || fileError2 !=''){
				return false;
			}else{
				$('#form<?php echo $browseId2;?>').submit();
			}
		}
	}
	
	$(document).ready(function(){
		$('#form<?php echo $browseId2;?>').validate({
			submitHandler: function() {
				var fromData=$("#form<?php echo $browseId2;?>").serialize();
				var url = baseUrl+language+'/event/saveFurthrtDescription';
				$.post(url,fromData, function(data) {
				  if(data){
					/*if(data.uploadedFile && data.uploadedFile > 0){
					  $("#totalFileToupload").val(data.uploadedFile);
					}*/
					
					$("#uploadFileByJquery<?php echo $browseId1?>").click();
					
					var fileName1 =  $("#fileName<?php echo $browseId1?>").val();
					if(fileName1 == undefined){
						fileName1 = '';
					}
					var fileName2 =  $("#fileName<?php echo $browseId2?>").val();
					if(fileName2 == undefined){
						fileName2 = '';
					}
					if(fileName1.length < 4 && fileName2.length < 4){
						refreshPge();
					}else{
							$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
							timeout = setTimeout(hideDiv, 5000);
					}
				  }
				},"json");
			}
		});
	});
</script>
