<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1>Country Manager</h1>
	<?php if($this->session->flashdata('error')){ ?>
	<div class="error">
		<?php echo $this->session->flashdata('error');?>
	</div>
	<?php }elseif($this->session->flashdata('msg')){ ?>
	<div class="msg">
		<?php echo $this->session->flashdata('msg');?>
	</div>
	<?php } ?>
		
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_countries');?>"><?php echo $this->lang->line('countryHomeLink');?></a> |
		
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_countries/manage_country');?>"><?php echo $this->lang->line('createCountry');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box" id="showCountryList">
		<?php 
			echo $this->load->view("country_listing_view"); 
		?>
	</div>
</div>
<!--End Countrylist of title -->

<!-- Update status of Country-->
<script>
function update_status(countryId,status)
{
	var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
	var form_data = {countryId:countryId,
					status:status};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/manage_countries/updateCountryStatus",
		data: form_data,
		success: function(res)
		{	
			window.location.href=BASEPATH+'manage_countries';
		}
	});
}
</script>
