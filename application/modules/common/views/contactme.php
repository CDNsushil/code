<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'contactForm',
'id'=>'contactForm',
);
$where=array('purpose'=>'contactme','active'=>1);
$contactMeTemplateRes=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );

$fullName=LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
if($contactMeTemplateRes){
	//$contactMeTemplate=$contactMeTemplateRes[0]->templates;
	//$searchArray = array("{toName}", "{fromName}" , "{toadSquare}");
	//$replaceArray = array($userFullName, $fullName, "toadsquare");
	//$contactMeTemplate=str_replace($searchArray, $replaceArray, $contactMeTemplate);
	$contactMeTemplate='';
}else{
	$contactMeTemplate='';
}


?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient bg_f3f3f3" id="contactMeDiv">
  <div class="seprator_14"></div>
  <?php echo form_open(base_url(lang().'/tmail/sendTmail'),$formAttributes); ?>
  <input type="hidden" name="recipientsId" class="required" value="<?php echo $userId;?>">
  <div class="bdr_d2d2d2 Contact_form_topbox ml15 mr14 position_relative fntclr_drkGrey">
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
    <div class="seprator_13"></div>
    	<div class="text_alignC font_opensans font_size18"><?php echo $this->lang->line('viaContactMe');?></div>
        <div class="seprator_20"></div>
        <div class="w69_h66 margin_auto"><div class="AI_table"><div class="AI_cell"><img src="<?php echo $userImage;?>" class="Contact_form_thumb" /></div></div></div>
    
    </div>
    <div class="cell pt20">
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('from');?></label>
            </div>
            <div class="cell contact_frm_element_wrapper">
              <span class="pt7"><?php echo $fullName;?></span>	
            </div>
          </div>
           <!-- row01-->
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('subject');?></label>
            </div>
            <div class="cell contact_frm_element_wrapper">
              <input type="text" name="subject" class="required">
            </div>
          </div>
           <!-- row01-->
    	<div class="row">
            <div class="contact_label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('Date');?></label>
            </div>
            <div class="cell contact_frm_element_wrapper">
              <span class="pt7"><?php echo currntDateTime('d F Y');?></span>
            </div>
          </div>
    </div>
    <div class="clear"></div>
  </div>
    <div class="seprator_14"></div>
    <div class="textarea_small_bg_with_border ml15 mr14 contact_texta borderNone">
		<?php 
			//$contactMeTemplate=htmlentities($contactMeTemplate);
			$contactmeMessageInput=array('name'=>'body',
										 'id'=>'contactmeMessage',
										 'value'=>$contactMeTemplate,
										 'descLimit'=>'contactmeMessageDescLimit',
										 'class'=>'textarea_small font_arial w570_h360 required rz add_textarea_border_class',
										 'wordlength'=>'5,500',
										 'onkeyup'=>"checkWordLen(this,500,'contactmeMessageLimit')"
									    );
									 
			echo form_textarea($contactmeMessageInput);
		?>
	</div>
	<div id="word_counter" class="row wordcounter">
		    <span class="tag_word_orange mt5 clr_666 font_size11 ml30 orange_clr_imp"><?php echo $this->lang->line('5To500words');?></span>
			<span class="five_words mt5" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span class="inline" id="contactmeMessageLimit"><?php echo (str_word_count($contactMeTemplate));?></span>
				<span class="inline"> <?php echo $this->lang->line('words');?></span>
			 </span>
    </div>
	<div class="seprator_14"></div>
	<div class="clear"></div>
    <div class="Fright mt14">
    <div class="tds-button Fright mr9"> <button type="button" onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Close</div> 
    <!--<div class="icon-save-btn">--><div class="icon-form-close-btn"></div> </span> </button>  </div>
      <div class="tds-button Fright"><button type="submit" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft">Send</div> <div class="send_button"></div></span> </button> </div>
      <div class="clear"></div>
    </div>
    <?php echo form_close(); ?>
    <div class="seprator_9 clear"></div>
</div>
<script>
	$(document).ready(function(){	
		$("#contactForm").validate({
			  submitHandler: function() {
				var fromData=$("#contactForm").serialize();
				fromData = fromData+'&ajaxHit=1';
				$.post(baseUrl+language+'/tmail/sendTmail',fromData, function(data) {
				  if(data){
					  $('#contactMeDiv').html('<div class="p10"><?php echo $this->lang->line('meassageSent').' '.@$userFullName.'.';?></div>');
				  }
				});
			 }
		});
	});
</script>