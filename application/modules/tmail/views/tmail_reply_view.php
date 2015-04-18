<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="replayTmail"> </div>
<?php
$formAttributes = array(
		'name'=>'viewTmailList',
		'id'=>'viewTmailList'
		
	);	
//echo form_open('',$formAttributes);




?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient bg_f3f3f3" id="replayDiv">
<div id="testa"></div>	

<?php 


 if(isset($data->id) && !empty($data->id))
 {
	$nextContId = getUserNextTmail($data->id,$curentUid,$type);
	$prevContId = getUserPrevTmail($data->id,$curentUid,$type);
  }
$max_id;
$min_id;

if( isset($nextContId[0]->id) && ($nextContId[0]->id!='') )
{
$nextRecord = $nextContId[0]->id;
}
elseif( isset($prevContId[0]->id) && ($prevContId[0]->id!='') )
{
  $nextRecord = $prevContId[0]->id;	
  
	}
	else 
	{
		$nextRecord = 0;	
		
		}
	
?>	
	<?php echo form_open(base_url(lang().'/tmail/replyrequestWP'),$formAttributes); ?>
	
	<div id="currentRecordId" class="dn" ><?php echo $data->status_id ?></div>
	<div id="nextRecordId" class="dn"  ><?php echo $nextRecord ?></div>
	<div id="viewType" class="dn" ><?php echo $type; ?></div>
    <div class="seprator_14"></div>
   
   <input type="text" name="subject" class ="dn" value="<?php echo $data->subject; ?>">  
   <input type="text" name="reply_msg_id" class ="dn" value="<?php echo $data->id; ?>">
   <input type="text" name="receiverid" class ="dn" value="<?php echo $data->sender_id; ?>">
   <input type="text" name="body" class ="dn" value="<?php echo $data->body; ?>">
   
   

 
  
  <div class="bdr_d2d2d2 Contact_form_topbox ml15 mr14 position_relative">
  <div class="cell shadow_wp strip_absolute left_240">
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
          </tr>
          <tr>
            <td class="shadow_mid_small">&nbsp;</td>
          </tr>
          <tr>
            <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"></div>
    </div>
  	<div class="cell width_158">
    
    	<?php $profile_img = getContactUserProfileImage($data->email); ?>
        <div class="seprator_20"></div>
        
      <?php if($profile_img['ContactUserProfileImage']!="")
                 {	?>
        <div class="w69_h66 margin_auto"><div class="AI_table"><div class="AI_cell"><img class=" min_w165_h165 Tmail_form_thumb_1" src="<?php echo base_url(). $profile_img['ContactUserProfileImage'];?>" /></div></div></div>
    
    </div>
    <?php } ?>
    <div class="cell pt20">
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('from');?></label>
            </div>
            <div class="cell contact_frm_element_wrapper">
              <span class="pt7"><?php  echo isGetUserName($data->id);?></span>	
            </div>
          </div>
           <!-- row01-->
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo "Subject";?></label>
            </div>
            <div class="cell contact_frm_element_wrapper pl14">
							
              <span class="pt7"><?php echo  $data->subject;?></span>	
            </div>
          </div>
           <!-- row01-->
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('Date');?></label>
            </div>
            <div class="cell contact_frm_element_wrapper">
              <span class="pt7"><?php echo  $data->cdate;?></span>
            </div>
          </div>
    </div>
    <div class="clear"></div>
  </div>
    <div class="seprator_14"></div>
    <div class="textarea_small_bg ml15 mr14 contact_texta">
		<?php 
			//$contactMeTemplate=htmlentities($contactMeTemplate);
			$contactmeMessageInput=array('name'=>'body',
										 'id'=>'contactmeMessage',
										 'value'=> $data->body,
										 'descLimit'=>'contactmeMessageDescLimit',
										 'class'=>'textarea_small font_arial w550_h360 required rz',
										 'wordlength'=>'5,500',
										 'onkeyup'=>"checkWordLen(this,500,'contactmeMessageLimit')",
										 'readonly'=>'readonly'
									    );
									 
			echo form_textarea($contactmeMessageInput);
		?>
	</div>
	<div id="word_counter" class="row wordcounter">
		    <span class="tag_word_orange mt5 clr_666 font_size11 ml30"><?php echo $this->lang->line('5To500words');?></span>
			<span class="five_words mt5" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span class="inline" id="contactmeMessageLimit"><?php echo (str_word_count( $data->body)-1);?></span>
				<span class="inline"> <?php echo $this->lang->line('words');?></span>
			 </span>
    </div>
	<div class="seprator_14"></div>
	<div class="clear"></div>
	
	
	
   <div class="mt11">	
   
   
		
 <div class="tds-button Fright mr9"> <button onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft"><?php echo $this->lang->line('close');?></div> <div class="icon-save-btn"></div> </span> </button>  </div>
      <div class="tds-button Fright mr9"> <button onclick="conformYesBox();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Delete</div> <div class="icon-save-btn"></div> </span> </button>  </div>
      
  <?php if ( ($data->type == 2) && ($type=='Inbox')    ) { ?>
      <div class="tds-button Fright mr9"> <button  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Send WorK Profile</div> <div class="icon-save-btn"></div> </span> </button>  </div>
     <?php } elseif ($data->type ==1) { ?>
     
     <div class="tds-button Fright mr9"> <button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Reply</div> <div class="icon-save-btn"></div> </span> </button>  </div>
     <?php } ?> 
      <div class="clear"></div>
     
     
     
     
    <?php echo form_close(); ?>
    



