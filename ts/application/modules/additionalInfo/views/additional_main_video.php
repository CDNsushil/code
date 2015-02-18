<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$showcaseDataFlag=false;
$mediaDataFlag=false;
$convsrsionFlag=false;
$showForm='dn';
$containerSize=$remainingBytes = $this->config->item('defaultContainerSize');
if($showcaseData){
	$showcaseDataFlag=true;
	$showcaseData=$showcaseData[0];
	
	if(isset($showcaseData->userContainerId) && $showcaseData->userContainerId > 0){
		$res=getDataFromTabel('UserContainer', 'containerSize',  $whereField=array('userContainerId'=>$showcaseData->userContainerId), '', '', '', 1 );
		if($res){
			$containerSize=$res[0]->containerSize;
		}
	}
	$dirname=$dirUploadMedia;
	$dirSize=getFolderSize($dirname);
	$remainingBytes =($containerSize - $dirSize);
	if(!$remainingBytes > 0){
		$remainingBytes =0;
	}
	
	$containerSize=bytestoMB($containerSize,'mb');
	$dirSize=bytestoMB($dirSize,'mb');
	$remainingSize=($containerSize-$dirSize);
	if($remainingSize < 0){
			$remaining = 0;
	}
	$dirSize = number_format($dirSize,2,'.','');
	$remainingSize = number_format($remainingSize,2,'.','');
	
	$showcaseId=$showcaseData->showcaseId;
	$tdsUid=$showcaseData->tdsUid;
	$interviewFileId=$showcaseData->interviewFileId;
	if($interviewFileId > 0){
		$mediaFile=getDataFromTabel($table='MediaFile', $field='*',  $whereField=array('fileId'=>$interviewFileId), '', $orderBy='', $order='', $limit=1 );
		if($mediaFile){
			$mediaDataFlag=true;
			$required='';
			
			$interviewFileId=$showcaseData->interviewFileId;
			$interviewTitle=$showcaseData->interviewTitle;
			$interviewDescription=$showcaseData->interviewDescription;
			
			$mediaFile=$mediaFile[0];
			$fileId=$mediaFile->fileId;
			$filePath=$mediaFile->filePath;
			$fileName=$mediaFile->fileName;
			$rawFileName=$mediaFile->rawFileName;
			$fileSize=$mediaFile->fileSize;
			$isExternal=$mediaFile->isExternal;
			
			if($isExternal=='t'){
				$fileType='external';
				$embedCode=$filePath;
				$file=urlencode($embedCode);
				$fileDirPath='';
				
			}else{
				$fileType=2;
				$fileDirPath=$file=$filePath.$fileName;
				$embedCode='';
			}
			
			/*$fileLength=;
			$fileType=;
			$fileCreateDate=;
			$tdsUid=;*/
			$entityId= getMasterTableRecord('UserShowcase');
			// mediaId/entityId/projectId/elementId
			$imgInterviewSrc = '<img class="formTip ptr maxWH30 ma"  src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonVideo\',\''.$fileId.'\',\''.$entityId.'\',\''.$showcaseId.'\',\''.$showcaseId.'\');" />';
			$opacity_4="";
			
			$convsrsionFileType=$this->config->item('convsrsionFileType');
			if($mediaFile->isExternal=='f' && in_array($mediaFile->fileType,$convsrsionFileType)){
				$convsrsionFlag=true;
				if($mediaFile->jobStsatus == 'DONE'){
					$conversionStatusClass='icon_filesent';
					$conversionStatusToolTip=$this->lang->line('Converted');
				}elseif($mediaFile->jobStsatus == 'FAILS'){
					$conversionStatusClass='icon_filetransfer';
					$conversionStatusToolTip=$this->lang->line('conversionFailed');
				}else{
					$conversionStatusClass='icon_inprocess';
					$conversionStatusToolTip=$this->lang->line('converting');
				}
			}
		}
	}
}

if(!$showcaseDataFlag){
		$showcaseId=$tdsUid=0;
}
if(!$mediaDataFlag){
		$required='required';
		$interviewTitle= $this->lang->line('addInterviewVideo');
		$fileId=$interviewFileId=$fileSize=0;
		$isExternal='f';
		$fileType=2;
		$interviewDescription=$rawFileName=$fileName=$filePath=$file=$embedCode=$fileDirPath='';
		$filePath=$folderPath;
		$imgInterviewSrc = '<img class="formTip ptr maxWH30 ma ui-state-disabled" src="'.base_url().'images/stockphoto_FnV.jpg" />';
		$opacity_4="opacity_4";
}

$jsonData=array(
	'interviewTitle'=>$showcaseData->interviewTitle,
	'interviewDescription'=>$interviewDescription,
	'fileId'=>$fileId,
	'fileName'=>$fileName,
	'rawFileName'=>$rawFileName,
	'fileSize'=>$fileSize,
	'isExternal'=>$isExternal,
	'embedCode'=>$embedCode
);
$jsonData=json_encode($jsonData);

