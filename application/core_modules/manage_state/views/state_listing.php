<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('stateManager');?></h1>
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
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_state');?>"><?php echo $this->lang->line('stateHomeLink');?></a> |
		
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_state/state_manage');?>"><?php echo $this->lang->line('createState');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box" id="showStateList">
		<?php 
			echo $this->load->view("state_listing_view"); 
		?>
	</div>
</div>
<!--End Countrylist of title -->

<!-- Update status of state-->
<script>
function update_status(stateId,status)
{
	var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
	var form_data = {stateId:stateId,
					status:status};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/manage_state/updateStatus",
		data: form_data,
		success: function(res)
		{	
			window.location.href=BASEPATH+'manage_state';
		}
	});
}
</script>