<?php   if($nextContId != $prevContId ){ 
           if(($max_id==$data->id) || ($min_id==$data->id)) 
           {
			?>  <div class="mt10 ml15 mr15 line1 float_none"></div>
            <?php if($min_id==$data->id) {?> 
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
            <div class="vcard_pre_box ml16 pre_arrow mt10" style="cursor: pointer;" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')">
                    	
                        Previous
                   
                   
                    </div><!--vcard_pre_box-->
              <?php
		  }
		  ?>
              
              <?php if($max_id==$data->id) {?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                    <div class="vcard_next_box mr15 mt10 next_arrow mr15 mt10" style="cursor: pointer;" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')">
                    	 Next
                        
                   
                    </div><!--vcard_next_box-->
                    <?php
				}
				?>
           
           <?php }else{?>
           <!----------------->
            <div class="mt10 ml15 mr15 line1 float_none"></div>
            <?php if(count($prevContId) != 0 ) {?>
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
            <div class="vcard_pre_box ml16 pre_arrow mt10" style="cursor: pointer;" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')">
                    	
                    Previous
                   
                   
                    </div><!--vcard_pre_box-->
              <?php
		  }
		  ?>
              
              <?php if(count($nextContId) != 0 ) { ?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                    <div class="vcard_next_box next_arrow mr15 mt10" style="cursor: pointer;" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')">
                  Next
                       
                   
                    </div><!--vcard_next_box-->
                    <?php
				}
			}
	}
			?>

       </div>
      <div class="seprator_9 clear"></div>  

 </div>
</div>  
<script type="text/javascript">
// DELETE TEMAIL FUNCTIONALITY //

function conformYesBox()
{ 
  $("#YesBoxWp").lightbox_me('center:true');
	
}

function closeBox(){
	
	$('#YesBoxWp').trigger('close');	
}


function deleteMail(confirmflag){
	if(confirmflag=='t'){
		deletTmailPopup();
		$('#YesBoxWp').trigger('close');
	}
	else{
		$('#YesBoxWp').trigger('close');	
	}			
}





              

// END 

</script>



<script>
	$(document).ready(function(){	
		$("#viewTmailList").validate({
			  submitHandler: function() {
				var fromData=$("#viewTmailList").serialize();
				fromData = fromData+'&ajaxHit=1';
				$.post(baseUrl+language+'/tmail/replyrequestWP',fromData, function(data) {
				  if(data){
					  $('#replayDiv').html('Your replay has been sent');
				  }
				});
			 }
		});
	});
</script>



