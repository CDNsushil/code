<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row">
  <div class=" cell frm_heading mt3">
	<h1>Membership</h1>
  </div>
  <div class="frm_btn_wrapper">
	<div class="tds-button-big fr mr11">
		<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard'); ?>"><span >Dashboard </span></a>
		<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard/globalsettings'); ?>" ><span>Global Settings</span></a>
	</div>
  </div>
</div>
<div class="row line1 mr14"></div>
<div class="row seprator_5"></div>
<div class="row">
  <div class="main_project_heading">
	<div class="btn_outer_wrapper width_auto pl5 mr14 ml5">
	  <div class="fr">
		<div class="tds-button-big Fleft">
			<a href="<?php echo base_url(lang().'/package/information/'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Information</span></a>
			<a href="<?php echo base_url(lang().'/package/buytools/'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Buy Tools</span></a> 
			<a class="a_dash_navactive" href="#" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span class="span_dash_navactive" style="background-position: right 0px;">Purchases</span></a>
		</div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</div>
<div class="clear"></div>
<div class="row form_wrapper">
  <div class="row position_relative">
	<div class="cart_container_outer_solid ml0 mr0 mt2">
	  <div class="cart_container bg_white" id="showInbox">
			<?php $this->load->view('purchase_frame'); ?>
		</div>
	</div>
	
	<div class="clear"></div>
	<div class="seprator_10"></div>
  </div>
</div>
<div class="clear"></div>

