<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
'name'=>'replyTmail',
'id'=>'replyTmail'
);


$composebody = array(
		'id'	=> 'replymsg',
		'name'	=> 'replymsg',
		'class'	=> 'width556px rz required ',
		'rows' => 12,
		'cols' => 50,
		'value'=>''
	);
	
$replyEmailId = (isset($replyEmailId) && $replyEmailId!='') ? $replyEmailId :'';	
$receiverMail = array(
		'name'	=> 'receiverMail',
		'id'	=> 'receiverMail',	
		'type'   =>'hidden',		
		'readonly' => 'readyonline',
		'value'	=> $replyEmailId		
	);	
	
$replyUserName = (isset($replyName) && $replyName!='') ? $replyName :'';	

$subject = (isset($subject) && ($subject!='')) ? $subject :'';	
$subject = array(
		'name'	=> 'subject',
		'id'	=> 'subject',	
		'class'	=> 'Bdr width_551 required',
		'value'	=> 'Re: '.$subject
		
	);	
	
	
	
?>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		//myNicEditor.panelInstance('replymsg');
		myNicEditor.setPanel('myNicPanel');  
        myNicEditor.addInstance('replymsg');
	});
</script>

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
				<div class="tab_heading_global"> </div>
				<!--tab_heading-->
				</div>
				<div class="cell tab_right width_590">
				<div class="tds-button-inbox Fright mt5 mr10 btn_span_hover"><a href="<?php echo base_url(lang().'/tmail') ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)"><span>Inbox
				</span></a></div>
			</div>

		   </div>
		<!--row-->
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
		<!---<div class="seprator_10"> </div>-->


		<?php echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); ?>
		
	       <div class="width100percent">

        <input type="hidden" name="senderId" value="<?php echo $senderId ?>" >
         <input type="hidden" name="receiverid" value="<?php echo $receiverid  ?>" > 
         <input type="hidden" name="reply_msg_id" value="<?php echo $reply_msg_id  ?>" >
         <input type="hidden" name="msgType" value="<?php echo $msgType  ?>" >
         <input type="hidden" name="threadId" value="<?php echo $threadId  ?>" >
          
           <div class="row width_791">
            <div class="label_wrapper_global cell">
              <label class="select_field_g">To</label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pl24">             
              <?php echo form_input($receiverMail);  ?>
               <div class="disable_div"> <?php echo $replyrName ?> </div>
				<div class="mt3 ">
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


			<div class="tds-button fr mt15 mb10 mr18">
			
		   <?php
			//$button=array('ajaxSave', 'ajaxCancel','buttonId'=>'reply');
			//echo Modules::run("common/loadButtons",$button); ?>
			
			<button type="button"  id="cancel"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" style="background-position: 0px -38px;" class="dash_link_hover"><span style="background-position: right -38px;">
              <div class="Fleft">Cancel</div>
              <div class="cancel_button"></div>
              </span></button>
              
              <button type="save"  id="checkSave" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span>
              <div class="Fleft">Send</div>
              <div class="send_button"></div>
              </span></button>
			
						  
				  
				</div>
				
				<div class="clear"></div>
					<div class=" seprator_3 clear"></div>
				 </div>       
        
        
 	<?php echo form_close(); ?>	
 	
			<div id="showThreads">
				
			<?php $data['mailThreadData'] = $mailThreadData;
			 $this->load->view('show_thread',$data); ?>
			 
			 </div>
		</div> <!--tab_wp-->
	
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
       
       $('#checkSave').click(function() {
		   	
			$("#replyTmail").validate({
		
				submitHandler: function() {						
					
					replymsg=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
					
					$('#replymsg').html(replymsg);
					
					
					if(replymsg.replace('<br>','')==''){
						$('#replErrorMsg').html('This is required field');
						$('#myInstance1').addClass('error_div_border');
						return false;
					}else{
						$('#replErrorMsg').html('');
						$('#myInstance1').removeClass('error_div_border');
					}			

					var fromData=$("#replyTmail").serialize();
                     //fromData = fromData+'&ajaxHit=1'+'&replymsg='+replymsg;
                     fromData = fromData+'&ajaxHit=1';
                    $.post(baseUrl+language+'/tmail/saveReplyTmail',fromData, function(data) {
						if(data){
							
							//$('#replymsg').val(' ');
							//$('.nicEdit-main').html();
							$('#messageSuccessError').html('<div class="successMsg"><?php echo "Message Sent.";?> </div>');
							window.location.href = "<?php echo base_url(lang().'/tmail/viewTmail/'.$reply_msg_id.'/'.$viewType)?>";
					       // timeout = setTimeout(hideDiv, 5000);
					        //$('#showThreads').html(data); 					        							
						}

					});				

				}
			});
		});	
			
			
		$('#cancel').click(function() {			
			history.go(-1);			
			});	
	

	
	
	/*	$('.replaySlide').live('click',function(){
				var togDivId = $(this).attr('toggleDivId');
				if($(this).css("background-position")=='-1px -121px'){
					$(this).css("background-position","-1px -144px")
					
				}else{
					$(this).css("background-position","-1px -121px");
				}
				$('#'+togDivId).slideToggle("slow");
			});	*/
	

  }); 


	</script>

