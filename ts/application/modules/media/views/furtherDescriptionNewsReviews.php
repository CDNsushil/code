<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$containerSize=(isset($LID->containerSize) && is_numeric($LID->containerSize))?$LID->containerSize:$this->config->item('defaultContainerSize');
	$dirname=$dirUploadMedia.$industryType.'/'.$projectId.'/';
	$dirSize=getFolderSize($dirname);
	$remainingBytes =($containerSize - $dirSize);
	if(!$remainingBytes > 0){
		$remainingBytes =0;
	}
	$dirSize=bytestoMB($dirSize,'mb');
	
	$containerSize=bytestoMB($containerSize,'mb');
	
	
	$reminingSize=($containerSize-$dirSize);
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
	if($projectElement){
		$element=$projectElement[0];
		$showForm='';
		if($indusrty=='photographyNart'){
			$src=getImage($element->filePath.$element->fileName,$imagetype);
		}else{
			$src=getImage($element->imagePath,$imagetype);
		}
		$title=$element->title;
		$fileLength=$element->fileLength;
		$imgSrc=$src;
		$fileType=$element->fileType;
		$tags=$element->tags;
		$description=$element->description;
		$productionCompany=$element->productionCompany;
		$elementId=$element->elementId;
		if($description==null || empty($description)){
			$cpd='';
			//$imgReqired='required';
			$imgReqired='';
		}else{
			$cpd='dn';
			$imgReqired='';
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
	'minlength'	=> 2,
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

//$accordianHeading = ($indusrty=='news')?$this->lang->line('articleDescription'):$this->lang->line('reviewDescription');
//$listHeading = $this->lang->line('ProjectDescription');
$accordianHeading = ($indusrty=='news')?$this->lang->line('articleCoverPages'):$this->lang->line('reviewCoverPages');
$listHeading = $this->lang->line('projectCoverPages');
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
			'type'	=> 'checkbox',
			'value'	=> 't'
		);

		$PreviewStatus=$LID->projPreviewStatus=='t'?true:false;

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

		//$projectImage=getImage(@$LID->projBaseImgPath,$imagetype);
		
		if(isset($LID->isExternalImageURL) && $LID->isExternalImageURL=='t'){
			$projectImage=trim($LID->projBaseImgPath);
		}else{
			
			//----------make element default project image code start---------//
			if(!empty($LID->projBaseImgPath)){
				$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
				$projectImage = getImage($projThumbImage,$imagetype,1);
			}else{
				
				$getPojrectImage = getProjectElementImage($LID->projectid,$entityId);	
				if($getPojrectImage){
					$projThumbImage = $getPojrectImage;
				}else{
					$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
				}
				$projectImage = getImage($projThumbImage,$imagetype,1);
				
			}
			//----------make element default project image code start---------//
		}
		
		//echo "<pre>";
		//print_r($LID);
		//echo "</pre>"; die;
	?>
	
    <!--first div start-->
    
    <div class="row tab_wp pt2">
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
					$data=array('fileType'=>$this->config->item('imageAccept'),'fileMaxSize'=>$this->config->item('imagemaxSize'),'fileUploadPath'=>$fileUploadPath,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('coverImage'),'browseId'=>$browseProjectId,'view'=>'uploadMultipleImageForm');
					echo Modules::run("common/formInputField",$data);
				?>
				
				<div class="row">
					<div class="label_wrapper cell">
						<label ><?php echo $label['publisher'];?></label>
					</div><!--label_wrapper-->
					<div class="cell frm_element_wrapper">
						<?php echo form_input($productionHouse); ?>							
					</div>
				</div>
				<?php 
				
				    $wordOption = array('minVal'=>'0','maxVal'=>'600');
					$value=@$LID->projDescription;
					$value=htmlentities($value);
					$data=array('name'=>'projDescription'.$browseProjectId,'id'=>'projDescription'.$browseProjectId,'value'=>$value,'required'=>'', 'view'=>'description','descLimit'=>'descLimit'.$browseProjectId,'wordOption'=>$wordOption);
					echo Modules::run("common/formInputField",$data);
				?>
				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $label['project_rating'];?></label></div>
					<div class="cell frm_element_wrapper" >
						<div class="row">
						<?php 
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
							  <?php echo $label['previewFeatureMsg'];?>
							</div>
						</div>
					</div>
					<?
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
					  <div class="seprator_25 clear"></div>
				  </div>
			
					
			</div>
		  <?php echo form_close(); ?>
		  </div>
		  <?php
				//echo Modules::run("creativeinvolved/associativeCreatives",$LID->projectid,$projectEntityId,$this->lang->line('mediaProductionTeam')); 
		  ?>
		   
      <div class="clear"></div>
      
    </div>
    
    
    
  </div>
  
	<!--second div  start-->
	
	<div class="row tab_wp">
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
      <div class="form_wrapper toggle frm_strip_bg <?php echo $FDESshow;?>" id="FDES">
			<div class="row"><div class="tab_shadow"></div></div>
			<div id="updateFurtherDescriptionForm" class="<?php echo $showFormIE;?>">
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box" id="FileContainer<?php echo $browseId;?>">
					<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
						 <div id="copyProjectData" class="row <?php echo $cpd;?>">
							<div class="label_wrapper cell  bg-non">&nbsp;</div><!--label_wrapper-->
							<div class="cell frm_element_wrapper">
								<div class="tds-button" onclick="copyProjectInformationIntoelement(<?php echo $LID->projectid;?>,<?php echo $projectEntityId;?>,<?php echo $entityId;?>);"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0)"><span><?php echo $this->lang->line('copy');?></span></a> </div>
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
							
							
							$wordOption = array('minVal'=>'0','maxVal'=>'100');
							$data=array('fileType'=>$this->config->item('imageAccept'),'fileMaxSize'=>$remainingBytes,'fileUploadPath'=>$fileUploadPath,'inputArray'=>$inputArray,'imgSrc'=>$img,'required'=>'','label'=>$this->lang->line('image'),'browseId'=>$browseId,'view'=>'uploadMultipleImageForm','wordOption'=>$wordOption);
							echo Modules::run("common/formInputField",$data);
							
							
							
						?>
						<div class="row">
							<div class="label_wrapper cell">
								<label ><?php echo $label['publisher'];?></label>
							</div><!--label_wrapper-->
							<div class="cell frm_element_wrapper">
								<?php echo form_input($productionCompany); ?>							
							</div>
						</div>
						
						<?php 
							$value=$tags;
							$value=htmlentities($value);
							$data=array('name'=>'tags'.$browseId,'id'=>'tags'.$browseId,'value'=>$value,'required'=>'', 'labelText'=>'tags', 'view'=>'tag_words');
							echo Modules::run("common/formInputField",$data);
						?>
						
						<?php 
							$value=$description;
							$value=htmlentities($value);
							$data=array('name'=>'description'.$browseId,'id'=>'description'.$browseId,'value'=>$value,'required'=>'', 'labelText'=>'description', 'view'=>'description', 'descLimit'=>'descLimit'.$browseId);
							echo Modules::run("common/formInputField",$data);
						?>
						
						<?php 
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
							</div>
						</div>
						
					<?php echo form_close(); ?>
				
				<!--<div class="row" id="productionTeamDiv">
					<?php
						//echo Modules::run("creativeinvolved/associativeCreatives",$elementId,getMasterTableRecord($elementTbl),$this->lang->line('mediaProductionTeam')); 
					 ?>
				</div>-->
				
				</div>
				<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
				<div class="row seprator_25 clear"></div>
			</div> 


              <div class="row" id="furtherDescriptionList">	
                  
				 <?php $this->load->view('furtherDescriptionNewsList',$elements) ?>
					
			 </div>

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
	var section='<?php echo $browseId;?>';
	var poijSection='<?php echo $browseProjectId;?>';
	function changeFurtherDescriptionFormValue(data){ 	
		$('label.error').remove();
		$('input.error').each(function(index){
				var inputClass =$(this).attr('class').replace('error', '');
				$(this).attr('class',inputClass);
		});
		
		if((data.description==null || data.description=='') && (data.tags==null || data.tags=='') && (data.productionCompany==null || data.productionCompany=='')){
			$("#copyProjectData").show();
			$('#fileInput'+section).attr('class','width480px');
		}else{
			$("#copyProjectData").hide();
			$('#fileInput'+section).attr('class','width480px ');
		}
		
		if(!$('#updateFurtherDescriptionForm').is(":visible")){
			$("#updateFurtherDescriptionForm").slideToggle('slow');
		}
		
		//var urlCreativeinvolved = baseUrl+language+'/creativeinvolved/associativeCreatives';
		//AJAX(urlCreativeinvolved,'productionTeamDiv',data.elementId,data.entityId,'<?php echo $this->lang->line('mediaProductionTeam');?>');
		
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
		if(confirm('Are you realy want to copy information from Project Details below?')){
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
				
				var imgSrcProj = '<?php echo $projectImage;?>';
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
	
	}
	
	$(document).ready(function(){
		$(".ajaxCancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
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
					var rawFileName = $('#fileInput'+section).val();
					var imagePath = $('#fileName'+section).val();
					imagePath = '<?php echo $fileUploadPath?>'+imagePath;
					var isfile=rawFileName.lastIndexOf(".");
					if(isfile > 0){
						var data = {"imagePath":imagePath,"rawFileName":rawFileName,"productionCompany":productionCompany,"tags":tags,"description":description}; 

					}else{
						var data = {"productionCompany":productionCompany,"tags":tags,"description":description}; 
					}
					var divId='rowData'+elementId;
					var loadView = 'furtherElementDetails';
					var url = baseUrl+language+"/"+"common/UpdateTable";
					if(tags.length>0 || description.length>0 || productionCompany.length>0 || rawFileName.length>0 ){

						var returnFlag=AJAX(url,divId,data,elementId,elemetTable,elementFieldId,imgSrc,title,fileLength,imageField,loadView,'<?php echo $deleteCache;?>');
						if(returnFlag){
							$("#uploadFileByJquery"+section).click();
							$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
							timeout = setTimeout(hideDiv, 5000);
							if(isfile==0){
								$("#updateFurtherDescriptionForm").slideToggle('slow');
							}
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
					var divId='';
					var loadView = 'reloadImage';
					var url = baseUrl+language+"/"+"common/UpdateTable";
					var returnFlag=AJAX(url,divId,data,projId,elemetTable,elementFieldId,imgSrcProj,'','',imageFieldProj,loadView,'<?php echo $deleteCache;?>');
					if(returnFlag){
						if($('#elementTab').attr('class') != 'row'){
							$('#elementTab').attr('class','row');
							$('#elementToggelDiv').attr('toggleDivId','FDES');
						}
						
						$("#uploadFileByJquery"+poijSection).click();
						$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
						timeout = setTimeout(hideDiv, 5000);
					}
				}else{
						alert('record not updated');
				}
			 }
		});
	});
	
	
</script>
