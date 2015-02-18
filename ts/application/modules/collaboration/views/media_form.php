<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId='_cm';
$formAttributes = array(
	'name'=>'collaborationMediaForm',
	'id'=>'collaborationMediaForm'
);
$mediaIdInput = array(
	'name'	=> 'mediaId',
	'id'	=> 'mediaId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$fileIdInput = array(
	'name'	=> 'fileId',
	'id'	=> 'fileId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'collaborationMediaTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);
$browseIdInput = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);
$collaborationIdInput = array(
	'name'	=> 'collaborationId',
	'value'	=> $collaborationId,
	'id'	=> 'collaborationId',
	'type'	=> 'hidden'
);
$displayForm="";
if(isset($mediaData) && count($mediaData) > 0 && !empty($mediaData) ) {
	$displayForm="dn";
}

?>
<div class="seprator_5 clear row"></div>

<div class="clear"></div>
		
<div class="row <?php echo $displayForm;?>" id="collaborationMediaFormDiv">	
	
	<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
	<div class="upload_media_left_box">
		<?php
		echo form_open($this->uri->uri_string(),$formAttributes); 
			echo form_input($mediaIdInput);
			echo form_input($fileIdInput);
			echo form_input($browseIdInput);
			echo form_input($collaborationIdInput);?>

			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
			<?php
			
				
				$required='required';
				
				$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoAccept'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('file'),'editFlag'=>0,'fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'imgload'=>0);
				$this->load->view("upload_type",$data);
				
				
				$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description');
				$this->load->view("common/description",$data);
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
		
<script>
	$(document).ready(function(){
		
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			$('#collaborationMediaForm')[0].reset();
			$('#collaborationMediaForm form input[type=hidden]').val('');
			$('#hh').val('00');
			$('#hh').selectBoxJquery('value', '00');
			$('#mm').val('00');
			$('#mm').selectBoxJquery('value', '00');
			$('#ss').val('00');
			$('#ss').selectBoxJquery('value', '00');
			
			$('#Uploadvideo<?php echo $browseId;?>').show();
			$('#FileUpload<?php echo $browseId;?>').show();
			$('#rawFileNameDiv<?php echo $browseId;?>').hide();
			$('#selectFileTypeDiv<?php echo $browseId;?>').show();
			$('#uploafFileButton<?php echo $browseId;?>').show();
			$('#embedButton<?php echo $browseId;?>').show();
			$('#EmbeddedURL<?php echo $browseId;?>').hide();
			//------show default lenght div-----//	
			$("#fileLengthDiv<?php echo $browseId;?>").show();
			$("#dimensionsDiv<?php echo $browseId;?>").hide();
			$("#wordCountDiv<?php echo $browseId;?>").hide(); 
			
			$('#browseId').val('<?php echo $browseId;?>');
			$('#collaborationId').val('<?php echo $collaborationId;?>');
			$('#mediaId').val('0');
			$('#fileId').val('0');
			selectedFileTypeShow('2');
			$("#collaborationMediaFormDiv").slideToggle('slow');
		});
		
		$("#collaborationMediaForm").validate({
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
				
				var fromData=$("#collaborationMediaForm").serialize();
				fromData = fromData+'&fileLength='+fileLength;
				var url = baseUrl+language+'/collaboration/mediaSave/';
				
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
	
	//delete collaboration media 
	function collaborationMediaDelete(mediaId,fileId){
		var detStatus = confirm('Are you sure you want delete this media?');
			if(detStatus){
				var deleteData = '&mediaId='+mediaId+'&fileId='+fileId;
				var url = baseUrl+language+'/collaboration/collaborationMediaDelete';
				$.post(url,deleteData, function(data) {
				  if(data){
						refreshPge();
						/*$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);*/
					}
				},"json");
			}
		}
		
</script>
