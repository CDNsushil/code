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

<div class="poup_bx width329 shadow fshel_midum">
 <div onclick="$(this).parent().trigger('close')" class="close_btn position_absolute"></div>
 <h3 class="red fs21 fnt_mouse text_alighC pb10">Confirmation </h3>
 <div class="bdrb_afafaf"></div>
<P class="text_alighC mt20 fs14" ><?php echo $this->lang->line('deleteYourAccountAlert');?></p>
	<div class="fr mb10">
	   <?php echo form_open(base_url(lang().'/dashboard/deleteAccount'),$mcd); 
		echo form_input($deleteAccountInput); ?>
		   <button type="submit" class="bdr_bbb confirmyes"><?php echo $this->lang->line('delete');?></button></a>
		   <!--<button onclick="$(this).parent().trigger('close')" class="bg_ededed bdr_b1b1b1" type="button">Cancel</button>-->
	   <?php
	   echo form_close();
	   ?>
	</div>
 </div>
</div>


