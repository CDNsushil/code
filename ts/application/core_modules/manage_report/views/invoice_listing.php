<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('admin_invoice_manager'); ?></h1>
		
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_report');?>"><?php echo $this->lang->line('countryHomeLink');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box pl20" id="showCountryList">
		<?php 
			echo $this->load->view("invoice_listing_view"); 
		?>
	</div>
</div>

