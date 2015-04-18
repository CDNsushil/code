<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionMediaLimit = $this->config->item('competitionMediaLimit');
$browseId='_cm';
$formAttributes = array(
	'name'=>'competitionMediaForm',
	'id'=>'competitionMediaForm'
);
$competitionMediaIdInput = array(
	'name'	=> 'mediaId',
	'id'	=> 'mediaId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'competitionMediaTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);
$browseIdInput = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);


	

$countMediaData = (isset($countMediaData) && is_numeric($countMediaData))?$countMediaData:0;
$dn = ($countMediaData >0)?'dn':'';
$isReloadPage=1;
?>
			<div class="seprator_5 clear row"></div>
			<div class="row dn" id="competitionMediaFormDiv">	
				
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
					<?php
					echo form_open($this->uri->uri_string(),$formAttributes); 
						echo form_input($competitionMediaIdInput);
						echo form_input($browseIdInput); ?>

						<div class="row">
							<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
							<div class="cell frm_element_wrapper" >
								<?php echo form_input($titleInput); ?>
							</div>
						</div>
						
						<?php
						
							$dirSize=getFolderSize($dirUpload);
							$remainingBytes =($containerSize - $dirSize);
							if(!$remainingBytes > 0){
								$remainingBytes =0;
							}
	
							$required='required';
							
							$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoAccept'),'fileMaxSize'=>$remainingBytes,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('file'),'editFlag'=>0,'fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'imgload'=>0);
							$this->load->view("upload_type_form",$data);
							
							
							$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description');
							$this->load->view("common/description",$data);
						?>
						
						
						<div class="seprator_25 clear row"></div>
						<input type="hidden" id="competitionId" value="<?php echo $competitionId; ?>" name="competitionId">	
						<input type="hidden" id="fileId" value="" name="fileId">		
						<input type="hidden" id="mediaId" value="" name="mediaId">		
						<input type="hidden" id="mediaOrder" value="" name="mediaOrder">		
						<input type="hidden" id="mediaFormAction" value="" name="mediaFormAction">	
						<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
									<div class="tds-button Fright mr10"> <button name="saveMedia" value="saveMedia" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft"><?php echo $this->lang->line('submit'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
									<div class="tds-button Fright mr18"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
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
				<div class="upload_media_left_bottom row"></div>
				
			</div>
<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>			
<script>
	$(document).ready(function(){
		
		// when competition is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			$('#competitionMediaForm')[0].reset();
			$('#competitionMediaForm form input[type=hidden]').val('');
			$('#browseId').val('<?php echo $browseId;?>');
			$("#competitionMediaFormDiv").slideToggle('slow');
		});
	
		$("#competitionMediaForm").validate({
			submitHandler: function() {
				
				var fileWidth = $('#fileWidth').val();
				var fileHeight = $('#fileHeight').val();
				var fileUnit = $('#fileUnit').val();
				
				// Check file height and file Width 
				if(fileHeight!=0 && fileWidth!=0) {
					  if(fileUnit=='')
					  {
						  //alert('Please select unit')
						   $('#fileUnitError').show();
						  return false;
					  }
					  else  $('#fileUnitError').hide();
				}
				if(fileWidth=="" || fileHeight=="")
				{
					$('#fileWidth').val('');
					$('#fileHeight').val('');
					$('#fileUnit').val('');
				}
			
				//---------set lenght and duration---------//	
				var hh=$('#hh').val();
				var mm=$('#mm').val();
				var ss=$('#ss').val();
				if(parseInt(hh) >=0 || parseInt(mm) >=0 || parseInt(ss) >=0){
					var fileLength=hh+':'+mm+':'+ss;
				}else{
					var fileLength='00:00:00';
				}
				
				var fromData=$("#competitionMediaForm").serialize();
				fromData = fromData+'&fileLength='+fileLength;
				var url = baseUrl+language+'/competition/competitionMediaSave';
				if(isBlockEdit=='0'){
					$.post(url,fromData, function(data) {
					  if(data){
						
						if(data.fileId != undefined &&  (data.fileId > 0)){
						  $("#MediaFileId").val(data.fileId);
						}  
						 
						$("#uploadFileByJquery<?php echo $browseId;?>").click();
						
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
	
	//delete competition media 
		function competitionMediaDelete(mediaId,fileId){
			
			// checking competition isPublished or not
			<?php if($isEditBlock) { ?>	
				customAlert('<?php echo $this->lang->line('cannotDeleteCompMsgRequiredMedia'); ?>');
				return false;
			<?php }else { ?>	
				var detStatus = confirm('Are you sure you want delete this media?');
				if(detStatus){
					var deleteData = '&mediaId='+mediaId+'&fileId='+fileId;
					var url = baseUrl+language+'/competition/competitionMediaDelete';
					$.post(url,deleteData, function(data) {
					  if(data){
							refreshPge();
							/*$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
							timeout = setTimeout(hideDiv, 5000);*/
						}
					},"json");
				}
			<?php } ?>
			
			}
		
</script>
