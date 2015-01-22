<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set form url
$absoluteFormUrl = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method());
?>
	
	<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
		<li class="TabbedPanelsTab" ><a href="<?php echo $absoluteFormUrl;?>"><span><?php echo $this->lang->line('showcaseStep1');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep2');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep3');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep4');?></span></a></li>
		<li class="TabbedPanelsTab TabbedPanelsTabSelected" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep5');?></span></a></li>
	</ul>
	<div class="TabbedPanelsContent width635 m_auto"> 
		<!--end sucesee-->
		 <div class="c_1 clearb">
			<h3 class=" fs21  bb_aeaeae"> <?php echo $this->lang->line('paymentNotThrough');?> </h3>
			<h4 class="mt10"><?php echo $this->lang->line('stage1PaymentError');?></h4>
		</div>
		<!--end suscess--> 
		<!--start Buuton-->
		<div class="fr btn_wrap display_block font_weight first_next">
			<a href="<?php echo $absoluteFormUrl;?>">
				<button class=" bg_ededed bdr_b1b1b1 mr5">Cancel</button>
			</a>
			<a href="<?php echo $absoluteFormUrl.'/purchasesummary';?>">
				<button class=" back back_click bdr_b1b1b1 mr5" >Back </button>
			</a>
		</div>
		<!--start button--> 
	</div>
