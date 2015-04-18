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
	'class'	=> 'width417 required ',
	'title'=>$this->lang->line('auth_label_passwordValidation'),
	'minlength'	=> 8,
	'maxlength'	=> 20,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    'placeholder'=>'New Password *',
    'onclick'         =>  "placeHoderHideShow(this,'New Password *','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'New Password *','show')",
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'equalTo'=> '#new_password',
	'title'=>$this->lang->line('auth_label_confirmPasswordValidation'),
	'class'	=> 'width417 required',
	'minlength'	=> 8,
	'maxlength'	=> 20,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    'placeholder'=>'Confirm New Password *',
    'onclick'         =>  "placeHoderHideShow(this,'Confirm New Password *','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Confirm New Password *','show')",
);
?>
<!-- width_700 ma-->
<div class="seprator_5"></div>
 <div class="width635 m_auto  wizard_wrap  display_table"> 
 
        <h3>
        <?php echo $this->lang->line('Change_Your_Password'); ?>
        </h3>
        <?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
        <ul class="listpb20 mt30 width445">
        <li><?php echo form_password($new_password); ?></li>
        <li><?php echo form_password($confirm_new_password); ?></li>
        
        <li>
         <button  value="submit" name="submit" type="submit" id="submitButton" class="fr"><?php echo $this->lang->line('auth_label_changePassword');?></button>
        </li>
        
        
        </ul>
        <?php echo form_close(); ?>
    </div>
     <div class="clear"></div>


<div class="sap_40"></div>
