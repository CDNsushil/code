<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
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
	$lang=lang();
	$showForm=$elements?'dn':'';
//echo '<pre />';print_r($fileConfig);
	$imagetype=$fileConfig['defaultImage_s'];
	
	if(@$LID->isExternalImageURL=='t'){
		 $projectImage=trim(@$LID->projBaseImgPath);
	}else{
		
		/*$smallImg = addThumbFolder(@$LID->projBaseImgPath,'_s');
		$projectImage = getImage($smallImg,$imagetype);*/
		
		$getPojrectImage = getProjectElementImage($LID->projectid,$elemetEntityId);	
			
		if($getPojrectImage){
			$projThumbImage = $getPojrectImage;
		}else{
			$projThumbImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
		}
		$projectImage = getImage($projThumbImage,$imagetype,1);
			
		//$projectImage=getImage(@$LID->projBaseImgPath,$imagetype);
	}
	
	$required='required';
	$src=$projectImage;
	$fileTitle='';
	$article='';
	$articleSubject='';
	$isExternal='f';
	$fileName='';
	$fileType=$fileConfig['typeOfFile'];
	$fileSize=0;
	$embedCode='';
	$freeGenre='';
	$elementId=0;
	$fileId=0;
	$industryId=0;
	$genreId=0;
	$languageId=0;
	$wordCount='';
	$isWrittenFileExternal=0;
	$RFCD='dn';
	$rawFileName='';
	$editFlag=false;
	if($projectElement){
		$editFlag=true;
		$element=$projectElement[0];
				$showForm='';
				$required='';
				
				//$src=getImage($element->imagePath,$imagetype);
				$smallElementImg = addThumbFolder($element->imagePath,'_xxs');
				$src = getImage($smallElementImg,$imagetype);
				$isDefaultElement=$element->default;
				$isExternal=$element->isExternal=='t'?'t':'f';
				$isWrittenFileExternal=$element->isWrittenFileExternal;
				
				$embedCode=$isWrittenFileExternal==2?$element->filePath:'';
				
				$fileTitle=$element->title;
				$article=nl2br($element->article);
				$articleSubject=$element->articleSubject;
				$fileName=$element->fileName;
				$fileType=$element->fileType;
				$fileSize=$element->fileSize;
				$fileInput=$element->fileName;
				$embbededURL=$embedCode;
				$freeGenre=$element->freeGenre;
				$elementId=$element->elementId;
				$fileId=$element->fileId;
				$industryId=$element->industryId;
				$genreId=$element->genreId;
				$languageId=$element->languageId;
				$wordCount=$element->wordCount;
				$rawFileName=$element->rawFileName;
				if(strlen($fileName)>4){
					$RFCD='';
				}
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
		'minlength'	=> 2,
		'maxlength'	=> 50
	);
	$articleSubjectInput = array(
		'name'	=> 'articleSubject',
		'id'	=> 'articleSubject',	
		'class'	=> 'width250px required',
		'value'	=> $articleSubject,
		'minlength'	=> 2,
		'maxlength'	=> 50
	);
	$freeGenreInput = array(
		'name'	=> 'freeGenre',
		'id'	=> 'freeGenre',	
		'class'	=> 'width250px ml15',
		'value'	=> $freeGenre,
		'minlength'	=> 2,
		'maxlength'	=> 50,
		'placeholder'	=> $this->lang->line('genreFree'),
	);
	
	$wordCountInput = array(
		'name'	=> 'wordCount',
		'id'	=> 'wordCount',	
		'class'	=> 'width250px numberGreaterZero',
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
		'value'	=> $src
	);
	
	$ARS = array(
		'name'	=> 'availableRemainingSpace',
		'value'	=> $remainingBytes,
		'id'	=> 'availableRemainingSpace',
		'type'	=> 'hidden'
	);
	
	
	if(isset($industryType) && ($industryType=='reviews')) {
		
		 $artTitle        = $this->lang->line('reviewArticle');
		 $artSubject      = $this->lang->line('reviewSubject'); 
		 $sectionTitle    = $this->lang->line('reviewToolTip');
		 $langTitle       = $this->lang->line('reviewlangTtip');
		  
	  } else {		  
		$artTitle      = $this->lang->line('articlestitle');
		$artSubject    = $this->lang->line('articlesSubject');
		$sectionTitle  = $this->lang->line('newsToolTip');	 
		$langTitle     = $this->lang->line('newslangTtip');  
	 }
	
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
        <h1><?php echo $label['uploadsMediaTab'];?></h1>
      </div>
      <?php echo $header; ?>
    </div>
    
   <div class="row tab_wp pt2">
     	
		<!--first div header start-->
		<?php 
				$toggleDivId='uploadPriceDetails';
				$tabClass='';
		 ?> 
		 
		<div id="ProjectPriceDetails" class="row <?php echo $tabClass;?>">
			<div class="cell tab_left">
			  <div class="tab_heading "> <?php echo @$LID->bottomTitleBar; ?> </div>
			  <!--tab_heading-->
			</div>
			<div class="cell tab_right "> 
			<span class="according_heading"><?php echo @$LID->projName; ?></span>
			  <div class="tab_btn_wrapper">
				<div class="tds-button-top"> <a> <span><div id="projectToggelDiv" toggleDivId="<?php echo $toggleDivId;?>" class="projectToggleIcon toggle_icon"></div></span> </a> </div>
			  </div>
			  <div class=" according_heading mr20 fr"><?php echo $this->lang->line('used').' '.$dirSize.' '.$this->lang->line('mb');?>  &nbsp;
				 <?php echo $this->lang->line('free').' '.$remainingSize.' '.$this->lang->line('mb');?>
				</div>
			</div>
		  </div>
		
      <!--row-->
      <div class="clear"></div>
      <div class="form_wrapper toggle frm_strip_bg">
		  
		<!--first div start-->  
		
			<div id="uploadPriceDetails" class="form_wrapper toggle">
				<div class="row">
					<div class="tab_shadow"> </div>
				</div>
				<div class="clear"></div>
				<div class="row">
				  <div class="label_wrapper cell">
					<label><?php echo $this->lang->line('note');?></label>
				  </div>
				  <!--label_wrapper-->
				  <div class=" cell frm_element_wrapper">
					<div class="cell width320px free_media_screen"><?php echo $this->lang->line('freeMediaInformation');?></div>
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
				<div class="seprator_25 clear"></div>
		 </div>

			<!--second div header start-->
			<div class="row ">
				<div class="cell tab_left">
				  <div class="tab_heading"> <?php echo @$LID->topTitleBar; ?> </div>
				  <!--tab_heading-->
				</div>
				<div class="cell tab_right"> <span class="according_heading"><?php echo @$LID->projName; ?></span>
					<div class="tab_btn_wrapper">
							<div class="tds-button-top">
							<a class="formTip formToggleIcon" title="<?php echo $label['add'];?>" toggleDivId="uploadElement" toggleDivForm="uploadElementForm" toggleDivIcon="newsReviewsToggleIcon" cancelId="AjaxcancelButton"  >
							<span><div class="projectAddIcon"></div></span>
							</a>
							<a><span><div class="projectToggleIcon toggle_icon" id="newsReviewsToggleIcon" toggleDivId="uploadElement"></div></span></a>
							</div>
					  </div>
				</div>
			  </div>
			
			 <!--row-->
			<div class="clear"></div>
		  
			<!--second div start-->
		  
			<div id="uploadElement">
			<div class="row">
				<div class="tab_shadow"> </div>
			</div>    
			
			<div id="FileContainer" class="fr">
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
				<?php 
					
					echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
					echo form_input($ARS);
					
				?>
				  <div class="row">
						<div class="label_wrapper cell">
						  <label class="select_field"><?php echo $artTitle ;?></label>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper">
							<?php echo form_input($title); ?>
							<div class="row wordcounter"><?php echo form_error($title['name']); ?></div>
						</div>
					  </div>
					  <!--from_element_wrapper-->
					  
					  <div class="seprator_15 row"></div>
					  <div class="artical_sub_wp">
							<div class="artical_sub_top row">
							
							</div><!--artical_sub_top-->
							
							<div class="artical_sub_mid row">
						<div class="row ">
							<div class="label_wrapper cell">
							  <label class="select_field"><?php echo $artSubject ;?></label>
							</div>
							<!--label_wrapper-->
							<div class=" cell frm_element_wrapper pt3">
								
							  <div class="fl"><?php echo form_input($articleSubjectInput); ?></div>
							  <?php /*<div class="fl pt7 ml15"><?php echo $this->lang->line('selectOnToadsquare');?></div>*/?>
							  <div class="row wordcounter"><?php echo form_error($articleSubjectInput['name']); ?></div>
							  
							</div>
						  </div>
					 
					  <div class="row">
						<div class="label_wrapper cell">
						  <label class="select_field"><?php echo $this->lang->line('section');?></label>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper ">
							<div class="fl new_dd ml5">
								<?php 
									$industryList = getIndustryList(lang(),$isSection=1);
									echo form_dropdown('industryId', $industryList, $industryId,'id="industryId" class="required width266px ml2 formTip" title="'.$sectionTitle.'" onchange="getGenerList(\'GenreList\',\'\',this.value,\'genreId\');" ');
								?>
							</div>
						</div>
					  </div>
					 <?php 
					 /*
						<div class="row">
							<div class="label_wrapper cell">
							  <label class="select_field"><?php echo $this->lang->line('genre');?></label>
							</div>
							<!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="fl new_dd" id="GenreList">
									<?php 
								
										$genreList = getGenerList('',$industryId, $lang,'selectGenre');
										echo form_dropdown('genreId', $genreList, $genreId,'id="projGenre" class="required width266px" ');
									?>
								</div>
								<?php echo form_input($freeGenreInput); ?>
							</div>
						 </div>
							   				 
										 
							<div class="row">
									<div class="label_wrapper cell">
									  <label><?php echo $this->lang->line('originalLanguage');?></label>
									</div>
									<!--label_wrapper-->
									<div class=" cell frm_element_wrapper">
										<div class="fl new_dd ml5">
										<?php
											$language = getlanguageList();
											echo form_dropdown('languageId', $language, $languageId,'id="languageId" title="'.$langTitle.'" class="width266px ml2 formTip"');
										?>
										</div>
									</div>
							</div>
					*/ 
					?>	   <input type="hidden" name="languageId"  id="languageId" value="0">			  			 
							
							<div class="clear"></div>
						</div><!--artical_sub_mid-->
							
								<div class="artical_sub_bottom row"></div><!--artical_sub_mid-->
					  </div><!--artical_sub_wp-->
					  
					  <div class="row seprator_15"></div>
					  
					  <div class="row <?php echo $RFCD;?>" id="rawFileNameContainerDiv">
						<div class="label_wrapper cell">
						  <label><?php echo $this->lang->line('file');?></label>
						</div>
						<!--label_wrapper-->
						
						<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv">
							<?php echo $rawFileName;?>
						</div>
					 </div>
					 
					 <?php 
							$data=array('typeOfFile'=>$fileType,'fileType'=>$fileConfig['fileType'],'fileMaxSize'=>$remainingBytes,'isWrittenFileExternal'=>$isWrittenFileExternal,'fileName'=>$fileName,'fileSize'=>$fileSize,'filePath'=>$filePath,'embedCode'=>$embedCode, 'required'=>'required', 'label'=>$this->lang->line('file'),'article'=>$article,'editFlag'=>$editFlag, 'view'=>'uploadNewsReviesForm');
							echo Modules::run("common/formInputField",$data);
					?> 
					
					 <div class="row ">
						<div class="label_wrapper cell">
						  <label><?php echo $this->lang->line('wordCount');?></label>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper pt3 ">
						  <?php echo form_input($wordCountInput);?>
						  
						</div>
					 </div>
          
					   
					  <div class="row">
										<div class="label_wrapper cell bg-non">
											&nbsp;
										</div>
										<!--label_wrapper-->
										<div class="cell frm_element_wrapper">
											<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div>
											<div class="price_btn_position pr">
												<?php
													echo form_input($projectidInput);
													echo form_input($elementIdAttr);
													echo form_input($fileIdAttr);
													echo form_input($imgSrc);
													echo form_input($ARS);
													echo form_input($rawFileNameInput);
													
													$button = array('ajaxSave','ajaxCancel','buttonId'=>'');
													echo Modules::run("common/loadButtons",$button);
												 ?>
											</div>
											<div class="row">
												*&nbsp;<?php echo $this->lang->line('allReqFieldMsg');?><br>
												*&nbsp;<?php echo $this->lang->line('makeShowcaseBetterMsg');?><br>
												*&nbsp;<?php echo $this->lang->line('previewPublishInfo');?>
											</div>
										</div>
					 </div>
				<?php echo form_close(); ?>
				</div>
				<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
				 <div class="clear"></div> 
			</div>
			<div class="row height24">
				<div class="cell bg_none">
					&nbsp;
				</div>
				<div class="fr mr20 font_opensans">	
					<div class="fr orange f12 ">Publish from your <a href="<?php echo base_url('media/'.$indusrty.'/'.$projectId);?>" class="orgGreyonHover underline"><?php echo $this->lang->line($indusrty);?> Index page</a>.</div>
				</div>
			</div>
			
        
			<div class="row" id="UploadedData">
				<?php $this->load->view('newsReviewList',$elements) ?>
			</div>
			<div class="seprator_25"></div>
		</div>
		
		
      </div>
		<div class="row">
			<div class="tab_shadow"></div>
		</div>
    </div>

