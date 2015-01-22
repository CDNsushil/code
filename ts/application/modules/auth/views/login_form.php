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
    'class'=>'pop_input user_name radius5 font_wN  email valid required ',
    'id'	=> 'AuthEmail',
    'maxlength'	=> 80,
    'size'	=> 30,
    'value'=>isset($_COOKIE['rememberMe']['login'])?$_COOKIE['rememberMe']['login']:'',
    'onChange'=>'checkEmail();',
    'onclick'      =>  "placeHoderHideShow(this,'Username','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Username','show')",
    'placeholder'  => "Username",
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
    'id'	=> 'password',
    //'class'	=> 'width_338 required formTip',
    'class'	=> 'pop_input pass_word radius5 font_wN required formTip',
    'maxlength'	=> 20,
    'minlength'	=> 4,
    'size'	=> 30,
    'value'=>isset($_COOKIE['rememberMe']['password'])?$_COOKIE['rememberMe']['password']:'',
    'onclick'         =>  "placeHoderHideShow(this,'Password','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Password','show')",
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
          checkfieldIdArray[1] = "#password";
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
           var password = $('#password').val();
           //var captcha = $('#captcha').val();
          var captcha = '';
          if ($('#remember').attr('checked')) {
          var remember = 1;
           }else{
          var remember = 0;
           }

           doLogin('<?php echo base_url($this->uri->uri_string());?>',AuthEmail,password,remember,captcha);
            /****hide when re-type**/
            $("#password").keypress(function(){
            $("#passwordMsg").hide();
          });
         }
      });	
});
</script>

<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
<div class="popup_box p0 bdr_none radius4" id="popup_box">
  <div class="close_btn position_absolute " onClick="$(this).parent().trigger('close')"></div>
  <div class="poup_bx p0 bdr_none bdr_b6b6 radius4">
     <div class="fb_popbx">
        <h4 class="fs32 opens_light lettsp-1p bdr_d6d6d6 text_alighC pt4 pb4 bgfafafa "> <?php echo strtoupper($this->lang->line('login'));?></h4>
        <div class="bdr_d6d6d6 pl36 defaultP  pr36 pb22  fs13 " >
            <?php echo form_input($login); ?>
            <span class="  dark_Grey" id="emailMsg">
            <?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
            </span>
            <?php echo form_password($password); ?>
            <span class="  dark_Grey" id="passwordMsg">
            <?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
            </span>
            <p class="f_password pt5 pb8 fs12 pl60 colr_999899"><a href="javascript:forgotPasswordPopup();">Forgot Password?</a></p>
            <label class="pl5">
            <?php echo form_checkbox($remember); ?>
            <span class=" pl24">Remember Me </span> </label>
            <div class="btn_wrap pt20 clearb">
               <button type="button"  onclick="$('#ajaxForm').submit();"  class=" bg_f5f5f5 width147 red m_auto display_block b_b9b9b9">Login</button> 
           </div>
           <p class="clearb text_alighC pt15 pb15 lineH12">OR</p>
           <button type="button" onclick="open_window('<?php echo getFacebookLoginUrl(); ?>'); $(this).parent().trigger('close');"  class=" fb_btn radius5 pl60 text_alighL  width_240 sign_btn text_alighC">Sign in with Facebook</button>
        </div>
        <div class=" mt38 clearb display_block text_alignC"> Not a member? Join Toadsquare for FREE. </div>
        <div class="btn_wrap pt23">
            <a href="<?php echo base_url(lang()."/package/packagestageone"); ?>">
            <button type="button"  class=" bg_f5f5f5 width147 red m_auto display_block b_b9b9b9">Join</button>
            </a>
        </div>
        <div class="text_alignC mt20 lett4"> <a href="<?php echo base_url(lang()."/package/packagestageone"); ?>">Membership Options</a></div>
     </div>
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
