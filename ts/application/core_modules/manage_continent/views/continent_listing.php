<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('continentManager');?></h1>
	<?php if($this->session->flashdata('error')){ ?>
	<div class="error">
		<?php echo $this->session->flashdata('error');?>
	</div>
	<?php }elseif($this->session->flashdata('msg')){ ?>
	<div class="msg">
		<?php echo $this->session->flashdata('msg');?>
	</div>
	<?php } ?>
		
	<div class="msg dn" id="admin_msg">
	</div>	
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_continent');?>"><?php echo $this->lang->line('continentHomeLink');?></a> |
		
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_continent/continent_manage');?>" ><?php echo $this->lang->line('createContinent');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box" id="showContinentList">
		<?php 
			echo $this->load->view("continent_listing_view"); 
		?>
	</div>
</div>
<!--End Countrylist of title -->

<!-- Update status of state-->
<script>
function update_status(continentId,status)
{
	var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
	var form_data = {continentId:continentId,
					status:status};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/manage_continent/updateStatus",
		data: form_data,
		success: function(res)
		{	
			window.location.href=BASEPATH+'manage_continent';
			$('#admin_msg').html(data);
		}
	});
}

/*Function to manage edit section */
$("#edit_c").click(function() {
	if($('#status').is(':checked') === false) {
		$("#status_check").removeClass("ez-checked");
	}else{
		$("#status_check").addClass("ez-checked");
	}
});

</script>
