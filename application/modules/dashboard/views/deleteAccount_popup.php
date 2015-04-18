<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$mcd = array(
	'name'=>'deleteAccountForm',
	'id'=>'deleteAccountForm'
);
$deleteAccountInput = array(
	'name'	=> 'deleteAccount',
	'type'	=> 'hidden',
	'id'	=> 'deleteAccount',
	'value'	=>'deleteAccount'
);
?>
<!--
<div class="poup_bx width329 shadow fshel_midum">
 <div onclick="$(this).parent().trigger('close')" class="close_btn position_absolute"></div>
 <h3 class="">Confirmation </h3>
<P class="text_alighC mt20 fs14" ><?php //echo $this->lang->line('deleteYourAccountAlert');?></p>
	<div class="fr mb10">
	   <?php //echo form_open(base_url(lang().'/dashboard/deleteAccount'),$mcd); 
		//echo form_input($deleteAccountInput); ?>
		   <button type="submit" class="bdr_bbb confirmyes"><?php echo $this->lang->line('delete');?></button></a>
		   <!--<button onclick="$(this).parent().trigger('close')" class="bg_ededed bdr_b1b1b1" type="button">Cancel</button>-->
	   <?php
	   //echo form_close();
	   ?>
	<!--</div>
 </div>
</div>
-->



<div class="poup_bx  shadow">
            <div class="close_btn position_absolute "  onclick="$(this).parent().trigger('close')" ></div>
            <h3 class="red fs21  text_alighC pb10"><?php echo $this->lang->line('deleteYourAccountNew1');?><br>
 <?php echo $this->lang->line('deleteYourAccountNew2');?></h3>
            <p class="mt17 fs16 pb15"><?php echo $this->lang->line('deleteYourAccountAlertNew');?></p>
    <?php echo form_open(base_url(lang().'/dashboard/deleteAccount'),$mcd); 
		echo form_input($deleteAccountInput); ?>
            <button type="button " class="bg_e70000 clr_fff"><?php echo $this->lang->line('delete');?></button>
           <?php
	   echo form_close();
	   ?>
          </div>


