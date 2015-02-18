<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(!isLoginUser()){
	$formAttributes = array(
		'name'=>'loginFormFrontEnd',
		'id'=>'loginFormFrontEnd',
	);
	$login = array(
		'name'	=> 'login',
		'id'	=> 'emailFrontEnd',
		'class'	=> 'font_opensansSBold',
		'value'=>isset($_COOKIE['rememberMe']['login'])?$_COOKIE['rememberMe']['login']:$this->lang->line('email'),
		'placeholder'=>$this->lang->line('email'),
		'title'=>$this->lang->line('emailValid'),
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('email')."','hide')",
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('email')."','show')"
	);
	$password = array(
		'name'	=> 'password',
		'id'	=> 'passwordFrontEnd',
		'class'	=> 'font_opensansSBold',
		'value'=>isset($_COOKIE['rememberMe']['password'])?$_COOKIE['rememberMe']['password']:$this->lang->line('password'),
		'placeholder'=>$this->lang->line('password'),
		'title'=>$this->lang->line('passwordValid'),
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('password')."','hide')",
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('password')."','show')"
	);
	$remember = array(
	'type'	=> 'hidden',
	'name'	=> 'remember',
	'id'	=> 'rememberFrontEnd',
	'value'	=> isset($_COOKIE['rememberMe']['login'])?1:0,
	//'checked'	=> isset($_COOKIE['rememberMe']['login'])?1:0,
	//'style' => 'margin:0;padding:0'
	);
	?>
	<script>
	$(document).ready(function(){
		$('#loginFormFrontEnd input').keypress(function (e) {
			if (e.which == 13) {
				var checkfieldIdArray = new Array();
				checkfieldIdArray[0] = "#emailFrontEnd";
				checkfieldIdArray[1] = "#passwordFrontEnd";
				submitFormOnEnter('#loginFormFrontEnd', checkfieldIdArray);
			}
		});
				/*
				*******************************************
				Custom Form validation
				*******************************************
				*/
				$("#loginFormFrontEnd").validate({
					// specifying a submitHandler prevents the default submit, good for the demo
					submitHandler: function() {
					  var email = $('#emailFrontEnd').val();
					   var password = $('#passwordFrontEnd').val();
					   //var captcha = $('#captcha').val();
					  var captcha = '';
					  var remember = $('#rememberFrontEnd').val();
					 /* if ($('#rememberFrontEnd').attr('checked')) {
						remember = 1;
					   }else{
						remember = 0;
					   }
					  */
					   var res= doLogin(baseUrl+language+"/auth/login",email,password,remember,captcha);
					   if(!res){
						   customAlert('<?php echo $this->lang->line('emailPasswordInvalidMsg')?>')
					   }
					 }
				});	
	});
	</script>
	<div class="comp_logjoincreatebg">
		<div class="wp_login_title fl mr5 lineH_imhe ml_7 mt13"><?php echo $this->lang->line('login')?></div>
		<?php echo form_open(base_url('/auth/login/'),$formAttributes); ?>
		<div class="login_input_bg width_139 fl ml5 mt13 login_input_bg_comp">
		  	<?php echo form_input($login); ?>
		</div>

		<div class="login_input_bg width_139 fl ml5 mt13 login_input_bg_comp">
			<?php echo form_password($password); ?>
		</div>
		
		<div class="fl mt4 ml8">
			<a href="javascript:void(0)" onclick="$('#loginFormFrontEnd').submit()"; onmousedown="mousedown_login_go_btn(this)" onmouseup="mouseup_login_go_btn(this)" class="login_go_btn log_button_overwrite"><?php echo $this->lang->line('login')?></a>
		</div>
		
		<div class="fl position_relative ml12">
			<div class="joinbtn_placing mt5 mr10">
			<a href="<?php echo base_url(lang().'/package'); ?>" onmousedown="mousedown_login_go_btn(this)" onmouseup="mouseup_login_go_btn(this)" class="login_go_btn log_button_overwrite"><?php echo $this->lang->line('join')?></a>
			</div>
				
			<div class="wp_login_title fl pl28 mt5"><?php echo $this->lang->line('join')?></div>
				
			<div class="login_input_bg mr10 ml10 mt13 bg_333333 login_input_bg_comp">
				  <div style="width:140px; height:20px;" class="temp_space"></div>
			</div>
		</div>
				
		<div class="fl font_opensansSBold font_size13 mt15 ml15"><a href="javascript:forgotPasswordPopup();"  class=" clr_white"><?php echo $this->lang->line('forgotten_password')?></a></div> 
		<div class="clear"></div>
		 <?php echo form_input($remember); ?>
		<?php echo form_close(); ?>
		</div>	
		
		 <div class="clear"></div>
	
		
<?php }	?>

