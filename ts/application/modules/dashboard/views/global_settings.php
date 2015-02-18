<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="wizard_wrap fs14 ">
		<div id="TabbedPanels1" class="TabbedPanels golbal_wrap ">

			<!-- ================================main tab mmenu ======================= -->

			<ul class="TabbedPanelsTabGroup mb10 position_relative z_index_3 " id="man_haedtab" >
					<li class="TabbedPanelsTab <?php echo $msmh;?>" ><a href="<?php echo base_url(lang().'/dashboard/globalsettings/1')?>"><span>Membership Settings</span></a></li>
					<li class="TabbedPanelsTab <?php echo $socialmh;?>"><a href="<?php echo base_url(lang().'/dashboard/globalsettings/2')?>"> <span>Social Media Sites</span></a></li>
					<li class="TabbedPanelsTab <?php echo $buyermh;?>"><a href="<?php echo base_url(lang().'/dashboard/globalsettings/3')?>"><span>Buyer Settings</span></a></li>
					<li class="TabbedPanelsTab <?php echo $sellermh;?>"><a href="<?php echo base_url(lang().'/dashboard/globalsettings/4')?>"><span>Seller Settings</span></a></li>
			</ul>
			<!-- ================================main tab content Start ======================= -->
			<?php 
			$this->load->view('dashboard/'.$innerPage);
			?>
			<!-- ================================main tab content End ======================= -->
		</div>
	</div>
</div>
<!--  content wrap  end --> 
