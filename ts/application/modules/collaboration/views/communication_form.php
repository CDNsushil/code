<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId='_cm';
$formAttributes = array(
	'name'=>'communicationForm',
	'id'=>'communicationForm'
);
$fileIdInput = array(
	'name'	=> 'fileId',
	'id'	=> 'fileId',
	'type'	=> 'hidden',
	'value'	=> '0'
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
$subject = (isset($subject) && ($subject!='')) ? $subject :'';	
$subject = array(
		'name'	=> 'subject',
		'id'	=> 'subject',	
		'class'	=> 'Bdr width544px required',
		'value'	=> $subject
		
	);	
$composebody = array(
		'id'	=> 'body',
		'name'	=> 'body',
		'class'	=> 'width556px rz required ',
		'rows' => 12,
		'cols' => 50,
		'value'=>''
	);	

$displayForm="";

if(isset($comTmailData) && count($comTmailData) > 0 && !empty($comTmailData) && (empty($isCompose) || $isCompose==0)) {
	$displayForm="dn";
}

?>
<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		//myNicEditor.panelInstance('body');
		myNicEditor.setPanel('myNicPanel');  
        myNicEditor.addInstance('body');
	});
</script>
<div class="seprator_5 clear row"></div>

<div class="clear"></div>
		
<div class="row <?php //echo $displayForm;?>" id="collaborationMediaFormDiv">	
	
	<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
	<div class="upload_media_left_box">
		<?php
		echo form_open($this->uri->uri_string(),$formAttributes);
			echo form_input($fileIdInput);
			echo form_input($browseIdInput);
			echo form_input($collaborationIdInput);
		?>

			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('subject');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($subject); ?>
				</div>
			</div>
			
			<?php	
			//$required='required';
			$required = '';
			
			$data=array('typeOfFile'=>2,'mediaFileTypes'=>$this->config->item('videoAccept'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('file'),'editFlag'=>0,'fileTypeFlag'=>1,'flag'=>0,'browseId'=>$browseId,'imgload'=>0);
			$this->load->view("upload_type",$data);
			
			?>
			
			<div class="row width_791">
				<div class="label_wrapper_global cell">
					<label class="select_field"><?php echo $this->lang->line('description');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl24">
					<div id="myNicPanel" class="width527px bdr_e2e2e2 tmailtop_gradient p15"></div>
					<div id="myInstance1" class="NIC">
						<?php echo form_textarea($composebody); ?>
					</div>
					<div id="replErrorMsg"></div>	
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('notifyMemberByTMail');?></label></div>
				<div class="cell frm_element_wrapper">
					<?php 
					if(isset($membersData) && is_array($membersData) && count($membersData) > 0){?>
					<!-- all member checkbox div start here-->
						<div class="row pt5" >
							<div class="cell" >
								<div class="row" >
									<div class="cell">
										<div class="defaultP">
											<input type="checkbox" id="allMembersId" value="" name="recipientsId[]" >
										</div>
									</div>
									<div class="cell pr10" ><?php echo $this->lang->line('allMember');?></div>
								</div>	
							</div>
						</div>	
						<!-- all member checkbox div end here-->
						
						<!-- Members checkbox listing div start here-->
						<div class="row pt5" >	
							<div id="memberDiv">
								<?php foreach($membersData as $k=>$member){ ?>
									<div class="cell" >
										<div class="row" >
											<div class="cell" >
												<div class="defaultP">
													<input type="checkbox" id="membersId<?php echo $member->userId;?>" value="<?php echo $member->userId;?>" name="recipientsId[]" >
												</div>
											</div>
											<div class="cell pr10" >
												<?php echo  $member->firstName.' '.$member->lastName;?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>	
						<!-- Members checkbox listing div end here-->
					<?php }?>
				</div>
			</div>
			
			<div class="seprator_25 clear row"></div>
 			<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
						<div class="tds-button Fright mr10"> <button name="saveMedia" id="saveCompose" value="saveMedia" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft"><?php echo $this->lang->line('post'); ?></div> <div class="icon-publish-btn"></div></span> </button> </div>
			
						<div class="tds-button Fright mr10"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
					<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
				</div>
		<?php echo form_close(); ?>
	</div>
	<div class="upload_media_left_bottom row"></div>
	<div class="seprator_25 clear"></div>	
</div>
		
<script>
	$(document).ready(function(){
		
		//Send tmail to selected members
		$('#saveCompose').click(function() {
			$("#communicationForm").validate({			
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
										
					body=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");					
					
					if(body.replace('<br>','')==''){
						$('#replErrorMsg').html('This is required field');
						$('#myInstance1').addClass('error_div_border');
						return false;
					}else{
						$('#replErrorMsg').html('');
						$('#myInstance1').removeClass('error_div_border');
					}
					var fromData=$("#communicationForm").serialize();	
					if($('#allMembersId').is(':checked') === true) {
						var memberIds = '<?php echo $memberIds;?>';
						fromData = fromData+'&fileLength='+fileLength+'&ajaxHit=1&replymsg='+body+'&isAllMember=1&memberIds='+memberIds;
					} else {
						fromData = fromData+'&fileLength='+fileLength+'&ajaxHit=1&replymsg='+body+'&isAllMember=0';
					}		      
					$.post(baseUrl+language+'/collaboration/sendCommunicationTmail',fromData, function(data) {
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
					        //refreshPge();	        							
						}
					},"json");			
				}
			});
		});	
		
		//Set description fields min height
		$('#AddIconcollab').click(function() {
			$('.nicEdit-main').css('min-height', '170px');
		});	
		
		//Slide toggel on cancle form
		$("#CGcancelButton").click(function(){
			$( "#collab-Content-Box" ).slideToggle( "slow" );
			$( "#compose_id" ).removeClass( "toggle_icon" );
		});
		
		//Manage member checkboxes
		$('#allMembersId').click(function() {
			if($('#allMembersId').is(':checked') === true) {
				$('#memberDiv').hide();
			} else {
				$('#memberDiv').show();
			}
		});		
	});
		
</script>
