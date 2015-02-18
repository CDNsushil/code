<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('genreManager');?></h1>
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
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_genre');?>"><?php echo $this->lang->line('genreHomeLink');?></a> 
		| 
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_genre/genre_manage');?>"><?php echo $this->lang->line('createGenre');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box" id="showGenreList">
		<?php 
			echo $this->load->view("genre_view_listing"); 
		?>
	</div>
</div>
<!--End Countrylist of title -->

<!-- Update status of Genre-->
<script>
function update_status(GenreId,status)
{
	var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
	var form_data = {GenreId:GenreId,
					status:status};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/manage_genre/updateStatus",
		data: form_data,
		success: function(res)
		{	
			window.location.href=BASEPATH+'manage_genre';
		}
	});
}
</script>
