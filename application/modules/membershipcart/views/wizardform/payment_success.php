<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$success_form = array(
	'name'=>'payment_success',
	'id'=>'payment_success'
);
// set base url
$baseUrl = base_url(lang().'/home');
?>	
	<div class="TabbedPanelsContent width635 m_auto"> 
		<!--start success content-->
		<div class="c_1 clearb">
			<h3 class=" fs21  bb_aeaeae"><?php echo $this->lang->line('thanksForPayment'); ?></h3>
			<h4 class="mt10"><?php echo $successContent ;?> </h4>
		</div>
		<!--end success content-->
		<div class="fr option_btn btn_wrap display_block mt10font_weight">
			<a href="<?php echo $baseUrl; ?>"><button class="b_F1592A next_click bdr_F1592A ">Finish </button></a>
		</div>
	</div>
