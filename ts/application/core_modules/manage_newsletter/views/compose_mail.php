<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*Set header text start*/
$headText = $this->lang->line('send_newsletter');
/*Set header text end*/
echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading ml50"> <h1>'.$headText.'</h1> </div></div>
<div class="seprator_25"></div>
';
if($this->session->flashdata('error')){ ?> 
<div class="error">
<?php echo $this->session->flashdata('error');?>
</div>
<?php }
echo '<div class="edit_post_wp fl">'  .'';

$formAttributes = array(
	'name'=>'composeMailForm',
	'id'=>'composeMailForm',
);
$toUser = array(
	'name' 		=> 'toUser',
	'id' 		=> 'toUser',
	'type' 		=> 'text',
	'class' 	=> 'textbox width600px required',
	'value'	    => '',
	'readonly'	=> true
);
$subject = array(
	'name' 		=> 'mailSubject',
	'id' 		=> 'mailSubject',
	'type' 		=> 'text',
	'class' 	=> 'textbox width600px required',
	'value'		=> (isset($messageDetails->subject) && !empty($messageDetails->subject))?$messageDetails->subject:'',
	
);

$msgId = array(
	'name' 		=> 'msgId',
	'id' 		=> 'msgId',
	'type' 		=> 'hidden',
	'value'		=> (isset($messageDetails->id) && !empty($messageDetails->id))?$messageDetails->id:'',
	
);
//Set Checked users on resend mail
if(isset($participantsId) && !empty($participantsId)){
	$checkedIds = $participantsId;
}else{
	$checkedIds = '';
}
//Set message id on resend mail
if(isset($messageDetails->id) && !empty($messageDetails->id)){
	$messageId = $messageDetails->id;
	
}else{
	$messageId = '';
}

$newsletterList  = getNewsletterList();
$newsletterValue = '';

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_newsletter/send_mail'),$formAttributes).'
<div id="mailSuccessMsg" class="f16 ml34 orange_color fm_os tac"></div>
<div class="page_list width_530px">
	<ul class="ul_relative"> 
		<div class="ml50">
    
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic b"> '.$this->lang->line('toMail').' </label>
			
		</div>
		
		<li>'.form_input($toUser).'
		<div class="tds-button-top mr-190 mt-38">';
		?>
            <a class="formTip" href="javascript:void(0);" onclick="openLightBox('popupBoxWp','popup_box','admin/settings/manage_newsletter/manage_users_grid/<?php echo $messageId;?>')" original-title="Add Users">
                <span>
                    <div class="projectAddIcon"></div>
                </span>
            </a>
        <?php echo '
	   </div>
		</li>
		
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic b"> '.$this->lang->line('admin_Manage_newsletter').' </label>
		</div>
		<li class="pr">'.form_dropdown('newsletter' , $newsletterList, set_value($newsletter , ( ( !empty($newsletterValue) ) ? "$newsletter" : '' )),'id="newsletter" class="required error single selectBox"').'</li>
		
		
		<div class="clear"></div>
		 <div class="seprator_30"></div>  
		 <div>'.form_input($msgId).'</div>
		';
		
	echo '<li> <div class="tds-button width300px mr-280 fr">
					<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Send" name="submit" type="submit" id="SubmitButton"><span><div class="Fleft">Send</div> <div class="send_button"></div></span></button></div>
						
					<div class="tds-button Fleft"><button onClick="history.go(-1);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="cancel dash_link_hover" type="button" id="cancelButton"><span><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>
				</div>';
	
	echo '
        <div class="clear"></div>  
	</li>
</div>

</ul>
</div></div>
<input type="hidden" id="userIds" name="userIds[]" value="">
'.form_close().'';
?>

<!--<div class="row fr width330px bg_dropshedow pb10 bg_white mr50"><?php //$this->load->view('add_user',array('users'=>$users));?></div>-->
<script type="text/javascript">
runTimeCheckBox();

/*Function to send mail to users */
$(document).ready(function(){
	$("#composeMailForm").validate({
            submitHandler: function(form) {
				form.submit();
                
               /*$('#mBody').html(body);
                userIds = $('#userIds').val();
                var fromData=$("#composeMailForm").serialize();
                fromData = fromData+'&userIds='+userIds;
                $('#mailSuccessMsg').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
                $.post(baseUrl+'admin/settings/manage_newsletter/send_mail',fromData, function(data) {
                    if(data){
                        window.location.href=baseUrl+'admin/settings/manage_newsletter';
                    }
                });*/
            }
        }
       
    );
});

/* Function to set users email in to field*/
function setUserEmail()
{
	var BASEPATH = "<?php echo base_url();?>";
	var userVal = [];
	 $(':checkbox:checked').each(function(i){
			  userVal[i] = $(this).val();  
		});	
	var form_data = {userIds: userVal};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"admin/settings/manage_newsletter/setEmails",
		data: form_data,
		success: function(data)
		{		
			$('#toUser').val(data);
		}
	});
	return false;	
}

</script>