$formAttributes = array(
	'name'=>'uploadmediaForm'.$browseId,
	'id'=>'uploadmediaForm'.$browseId,
	'toggleDivForm'=>'uploadElementForm'.$browseId
);

$interviewTitleInput = array(
		'name'	=> 'interviewTitle',
		'id'	=> 'interviewTitle'.$browseId,	
		'class'	=> 'width546px required',
		'value'	=> $showcaseData->interviewTitle,
		'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50
);

$fileIdAttr = array(
	'name'	=> 'fileId',
	'id'	=> 'fileId'.$browseId,
	'type'	=> 'hidden',
	'value'	=> $fileId
);

$rawFileNameInput = array(
	'name'	=> 'rawFileName',
	'id'	=> 'rawFileName'.$browseId,
	'type'	=> 'hidden',
	'value'	=> $rawFileName
);
$showFormIE=$showForm='dn';
$userBrowser = get_user_browser();
if($userBrowser == 'ie'){
	$showFormIE='';
}
?>
<script>
	 var data<?php echo $browseId;?> = <?php echo $jsonData;?>;
</script>
<div class="row form_wrapper">
     <div class="row tab_wp">
		<div class="row ">
			<div class="cell tab_left">
			  <div class="tab_heading"> <?php echo $this->lang->line('interview');?> </div>
			  <!--tab_heading-->
			</div>
			<div class="cell tab_right"> <span class="according_heading">&nbsp;</span>
			  <div class="tab_btn_wrapper">
				<div class="tds-button-top"><a><span><div class="projectToggleIcon toggle_icon" toggleDivId="uploadElement<?php echo $browseId;?>"></div></span></a></div>
			  </div>
			</div>
		</div><!--row-->
		<div class="clear"></div>
		
		<div class="form_wrapper toggle frm_strip_bg">
			<div id="uploadElement<?php echo $browseId;?>">
				<div class="row">
				  <div class="tab_shadow"> </div>
				</div>
				
				<div id="FileContainer<?php echo $browseId;?>" class="fr">
					<div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
						<div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
							<div class="progressBar_msg fl"><?php echo $this->lang->line('pleaseWait');?></div>
							<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div>
						</div>
					</div>
					<span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span></div>
					<div id="dropArea<?php echo $browseId;?>"></div>
				</div>
				
				<div id="uploadElementForm<?php echo $browseId;?>" class="<?php echo $showFormIE;?>">
						<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
						<div class="upload_media_left_box">
							<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); ?>
							
								  <div class="row">
									<div class="label_wrapper cell">
									  <label class="select_field"><?php echo $this->lang->line('title');?></label>
									</div>
									<!--label_wrapper-->
									<div class=" cell frm_element_wrapper">
									  <?php echo form_input($interviewTitleInput); ?>
										<div class="row wordcounter"><?php echo form_error($interviewTitleInput['name']); ?></div>
									</div>
								  </div>
								  
								 <?php 
									$interviewDescription=htmlentities($interviewDescription);
									$data=array('name'=>'interviewDescription'.$browseId,'id'=>'interviewDescription'.$browseId,'value'=>$interviewDescription, 'addclass'=>'width546px rz', 'required'=>'', 'labelText'=>'description', 'view'=>'description', 'descLimit'=>'descLimit'.$browseId);
									echo Modules::run("common/formInputField",$data);
								 ?>
								  
								  <?php 
								  $required="required";
								  $FileData=array(
								  'fileType'=>$this->config->item('videoUploadAccept'),
								  'fileMaxSize'=>$remainingBytes,
								  'isEmbed'=>$isExternal,
								  'fileName'=>$fileName,
								  'fileSize'=>$fileSize,
								  'filePath'=>$folderPath,
								  'embedCode'=>$embedCode,
								  'class'=>'width480px '.$required,
								  'required'=>$required, 
								  'FieldHeading'=>$this->lang->line('video'),
								  'browseId'=>$browseId);
								  
								
								  
								$this->load->view('common/uploadShowcaseVideo',$FileData);
								
								//$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoUploadAccept'),'fileMaxSize'=>$remainingBytes,'isEmbed'=>$isExternal,'fileName'=>'','fileSize'=>0,'filePath'=>$folderPath,'embedCode'=>$embedCode, 'required'=>'required', 'label'=>$this->lang->line('video'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>0,'browseId'=>$browseId,'imgload'=>0,'norefresh'=>0, 'view'=>'upload_ws_frm');
								//echo Modules::run("common/formInputField",$data);
								  ?>
								 
								
								 <div class="row">
									<div class="label_wrapper cell bg-non">
										&nbsp;
									</div>
									<!--label_wrapper-->
									<div class="cell frm_element_wrapper">
										<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?> </div>
										<div>
											<?php
												echo form_input($fileIdAttr);
												echo form_input($rawFileNameInput);
											
												$button=array('ajaxSave', 'ajaxCancel','buttonId'=>$browseId);
												echo Modules::run("common/loadButtons",$button); 
											 ?>
										</div>
										<div class="fl pb10"><?php echo $label['afterReqMsg']?> </div>
									</div>
								</div>
							
							<?php echo form_close(); ?>
						</div>
						<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
						<!--upload_media_left_box-->
						<div class="seprator_25 clear"></div> 
				</div>	
				  <div class="row">
					  <div class="empty_label_wrapper cell">
						<label class=""></label>
					  </div>
					 
					 
					  <div id="rowData<?php echo $browseId;?>" class="pl cell frm_element_wrapper extract_content_bg">
						<div class="<?php echo $opacity_4;?>">
							<div class="extract_img_wp"> 
								<?php echo $imgInterviewSrc;?>
							</div>
							<div class="extract_heading_box"> <?php echo $interviewTitle;?> </div>
							<div class="clear"></div>
						</div>
						<div class="extract_button_box pa right0 top6">
						  <?php
							if($convsrsionFlag){ ?>
								<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
								<?php
							} 
							if($fileId > 0){ ?>
								<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $elemetTable;?>','<?php echo $elementFieldId;?>',<?php echo $showcaseId;?>,'','','','<?php echo $fileId;?>','<?php echo $fileDirPath;?>',0,'<?php echo $browseId;?>',1)"><div class="cat_smll_plus_icon"></div></a></div>
								<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="changeSCFileFormValue(data<?php echo $browseId;?>,'<?php echo $browseId;?>')" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
								<?php
							}else{ ?>
								<div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="changeSCFileFormValue(data<?php echo $browseId;?>,'<?php echo $browseId;?>')"><div class="cat_smll_add_icon"></div></a></div>
								<?php
							}
						  ?>
						</div>
					  </div>
				</div>
				<div class="seprator_25 clear row"></div>
			</div>
			
				 
			<div class="clear"></div>
		</div>
	</div>
