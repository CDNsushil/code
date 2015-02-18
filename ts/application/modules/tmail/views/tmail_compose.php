<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
'name'=>'newTmail',
'id'=>'newTmail'
);


$composebody = array(
		'id'	=> 'body',
		'name'	=> 'body',
		'class'	=> 'width556px rz required ',
		'rows' => 12,
		'cols' => 50,
		'value'=>''
	);
	
	
$receiverMail = array(
		'name'	=> 'receiverMail',
		'id'	=> 'receiverMail',	
		'class'	=> 'Bdr width_487 required',
		'readonly' => 'readonly',			
		'value'	=>  ''		
	);	

$receiverName = array(
		'name'	=> 'receiverName',
		'id'	=> 'receiverName',	
		'class'	=> 'Bdr width514px required',
		'readonly' => 'readonly',			
		'value'	=>  (isset($receiverName))?$receiverName:''	
	);
// set subject if it comes from recommendation
$recommendationSubject = (isset($recommendationSubject)) ? $recommendationSubject :'';	
// set tmail main subject
$subject = (isset($subject) && ($subject!='')) ? $subject :$recommendationSubject;	
$subject = array(
		'name'	=> 'subject',
		'id'	=> 'subject',	
		'class'	=> 'Bdr width544px required',
		'value'	=> $subject
		
	);	

// set user's id
$recipientsId =  (isset($recipientsId))?$recipientsId:'';
// set user's email
$receiverEmail =  (isset($receiverEmail))?$receiverEmail:'';
?>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		//myNicEditor.panelInstance('body');
		myNicEditor.setPanel('myNicPanel');  
        myNicEditor.addInstance('body');
		
		
	});
</script>

<?php
$Information=$this->load->view('tmail/craved_user_list',array('elementId'=>''),true);?>
					
					<script>
					var rData=<?php echo json_encode($Information);?></script>

<?php $function="openLightBox('popupBoxWp','popup_box','/tmail/getCravedUser')";

 ?>


	<div class="row form_wrapper">
		<div class="row">
			<div class="cell frm_heading">
				<h1>Tmail</h1>
			</div>

			<?php $this->load->view('tmail_common_button'); ?>
			

		</div> <!--row-->
		<div class="clear"></div>
   </div><!--row form_wrapper-->


		<div class="row pt2 ">
			<div class="row ">				
				<div class="cell tab_left width_202">
					<div class="tab_heading_global"> </div><!--tab_heading-->
				</div>
			<div class="cell tab_right width_590">
				<div class="tds-button-inbox Fright mt5 mr10 btn_span_hover"><a href="<?php echo base_url(lang().'/tmail') ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)"><span>Inbox
				</span></a></div>
			</div>
		</div><!--row-->
		
		<div class="clear"></div>


<div class="upload_media_left_top row mt10"></div>

		<div class="form_wrapper toggle pr5 upload_media_left_box">
			
		<div class="shadow_wp strip_absolute">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
				<tbody>
				<tr>
				  <td height="271"><img src="<?php echo base_url('/images/shadow-top.png')?>"></td>
				</tr>
				<tr>
				  <td class="shadow_mid">&nbsp;</td>
				</tr>
				<tr>
				  <td height="271"><img src="<?php echo base_url('/images/shadow-bottom.png')?>"></td>
				</tr>
				</tbody>
			</table>
		</div> <!-- shadow_wp strip_absolute -->

		<div class="row">
		<div class="tab_shadow tab_shadow_g mt-16"> </div>
		</div>
		<div class="shadow_sep row"> </div>
		<div class="clear"></div>
		<!--<div class="seprator_10"> </div>-->

		<?php echo form_open(base_url(lang().'/tmail'),$formAttributes); ?>

		<input type="hidden" name="type" value="1">
		<input type="hidden" name="recipientsId" id="recipientsId" value="<?php echo $recipientsId?>">
		<input type="hidden" name="receiverMail" id="receiverMail" value="<?php echo $receiverEmail?>">

		<div class="width100percent">

		<div class="row width_791">
		<div class="label_wrapper_global cell">
		<label class="select_field_g">To</label>
		</div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper pl24"> 
		<div class="tds-button-top mr10 mt3">
                <a onclick="<?php echo $function ?>" href="javascript://void(0);" class="formTip" title="<?php echo $this->lang->line('members_craving_you'); ?>">
                    <span>
                    <div class="projectAddIcon"></div>
                    </span>
               </a>
           </div>
		            
		<?php echo form_input($receiverName);  ?>
		
		<div class="cell mt3 ">
			<?php echo $this->lang->line('sendReplayMessage'); ?>
		</div>	

		</div>
	</div>	

		<div class="row width_791">
		<div class="label_wrapper_global cell">
		<label class="select_field_g">Subject</label>
		</div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper pl24">
		     <?php echo form_input($subject); ?>
		</div>
		</div>


		<div class="row width_791">
		<div class="label_wrapper_global cell">
		<label class="select_field_g">Compose</label>
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
		<div class="label_wrapper cell bg-non"> </div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper pl25" style="width:200px">
		<div class="Req_fld mr30 font_arial font_size11 clr_676767 mt10">Required Fields</div> 
		</div>
		</div>             

       
		<div class="tds-button fr mt15 mb10 mr15">

		<button type="button" id="cancelCompose" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="dash_link_hover"><span>
              <div class="Fleft">Cancel</div>
              <div class="cancel_button"></div>
              </span></button>
              
              <button type="submit" id="saveCompose" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="dash_link_hover"><span>
              <div class="Fleft">Send</div>
              <div class="send_button"></div>
              </span></button>

		</div>
		
		<div class="clear"></div>
		
		<div class=" seprator_3 clear"></div>
		
		</div>       


		<?php echo form_close(); ?>	


		</div> <!--form_wrapper-->

<div class="upload_media_left_bottom row"></div>		
		
		
		</div> <!--row pt2-->

<script>
function mouseout_inputtmail(obj){
obj.style.backgroundPosition ='0px -0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_inputtmail(obj){
	obj.style.backgroundPosition ='-0px -33px';
	obj.firstChild.style.backgroundPosition ='right -33px';
}


//	selectBox();
	$(document).ready(function(){

     $('#saveCompose').click(function() {
			$("#newTmail").validate({

				//messages: {
				//wordCount: "Please enter a number."
				//},			
				submitHandler: function() {						
					
					body=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");					
					
					if(body.replace('<br>','')==''){
						$('#replErrorMsg').html('This is required field');
						$('#myInstance1').addClass('error_div_border');
						return false;
					}else{
						$('#replErrorMsg').html('');
						$('#myInstance1').removeClass('error_div_border');
					}			

					var fromData=$("#newTmail").serialize();
                     fromData = fromData+'&ajaxHit=1'+'&replymsg='+body;
					 $.post(baseUrl+language+'/tmail/sendTmail',fromData, function(data) {
						if(data){
							
							$('#replymsg').val(' ');
							$('.nicEdit-main').html();
							
							$('#messageSuccessError').html('<div class="successMsg"><?php echo "Mail Sent";?> </div>');
					        timeout = setTimeout(hideDiv, 5000);
					        $('#showThreads').html(data); 	
					          window.location = "<?php echo base_url(lang().'/tmail'); ?>";
					        //	redirect(base_url(lang().'/tmail'));				        							
						}


					});				

				}
			});
		
		 });	
			
			
		$('#cancelCompose').click(function() {				
			window.location.href = "<?php echo base_url(lang().'/tmail')?>";			
			});	
	

  });


	</script>