</div>
<?php
/* Upload first save media popup Start*/
	$isShowMediaPopup=$this->session->userdata('isShowMediaPopup');
	if($isShowMediaPopup && $isShowMediaPopup==1){
		$this->session->unset_userdata('isShowMediaPopup');
		$uploadData['industryType'] = $indusrty;
		$uploadData['projectId'] = $projectId;
		$popup_media = $this->load->view('afterSavePopup',$uploadData, true);
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
		<script> toggleWithDelay("#uploadElementForm");</script>
		<?php 
	}
// browser is IE END
?>

<script>
	$(document).ready(function(){
		$("#AjaxcancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			var toggleDivFormID = $(this).closest("form").attr('id');
			
			if('#elementId')
				$('#elementId').val(0);
			if('#fileId')
				$('#fileId').val(0);
				
			if('#imgSrc')
				$('#imgSrc').val('<?php echo $src;?>');
				
			if('#fileName')
				$('#fileName').val('');
			if('#fileType')
				$('#fileType').val('');
				
			if('#fileSize')
				$('#fileSize').val(0);
				
			if('#isWrittenFileExternal'){
				showSpecificSection('#writeArticleMenu',0);
			}
			
			if('#fileInput')
				$('#fileInput').attr('class','width480px required');
				
			
			if($('#fileTitle')){
				$('#fileTitle').val('');
			}
			if($('#articleSubject')){
				$('#articleSubject').val('');
			}
			if($('#industryId')){
				$('#industryId').val('');
				setSeletedValueOnDropDown('#industryId', '');
			}
			if($('#projGenre')){
				$('#projGenre').val('');
				setSeletedValueOnDropDown('#projGenre', '');
			}
			if($('#freeGenre')){
				$('#freeGenre').val('');
			}
			if($('#languageId')){
				$('#languageId').val('');
				setSeletedValueOnDropDown('#languageId', '');
			}
			if($('#article')){
				$('#article').val('');
			}
			if($('#wordCount')){
				$('#wordCount').val('');
			}
			
			if($('.nicEdit-main'))
			$('.nicEdit-main').html('');
			runTimeCheckBox();
			$('#rawFileNameContainerDiv').hide();
			$('#uploadNewsReviewsSection').show();
			$('#uploafFileButton').show();
			$('#embedButton').show();
			$('#writeButton').show();
			$('#writeArticle').show();
			$("#"+toggleDivForm).slideToggle('slow');
		});
		$("#uploadmediaForm").validate({
			 messages: {
				wordCount: "Please enter a number.",
				industryId: "<?php echo $this->lang->line('thisFieldIsReq');?>",
				//languageId: "<?php echo $this->lang->line('thisFieldIsReq');?>"
			},			
			submitHandler: function() {
				var loadView = 'newsReviewsFileDetails';
				var isWrittenFileExternal = $('#isWrittenFileExternal').val();
				var imgSrc = $('#imgSrc').val();
				var elemetTable = '<?php echo $elemetTable;?>';
				var elementFieldId = '<?php echo $elementFieldId;?>';
				var elementId = $('#elementId').val();
				var rawFileName = $('#fileInput').val();
				var wordCount = $('#wordCount').val();
				if(!wordCount > 0){
					wordCount=0;
				}
				var append = false;
				var fileId = $('#fileId').val();
				var isExternal='';
				var article='';
				
				var languageId = $('#languageId').val();
				languageId = parseInt(languageId);
				languageId = (languageId > 0)?languageId:0;
				
				var industryId = $('#industryId').val();
				industryId = parseInt(industryId);
				industryId = (industryId > 0)?industryId:0;
				
				
				if(isWrittenFileExternal==2){ //2: External Link
					isExternal='t';
					article='';
					if(elementId > 0){
						var fileData = {"fileName":'',"fileLength":$('#fileLength').val(),"fileSize":0,"fileType":'4',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
					}else{
						var fileData = {"rawFileName":rawFileName,"fileName":'',"fileLength":$('#fileLength').val(),"fileSize":0,"fileType":'4',"isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
					}
				}else if(isWrittenFileExternal==1){ //1: upload file
					isExternal='f';
					article='';
					if(elementId > 0){
						var fileData = {"filePath":'<?php echo $filePath; ?>',"fileName":$('#fileName').val(),"fileLength":$('#fileLength').val(),"fileSize":$('#fileSize').val(),"fileType":"4","fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
					}else{
						
						var fileSize = $('#fileSize').val();
						fileSize =parseInt(fileSize);
						var fileData = {"rawFileName":rawFileName,"filePath":'<?php echo $filePath; ?>',"fileName":$('#fileName').val(),"fileLength":$('#fileLength').val(),"fileSize":fileSize,"fileType":"4","isExternal":isExternal,"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
						var availableRemainingSpace = $('#availableRemainingSpace').val();
						availableRemainingSpace =parseInt(availableRemainingSpace);
						availableRemainingSpace =parseInt(availableRemainingSpace);
						availableRemainingSpace =(availableRemainingSpace-fileSize);
						if(!availableRemainingSpace > 0){
							availableRemainingSpace = 0;
						}
						$('#availableRemainingSpace').val(availableRemainingSpace);
					}
				}else{ 
					isExternal='f';
					article=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
					if(article.replace('<br>','')==''){
						$('#articleMsg').html(requiredMasg);
						return false;
					}else{
						$('#articleMsg').html('');
					}
					var fileData = false;
				}
				if(elementId > 0){
					var divId='rowData'+elementId;
					append = false;
					var action='<?php echo $this->lang->line('updated');?>';
					var data = {"projId":$('#projectid').val(),"title":$('#fileTitle').val(),"article":article,"articleSubject":$('#articleSubject').val(),"industryId":industryId,"genreId":$('#projGenre').val(),"freeGenre":$('#freeGenre').val(),"languageId":languageId,"wordCount":wordCount,"isWrittenFileExternal":isWrittenFileExternal,"modifyDate":"<?php echo date('Y-m-d h:i:s');?>"}; 
				}else{
					var divId='UploadedData';
					append = true;
					var action='<?php echo $this->lang->line('added');?>';
					var data = {"projId":$('#projectid').val(),"title":$('#fileTitle').val(),"article":article,"articleSubject":$('#articleSubject').val(),"industryId":industryId,"genreId":$('#projGenre').val(),"freeGenre":$('#freeGenre').val(),"languageId":languageId,"wordCount":wordCount,"isWrittenFileExternal":isWrittenFileExternal,"createdDate":"<?php echo date('Y-m-d h:i:s');?>","modifyDate":"<?php echo date('Y-m-d h:i:s');?>"}; 
				}
				var returnFlag=AJAX('<?php echo base_url(lang()."/common/UpdateMediaTable");?>',divId,fileData,data,fileId,elementId,elemetTable,elementFieldId,imgSrc,'f',loadView,'<?php echo $deleteCache;?>',append);
				if(returnFlag){
					if($("#noRecordFound")){
						$("#noRecordFound").hide();
					}
					var updateData={"projLastModifyDate":'<?php echo date('Y-m-d h:i:s');?>'};
					var where={"projId":$('#projectid').val()};
					AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'Project',where,'');
					
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> '+action+' <?php echo $indusrty;?>.</div>');
					timeout = setTimeout(hideDiv, 5000);
					$("#uploadFileByJquery").click();
					$("#uploadElementForm").slideToggle('slow');
					
					if(isExternal=='t' || elementId > 0 || isWrittenFileExternal!=2){
						refreshPge();
					}
				}
			 }
		});
	});
	
	
</script>
