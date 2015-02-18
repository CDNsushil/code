<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionMediaLimit = $this->config->item('competitionMediaLimit');
$browseId='_cm';
$formAttributes = array(
	'name'=>'advertMediaForm',
	'id'=>'advertMediaForm'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'advertTitle',
	'class'	=> 'required width556px',
	'value'	=> '',	
);
$browseIdInput = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);

$advertsTypeUpload = array(
	'name'	=> 'advertsType',
	'id'	=> 'advertsTypeUpload',
	'value'	=> 'upload',
	'class'	=> 'advertstype',
	'checked'=>false
);
$advertsTypeCreate = array(
	'name'	=> 'advertsType',
	'id'	=> 'advertsTypeCreate',
	'value'	=> 'create',
	'class'	=> 'advertstype'
);

$upAdvertUrl = array(
	'name'	=> 'url',
	'id'	=> 'url',
	'class'	=> 'width556px',
	'value'	=> '',	
);

$countMediaData = (isset($countMediaData) && is_numeric($countMediaData))?$countMediaData:0;
$dn = ($countMediaData >0)?'dn':'';
$isReloadPage=1;
?>
			<div class="seprator_5 clear row"></div>
			<div class="row dn" id="advertMediaFormDiv">	
				
				<!--upload_media_left_top-->
				<div class="upload_media_left_top row"></div>
				
				<!--------advert div start------->
				
				<div class="upload_media_left_box advert_type_div">
						<div class="row">
							<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('SelectAdvertsType');?></label></div>
							<div class="cell frm_element_wrapper" >
								<div id="UploadAdverts">
									<div class="cell pt5 ">
										<?php echo $this->lang->line('UploadAdverts'); ?>
									</div>
									<div class="cell defaultP pl20 pt5">
										<?php echo form_radio($advertsTypeUpload); ?>
									</div>
								</div>
								<div id="CreateAdverts">
									<div class="cell pl15 pt5 ">
										<?php echo $this->lang->line('CreateAdverts'); ?>
									</div>
									<div class="cell pl20 defaultP pt5">
										<?php echo form_radio($advertsTypeCreate); ?>
									</div>
								</div>
							</div>
						</div>
				</div>
				
				<!--------advert type div end------->
				
				<!--------upload advert div start------->
				
				<div class="upload_media_left_box advert_upload_div dn ">
					<?php
					echo form_open($this->uri->uri_string(),$formAttributes); 
						echo form_input($browseIdInput); ?>

						<div class="row">
							<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
							<div class="cell frm_element_wrapper" >
								<?php echo form_input($titleInput); ?>
							</div>
						</div>
						
						<?php
						    $dirUpload = '/openx/www/images/';
							$remainingBytes =12000000;
							$required='required';
							$data=array('typeOfFile'=>1,'mediaFileTypes'=>$this->config->item('advertFileType'),'fileMaxSize'=>$remainingBytes,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('file'),'editFlag'=>0,'fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'imgload'=>0);
							$this->load->view("uploadForm",$data);
							
						?>
						<div class="row">
							<div class="cell label_wrapper"><label><?php echo $this->lang->line('advertUrl');?></label></div>
							<div class="cell frm_element_wrapper" >
								<?php echo form_input($upAdvertUrl); ?>
							</div>
						</div>
						
						<div class="seprator_25 clear row"></div>
						<input type="hidden" id="competitionId" value="<?php echo $competitionId; ?>" name="competitionId">	
						<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
									<div class="tds-button Fright mr10"> <button name="saveMedia" value="saveMedia" class="font_arial" onclick="advertSubmitChk();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('save'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
									<div class="tds-button Fright mr5"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
								<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
							</div>
					<?php 
						$isEditBlock=false;
						if(isset($competitionId) && !empty($competitionId)){
							// if competition is published then can't be edit
							if(isCompetitionPublished($competitionId)){
								$isEditBlock=true;
							}	
						}	
					
					echo form_close(); ?>
				</div>
				
				<!--------upload advert div end------->
				
				<!--------create advert div start------->
				
				<div class="upload_media_left_box advert_create_div dn pt_280">
					<?php echo $this->load->view('createAdverts'); ?>
				</div>
				
				<!--------create advert div end------->
				
				<div class="upload_media_left_bottom row"></div>
				
			</div>
<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>			
<script>
	function advertSubmitChk(){
		
		var fileName2 =  $("#fileName<?php echo $browseId?>").val();
		if(fileName2 == undefined){
			fileName2 = '';
		}
		if(fileName2.length >= 4){

				$("#fileInput<?php echo $browseId?>").removeClass('error');	
				$('label.error').remove();	
				$("#uploadFileByJquery<?php echo $browseId?>").click();
	
		}else{
	
			var fileError2 = $("#fileError<?php echo $browseId?>").html();
			if(fileError2 == undefined){
				fileError2 = '';
			}
			fileError2=$.trim(fileError2);
			
			if(fileError2 !=''){
				return false;
			}else{
				$('#advertMediaForm').submit();
			}
		}
	}
	
	$(document).ready(function(){
			
		// when competition is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			$('#advertMediaForm')[0].reset();
			$('#advertMediaForm form input[type=hidden]').val('');
			$('#browseId').val('<?php echo $browseId;?>');
			$("#advertMediaFormDiv").slideToggle('slow');
		});
		
		
		$("#advertMediaForm").validate({
			submitHandler: function() {
				
				var fromData=$("#advertMediaForm").serialize();
				var url = baseUrl+language+'/advertising/advertsadd';
				if(isBlockEdit=='0'){
					$.post(url,fromData, function(data) {
		
					  if(data){
						
						if(data.fileId != undefined &&  (data.fileId > 0)){
							$("#MediaFileId").val(data.fileId);
						} else {
							openLightBoxWithoutAjax('popupBoxWp','popup_box');
						} 
						 
						var fileName =  $("#fileName<?php echo $browseId?>").val();
						if(fileName == undefined){ 
							fileName = '';
						}

						if(fileName.length < 4 ){
							refreshPge();
						}
						
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
						
						}
					},"json");
				}else{
						customAlert('<?php echo $this->lang->line('cannotEditCompMsgRequiredMedia'); ?>');
					}
				
				
			}
		});
	});
	
</script>
