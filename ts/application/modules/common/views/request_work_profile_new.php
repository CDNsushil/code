<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'requestForm',
'id'=>'requestForm',
);
$where=array('purpose'=>'requestprofile','active'=>1);
$contactMeTemplateRes=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );

$fullName=LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
if($contactMeTemplateRes){
/*	$contactMeTemplate=$contactMeTemplateRes[0]->templates;
	$searchArray = array("{toName}", "{fromName}" , "{toadSquare}");
	$replaceArray = array($userFullName, $fullName, "toadsquare");
	$contactMeTemplate=str_replace($searchArray, $replaceArray, $contactMeTemplate); */
	$contactMeTemplate='';
}else{
	$contactMeTemplate='';
}


?>

<div class="poup_bx " id="requestProfileDiv">
    <?php echo form_open(base_url(lang().'/tmail/sendWorkApplication'),$formAttributes); ?>
     <input type="hidden" name="recipientsId" class="required" value="<?php echo $recipientsId ;?>">
       <div class="row width_451 pt10">
              <div class=" close_btn position_absolute" onclick="$(this).parent().trigger('close');"></div>
              <div class="fl width_114">
                 <div class="blog_profile_img">
                    <div class="AI_table">
                       <div class="AI_cell"> <img class="max_61X61" src="<?php echo $userImage;?>"> </div>
                    </div>
                 </div>
              </div>
              <div class=" display_inline_block width385 ">
                 <div class="clearbox pb15"><label class="fl pr10 arrow_label mr30"><?php echo $this->lang->line('from');?></label> <span class=" fl"><?php echo $fullName;?></span></div>
                 <?php echo form_hidden('subject', 'Request Work Profile'); ?>
                 <div class="clearbox pb15"><label class="fl pr10 arrow_label mr30">Subject</label> <span class=" fl"><?php echo $this->lang->line('reqWorkProfile');?></span></div>
              
                 <div class="clearbox pb15"><label class="fl pr10 arrow_label mr30"><?php echo $this->lang->line('Date');?></label> <span class=" fl"><?php echo currntDateTime('d F Y');?></span></div>
              </div>
              <div class="sap_15 bbd3d3d3"></div>
                <p class="pt10 fs12"> <span class=""><?php echo $this->lang->line('5To500words');?></span>
                 <span class="fr red five_words"><span class="inline" id="contactmeMessageLimit"><?php echo (str_word_count($contactMeTemplate));?></span>
				<span class="inline"> <?php echo $this->lang->line('words');?></span></span>
              </p>
              <?php 
                    //$contactMeTemplate=htmlentities($contactMeTemplate);
                    $contactmeMessageInput=array('name'=>'body',
                                                'id'=>'contactmeMessage',
                                                'value'=>$contactMeTemplate,
                                                'descLimit'=>'contactmeMessageDescLimit',
                                                'class'=>'  width480 bdr_bbb fl required ',
                                                'wordlength'=>'5,500',
                                                'cols'=>'90',
                                                'rows'=>'10',
                                                'onkeyup'=>"checkWordLen(this,500,'contactmeMessageLimit')"
                                                );
                                             
                    echo form_textarea($contactmeMessageInput);
                ?>
              <p>
                  <button type="submit">Send</button>
           </div>
        </div>
    <?php echo form_close(); ?>
</div>

<script>
	$(document).ready(function(){	
		$("#requestForm").validate({
			  submitHandler: function() {
				var fromData=$("#requestForm").serialize();
				fromData = fromData+'&ajaxHit=1';
				$.post(baseUrl+language+'/tmail/requestWorkProfile',fromData, function(data) {
				  if(data){
			         customAlert('<?php echo $this->lang->line('reqSentTo').' '.@$showUserName.'.';?>','Info');
                  }
				});
			 }
		});
	});
</script>
