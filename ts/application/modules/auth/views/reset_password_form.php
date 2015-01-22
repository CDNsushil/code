<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$LabelAttributes = array(
'class'=>'orng width90px'
);

$formAttributes = array(
'name'=>'customForm',
'id'=>'customForm',
'autocomplete'=>'off'
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'class'	=> 'width_338 required ',
	'title'=>$this->lang->line('auth_label_passwordValidation'),
	'minlength'	=> 8,
	'maxlength'	=> 20,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'equalTo'=> '#new_password',
	'title'=>$this->lang->line('auth_label_confirmPasswordValidation'),
	'class'	=> 'width_338 required',
	'minlength'	=> 8,
	'maxlength'	=> 20,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
);
?>
<!-- width_700 ma-->
<div class="seprator_5"></div>
<div class="popup_gredient ml5 mr5 ">
  <div class="width_566 ml20">
	<div class="seprator_10"></div>
	<div class="join_heading ml70 pt10"> <?php echo $this->lang->line('Change_Your_Password'); ?></div>
	<div class="pop_bdr"></div>
	<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
		<div class="position_relative">
		  <div class="cell shadow_wp strip_absolute left_170">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
			  <tbody>
				<tr>
				  <td height="59"><img src="<?php echo base_url('images/shadow-top-small.png');?>"></td>
				</tr>
				<tr>
				  <td class="shadow_mid_small">&nbsp;</td>
				</tr>
				<tr>
				  <td height="63"><img src="<?php echo base_url('images/shadow-bottom-small.png');?>"></td>
				</tr>
			  </tbody>
			</table>
			<div class="clear"></div>
		  </div>
		  <div class="seprator_20"></div>
		  <div class="row">
			<div class="join_label_wrapper width175px cell">
			  <label class="req_field">New Password</label>
			</div>
			<div class=" cell join_frm_element_wrapper">
			  <div class="row"><?php echo form_password($new_password); ?></div>
			</div>
			</div>
		  </div>
		  <div class="row">
			<div class="join_label_wrapper width175px cell">
			  <label class="req_field">Confirm New Password</label>
			</div>
			<div class=" cell join_frm_element_wrapper">
			 <?php echo form_password($confirm_new_password); ?>
			</div>
		  </div>
		  
		  <div class="clear"></div>
		  <div class="seprator_20"></div>
		  
			  <div class="row">
				 <div class="join_label_wrapper width175px cell">
				  &nbsp;
				</div>
				<div class=" cell join_frm_element_wrapper">
					<div class="tds-button Fleft">
					
					<div class="Req_fld  mt10"><?php echo $this->lang->line('requiredFields') ?>  </div>
					</div>	
					
				  <div class="tds-button Fright mr-3"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="submit" name="submit" type="submit" id="submitButton"><span><div class="Fleft"><?php echo $this->lang->line('auth_label_changePassword');?></div> <div class="icon-save-btn"></div></span></button></div>
				</div>
				  <div class="clear"></div>
			  </div>
		</div>
		
		
		<div class="row">
				 <div class="join_label_wrapper width175px cell">
				  &nbsp;
				</div>
				<div class=" cell join_frm_element_wrapper">
					<div class="tds-button Fleft">
					
					<div class="font_size12 mt5 ml20">* <?php echo $this->lang->line('descReqFieldMsg') ?>  </div>
					</div>	
					
				  
				  <div class="clear"></div>
			  </div>
		</div>
		
		<div class="seprator_20"></div>
	<?php echo form_close(); ?>
	<div class="seprator_24"></div>
  </div>



<div class="seprator_5"></div>
