<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $currentDashboardMethod = $this->router->method;?>
<div class="row">
	<div class=" cell frm_heading mt3">
		<h1>Dashboard</h1>
	</div>
	<div class="frm_btn_wrapper">
		<div class="tds-button-big fr mr11">
			<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(); ?>dashboard/globalsettings" ><span>Global Settings</span></a>
			<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(); ?>package/information/" ><span >Membership</span></a> </div>
	</div>
	<div class="clear"></div>
</div>
<div class="row line1 mr14"></div>
<div class="clear"></div>
<div class="seprator_5"></div>
<!-----patern--->
<div class="pt15 pb15 pl10 pr10 min_h1025 ">
	<div>
		<div class="dast_container_outer">
			<div class=" bg_dashbord_gred pall5">
			<?php $this->load->view('dashboard/dashboard_left_navigation');?>
			<?php $this->load->view($innerPage);?>
			<div class="clear"></div>
			</div>
			
		</div>
		<div class="dash_botton_shedow"> </div>
	</div>
	<div class="clear"></div>
	<?php $this->load->view('dashboard/dashboard_link');?>
	<div class="seprator_10"></div>
	<?php $this->load->view('dashboard/dashboard_app');?>
	<?php $this->load->view('dashboard/dashboard_toad_icon');?>
	<div class="clear"></div>
</div>
<div class="clear"></div>
