<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$formAttributes = array(
  'name'=>'ajaxFormForget',
  'id'=>'ajaxFormForget',
  'autocomplete'=>'off'
);
$login = array(
  'name'	=> 'login',
  'id'	=> 'loginforget',
  'value' => set_value('login'),
  'class'	=> 'search_box width300 bdr_bbb fl required email',
  //'title'=>$this->lang->line('auth_label_EmailValidation'),
  'maxlength'	=> 80,
  'size'	=> 30,
  'onclick'      =>  "placeHoderHideShow(this,'Email Address*','hide')",
  'onblur'       =>  "placeHoderHideShow(this,'Email Address*','show')",
  'placeholder'  => "Email Address*",
);
if ($this->config->item('use_username', 'tank_auth')) {
  $login_label = 'Email ID  or login';
} else {
  $login_label = 'Email ID';
}
  ?>
<script>
var sucess_show_msg = '<?php echo $this->lang->line('auth_message_new_password_sent');?>';
$(document).ready(function(){	
    $('#ajaxFormForget input').keypress(function (e) {
      if (e.which == 13) {
        var checkfieldIdArray = new Array();
        checkfieldIdArray[0] = "#loginforget";
        submitFormOnEnter('#ajaxFormForget', checkfieldIdArray);
      }
    });
    
    $("#ajaxFormForget").validate({
    // specifying a submitHandler prevents the default submit, good for the demo
      submitHandler: function() {
          var emailForget = $('#loginforget').val();
          forgotPassword('<?php echo base_url($this->uri->uri_string());?>',emailForget);
         // customAlert('<?php echo $this->lang->line('auth_message_new_password_sent');?>');
          //$('#forgetPassword').html("<div class='p40'><?php echo $this->lang->line('auth_message_new_password_sent');?></div>");
       }
    });	
    
    // hide error msg
    $("#loginforget").keyup(function(){
      $("#emailMsg").hide();
    });
       
      
});
</script>
  
<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>  
  <div class="poup_bx width329 shadow fshel_midum">
     <div class="close_btn position_absolute" onClick="$(this).parent().trigger('close')"></div>
     <h3 class="red fs21 fnt_mouse text_alighC pb10">
      <?php echo $this->lang->line('auth_label_forgotPassword')?>
     </h3>
     <div class="bdrb_afafaf mb20"></div>
     <div class="search_box_wrap mt30 mb0 ">
         <?php echo form_input($login); ?>
          <div id="emailMsg" class="dn"></div>
        <div class="fr mt20 mb20">
          <!-- <button type="button" class="bg_ededed bdr_b1b1b1 bdr_bbb" onClick="$(this).parent().trigger('close')"><?php //echo $this->lang->line('cancel')?></button>-->
           <button type="button" onclick="$('#ajaxFormForget').submit();" class="bdr_bbb"><?php echo $this->lang->line('submit')?></button>
        </div>
     </div>
  </div>
<?php echo form_close(); ?>

