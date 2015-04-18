<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if(!isLoginUser()){
	$CheckBoxLabelAttributes = array(
		'class'=>' fr loginCheckBox'
	);
	$formAttributes = array(
		'name'=>'loginFormFrontEnd',
		'id'=>'loginFormFrontEnd',
		'autocomplete'=>'off'
	);
	$login = array(
		'name'	=> 'login',
		'id'	=> 'emailFrontEnd',
		'value'=>isset($_COOKIE['rememberMe']['login'])?$_COOKIE['rememberMe']['login']:$this->lang->line('email'),
		'placeholder'=>$this->lang->line('email'),
		'title'=>$this->lang->line('emailValid'),
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('email')."','hide')",
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('email')."','show')"
	);
	$password = array(
		'name'	=> 'password',
		'id'	=> 'passwordFrontEnd',
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
	<div id="loginboxFrontend" class="mt-5" >
		
		<div class="wp_login_title"><?php echo $this->lang->line('login')?></div>
		<div class="seprator_5"></div>
		<?php echo form_open(base_url('auth/login/'),$formAttributes); ?>
			<div class="pl10 pr10">
			  <div class="login_input_bg">
				<?php echo form_input($login); ?>
				
			  </div>
			  <div class="seprator_5"></div>
			  <div class="login_input_bg">
				<?php echo form_password($password); ?>
				
			  </div>
			</div>
			
			<div class="row">
				<div class="cell pl10 width_88px">
					<a href="javascript:void(0)" onclick="$('#loginFormFrontEnd').submit()"; onmousedown="mousedown_login_go_btn(this)" onmouseup="mouseup_login_go_btn(this)" class="login_go_btn a_darkorange"><?php echo $this->lang->line('login')?></a><span class=""></span>
				</div>
				<div class="cell pt6">
						<!--<a href="<?php echo getFacebookLoginUrl(); ?>" onclick="return openLightBoxWithoutAjax('popupBoxWp','popup_box');" onmousedown="mouseup_fbloginB(this)" onmouseup="mouseup_fblogin(this)" class="fbbutton_toad_login" ></a>-->
						<a href="javascript:void(0);" onclick="open_window('<?php echo getFacebookLoginUrl(); ?>');" onmousedown="mouseup_fbloginB(this)" onmouseup="mouseup_fblogin(this)" class="fbbutton_toad_login" ></a>
				</div>
			</div>
					
		  <?php echo form_input($remember); ?>
		<?php echo form_close(); ?>
		<div class="clear"></div>
		<div class="white pl10 f12 mt4 mb9 "><a class="font_opensansSBold forgotten_pass a_darkorange" href="javascript:forgotPasswordPopup();"  ><?php echo $this->lang->line('forgotten_password')?></a></div>
		<div class="joinbtn_placing mt-12"><a href="<?php echo base_url(lang().'/package'); ?>" onmousedown="mousedown_login_go_btn(this)" onmouseup="mouseup_login_go_btn(this)" class="login_go_btn a_darkorange"><?php echo $this->lang->line('join')?></a></div>
		<div class="clear"></div>
		<div class="wp_login_title join_rgba_new">
			<?php echo $this->lang->line('join')?>
		</div>
		<div class="clear"></div>
		<!--<div class="join_rgba mr10 ml10 mt3">
		  <div style="width:140px; height:20px;" class="temp_space"></div>
		</div>	-->
		<div class="seprator_3"></div>
	</div>
	<?php
}
/*
?>

<div class="fbButtondiv">
	<div id="fb-root"></div>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
			FB.init({appId: '1381297055428704', status: true, cookie: true, xfbml: true});

			
			FB.Event.subscribe('auth.login', function(response) {
				// do something with response
				fblogin();
			});
			
			FB.login(function(response) 
			{
				if (response.authResponse) 
				{
					alert('Logged in and accepted permissions!');
				}
			}, {scope:'publish_stream'});
			
		};
		
		(function() {
			var e = document.createElement('script');
			e.type = 'text/javascript';
			e.src = document.location.protocol +
				'//connect.facebook.net/en_US/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		}());

		function fblogin(){
			document.location.href = "<?php echo getFacebookLoginUrl();?>";
		}				
	</script>

	<p>
		<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>
	</p>

</div> 
<?php
*/
