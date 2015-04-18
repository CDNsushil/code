<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$success_form = array(
	'name'=>'payment_success',
	'id'=>'payment_success'
);
$finishButton = array(
  'name'       =>  'finishButton',
  'id'         =>  'finishButton',
  'content'    =>  $this->lang->line('finish'),
  'class'      =>  'b_F1592A bdr_F1592A',
  'type'       =>  'button',
);
// set finish url
$finishUrl = formBaseUrl().DIRECTORY_SEPARATOR.$nextStep;
?>
	<div class="TabbedPanelsContent width635 m_auto"> 
		<?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.$nextStep,$success_form); ?>
			<!--start success content-->
			<div class="c_1 clearb">
				<h3 class=" fs21"><?php echo $this->lang->line('thanksForRenew'); ?></h3>
				
			</div>
			<!--end success content--> 
			<!--start button-->
			<div class="fr btn_wrap display_block font_weight">
				<a href="<?php echo $finishUrl;?>">
					<?php echo form_button($finishButton); ?>
				</a>
			</div>
			<!--start button-->
		<?php echo form_close();?> 
	</div>