</div>

<?php
// browser is IE Start
	if(isset($showForm) && $showForm=='dn' && $userBrowser == 'ie'){?>
		<script> toggleWithDelay("#uploadElementForm<?php echo $browseId;?>");</script>
		<?php 
	}
// browser is IE END
?>
<script>
	$(document).ready(function(){
		var section='<?php echo $browseId;?>';
		$('#uploadmediaForm'+section).validate({
			submitHandler: function() {
				var loadView = 'showcaseElementDetails';
				var isExternal = $('#isExternal'+section).val();
				var imgSrc = baseUrl+"images/stockphoto_FnV.jpg";
				var divId='rowData'+section;
				var elemetTable = '<?php echo $elemetTable;?>';
				var elementFieldId = '<?php echo $elementFieldId;?>';
				var elementId = '<?php echo $showcaseId;?>';
				var fileId = $('#fileId'+section).val();
				var rawFileName = $('#fileInput'+section).val();
				
				var data = {"interviewFileId":"<?php echo $interviewFileId;?>","interviewTitle":$('#interviewTitle'+section).val(),"interviewDescription":$('#interviewDescription'+section).val(),"dateModified":"<?php echo currntDateTime();?>"};
				
				if(isExternal=='t'){
					var fileData = {"filePath":$('#embedCode'+section).val(),"rawFileName":'',"fileName":'',"fileSize":0,"fileType":'2',"isExternal":'t',"fileCreateDate":"<?php echo currntDateTime(); ?>","tdsUid":<?php echo isLoginUser(); ?>}; 
				}else{
					var fileSize = $('#fileSize'+section).val();
					fileSize =parseInt(fileSize);
					var fileData = {"filePath":'<?php echo $folderPath; ?>',"rawFileName":rawFileName,"fileName":$('#fileName'+section).val(),"fileSize":fileSize,"fileType":"2","isExternal":'f',"fileCreateDate":'<?php echo currntDateTime(); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
				}
				
				var returnFlag=AJAX('<?php echo base_url(lang()."/common/UpdateMediaTable");?>',divId,fileData,data,fileId,elementId,elemetTable,elementFieldId,imgSrc,section,loadView,'');
				
				if(returnFlag){
					$("#uploadFileByJquery"+section).click();
					if(elementId > 0 || isExternal=='t'){
						$("#uploadElementForm"+section).slideToggle('slow');
					}
					$('#'+divId).removeClass('opacity_4');
				}
			 }
		});
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
	uploadMediaFiles('<?php echo $folderPath;?>','<?php echo $this->config->item('videoUploadAccept');?>','<?php echo $remainingBytes;?>','<?php echo $browseId;?>',1,1);
});
</script>

