<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$success_form = array(
	'name'=>'payment_success',
	'id'=>'payment_success'
);
// set base url
$baseUrl = formBaseUrl(); 
?>	
	<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep1');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep2');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep3');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep4');?></span></a></li>
		<li class="TabbedPanelsTab TabbedPanelsTabSelected" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep5');?></span> </a></li>
	</ul>
	<div class="TabbedPanelsContent width635 m_auto"> 
		<?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.$nextStep,$success_form); ?>
			<!--start success content-->
			<div class="c_1 clearb">
				<h3 class=" fs21  bb_aeaeae"><?php echo $this->lang->line('thanksForPayment'); ?></h3>
				<h4 class="mt10"><?php echo $successContent ;?> </h4>
			</div>
			<!--end success content--> 
			<!--start button-->
			<?php
            $data['cancelUrl'] = site_url(lang().'/media/'.$industry.'/'.$projId);
			$data['backUrl']   = 0;
			$this->load->view('common_view/common_buttons',$data);
			?>
			<!--start button-->
		<?php echo form_close();?> 
	</div>
