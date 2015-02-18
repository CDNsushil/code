<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('langManager');?></h1>
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
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_lang');?>"><?php echo $this->lang->line('langHomeLink');?></a> |
		
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_lang/language_manage');?>" ><?php echo $this->lang->line('createLanguage');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display Language listing -->
	<div class="box" id="showLangList">
		<?php 
			echo $this->load->view("lang_listing_view"); 
		?>
	</div>
</div>
<!--End Language listing -->

