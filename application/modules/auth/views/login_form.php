<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
  $CheckBoxLabelAttributes = array(
  'class'=>' fr loginCheckBox'
  );

  $formAttributes = array(
  'name'=>'ajaxForm',
  'id'=>'ajaxForm',
  'autocomplete'=>'off'
  );
  $login = array(
    'name'	=> 'login',
   // 'class'=>'width_338 required email form formTip',
    'class'=>'user_name  font_wN email valid required ',
    'id'	=> 'AuthEmail',
    'maxlength'	=> 80,
    'size'	=> 30,
    'value'=>isset($_COOKIE['rememberMe']['login'])?$_COOKIE['rememberMe']['login']:'',
    'onChange'=>'checkEmail();',
    'onclick'      =>  "placeHoderHideShow(this,'Email Address','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Email Address','show')",
    'placeholder'  => "Email Address",
  );

  if ($login_by_username AND $login_by_email) {
    $login_label = 'Email or login';
  } else if ($login_by_username) {
    $login_label = 'Login';
  } else {
    $login_label = 'Email';
  }
  $password = array(
    'name'	=> 'password',
    'id'	=> 'password_log',
    //'class'	=> 'width_338 required formTip',
    'class'	=> 'pass_word font_wN required ',
    'maxlength'	=> 20,
    'minlength'	=> 4,
    'size'	=> 30,
    'value'=>isset($_COOKIE['rememberMe']['password'])?$_COOKIE['rememberMe']['password']:'',
    'onclick'         =>  "placeHoderHideShow(this,'password','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'password','show')",
    'placeholder'     =>  "Password"
  );
  $remember = array(
    'name'	=> 'remember',
    'id'	=> 'remember',
    'value'	=> 1,
    'checked'	=> isset($_COOKIE['rememberMe']['login'])?1:0,
    'style' => 'margin:0;padding:0'
  );
  $captcha = array(
    'name'	=> 'captcha',
    'id'	=> 'captcha',
    'class'	=> 'width_338 required',
    'title'=>$this->lang->line('auth_label_enterTheWordsAbove'),
    'minlength'	=> 8,
    'maxlength'	=> 8,
    'size'	=> 30
  );
?>
<script>
$(document).ready(function(){
      $('#ajaxForm input').keypress(function (e) {
        if (e.which == 13) {
          var checkfieldIdArray = new Array();
          checkfieldIdArray[0] = "#AuthEmail";
          checkfieldIdArray[1] = "#password_log";
          submitFormOnEnter('#ajaxForm', checkfieldIdArray);
        }
      });		
      
      runTimeCheckBox();
      /*
      *******************************************
      Custom Form validation
      *******************************************
      */
      $("#ajaxForm").validate({
        // specifying a submitHandler prevents the default submit, good for the demo
        submitHandler: function() {
          var AuthEmail = $('#AuthEmail').val();
           var password = $('#password_log').val();
           //var captcha = $('#captcha').val();
          var captcha = '';
          if ($('#remember').attr('checked')) {
          var remember = 1;
           }else{
          var remember = 0;
           }

           doLogin('<?php echo base_url($this->uri->uri_string());?>',AuthEmail,password,remember,captcha);
            /****hide when re-type**/
            $("#password_log").keypress(function(){
            $("#passwordMsg").hide();
          });
         }
      });	
});
</script>

<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
<div class="poup_bx width288 pl_38  radius5" id="popup_box">
    <div class="close_btn position_absolute" onClick="$(this).parent().trigger('close')"></div>
    <div class="width245 login_index  m_auto">
        <?php echo form_input($login); ?>
        <span class="  dark_Grey" id="emailMsg">
            <?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
        </span>
        <?php echo form_password($password); ?>
        <span class="  dark_Grey" id="passwordMsg">
            <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
        </span>
       <button class="bg_f1592a  mt5 fs25" type="submit"  onclick="$('#ajaxForm').submit();" >Login   </button>       
       <button class=" radius5 fs16 fb_btn " type="button" onclick="javascript:openLightBox('popupBoxWp','popup_box','/package/termsncondition'); $(this).parent().trigger('close');" >Sign in with Facebook</button>        
       <label class="pl10 defaultP fl">
             <?php echo form_checkbox($remember); ?>
          <span class=" pl22 pt3 clr_666">Stay signed in </span>
       </label>
       <p class="f_password mt3  pl58 fl clearb">
          <a href="javascript:forgotPasswordPopup();" class="clr_666">Forgot Password?</a>
       </p>
       <div class="open_sans mt12 fs16 mb0 or_border" >OR</div>
       <div class="pt20 pb22 clearb open_sans display_block text_alignC"> Join Toadsquare for FREE. </div>
       <a href="<?php echo base_url(lang()."/package/packagestageone"); ?>"><button type="button" class="green_btn pb5 fs25imp">Join</button></a>        
    </div>
 </div>
      
<?php echo form_close(); ?>  
  
<script type="text/javascript">
 
  function checkEmail(){
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test($('#AuthEmail').val()))
      $('#emailMsg').hide();
    else
      $('#emailMsg').show();
  }
  
  //show check box using run time
  runTimeCheckBox()
  
  //on focus on login button
  setTimeout(function(){
    $('#AuthEmail').focus();
  },1000);
  
 
</script>
