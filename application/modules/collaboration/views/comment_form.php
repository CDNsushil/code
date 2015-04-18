<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId='_cm';
$formAttributes = array(
	'name'=>'commentsForm',
	'id'=>'commentsForm'
);


$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'commentTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);

$browseIdInput = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);

$elementIdInput = array(
	'name'	=> 'elementId',
	'value'	=> $elementId,
	'id'	=> 'elementId',
	'type'	=> 'hidden'
);

$entityIdInput = array(
	'name'	=> 'entityId',
	'value'	=> $entityId,
	'id'	=> 'entityId',
	'type'	=> 'hidden'
);

$collaborationIdInput = array(
	'name'	=> 'collaborationId',
	'value'	=> $collaborationId,
	'id'	=> 'collaborationId',
	'type'	=> 'hidden'
);


?>
<div class="seprator_25"></div>


<div class="row form_wrapper">
	<div class="row position_relative">	
		<div class="row ">
			<div class="cell tab_left">
				<div class="tab_heading">
					Leave a comment</div><!--tab_heading-->
			</div>
			<div class="cell tab_right">
				<div class="tab_btn_wrapper">
					<div class="tds-button-top"> 
						
						<a>
							<span><div toggledivid="commentsFormDiv" id="collabToggleIcon" class="projectToggleIcon" ></div></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div id="commentsFormDiv" class="form_wrapper toggle frm_strip_bg ">
			
			<div class="row" >	
	
				<div class="row"><div class="tab_shadow"></div></div>
				<div class="seprator_5 clear row"></div>
				<div class="clear"></div>
				
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
					<?php
					echo form_open($this->uri->uri_string(),$formAttributes); 
						echo form_input($browseIdInput);
						echo form_input($elementIdInput);
						echo form_input($entityIdInput);
						echo form_input($collaborationIdInput);
						?>

						<div class="row">
							<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
							<div class="cell frm_element_wrapper" >
								<?php echo form_input($titleInput); ?>
							</div>
						</div>
						
						
						
						<?php
							
							$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'required', 'labelText'=>'description', 'wordOption'=>array('minVal'=>1,'maxVal'=>100));
							$this->load->view("common/description",$data);
							
							$required='';
							
							$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoAccept'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('file'),'editFlag'=>0,'fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'imgload'=>0,'isUploadEmbedOption'=>0,'isFileDimension'=>0);
							$this->load->view("upload_type",$data);
						?>
						
						<div class="seprator_25 clear row"></div>
						<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
									<div class="tds-button Fright mr10"> <button name="saveMedia" value="saveMedia" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft"><?php echo $this->lang->line('submit'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
									<div class="tds-button Fright mr18"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
								<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
							</div>
					<?php echo form_close(); ?>
				</div>
				<div class="upload_media_left_bottom row"></div>
				<div class="seprator_25 clear"></div>	
				
				
			</div>
			
			<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>
			
			
		</div>
		
		<div class="row">
				<div class="tab_shadow"></div>
			</div>	
		
		
	</div>
</div>

	
		
<script>
	$(document).ready(function(){
		
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			
			$('label.error').remove();
			
			$('input.error').each(function(index){
					var inputClass =$(this).attr('class').replace('error', '');
					$(this).attr('class',inputClass);
			});
			$('textarea.error').each(function(index){
					var inputClass =$(this).attr('class').replace('error', '');
					$(this).attr('class',inputClass);
			});
	
			$('#commentsForm')[0].reset();
			$('#commentsForm form input[type=hidden]').val('');
			$('#browseId').val('<?php echo $browseId;?>');
			$('#elementId').val('<?php echo $elementId;?>');
			$('#entityId').val('<?php echo $entityId;?>');
			$('#collaborationId').val('<?php echo $collaborationId;?>');
			selectedFileTypeShow('2');
			//$("#commentsFormDiv").slideToggle('slow');
		});
		
		$("#commentsForm").validate({
			submitHandler: function() {
				
				var fromData=$("#commentsForm").serialize();
				var url = baseUrl+language+'/collaboration/saveComments/';
				
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
			}
		});
	});
</script>
