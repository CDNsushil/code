<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('categories_Manager_'.$type);?></h1>
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
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_categories/index/'.$type);?>" class="active_link"><?php echo $this->lang->line('genreHomeLinkcate');?></a> 
			| 
       		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_categories/sub_index/'.$type);?>"><?php echo $this->lang->line('genreHomeLinksubcate');?></a> 
    	
		</div>
	<!-- End top menu home link -->
		
	<!--Display country listing -->
	<div class="box" id="showGenreList">
        
        <div class="tds-button fl"> <a id="new" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_categories/category_manage/'.$type);?>"><span class="font_size13  dash_link_hover"><?php echo $this->lang->line('createGenreCategories');?></span></a></div>
        
		<?php 
			echo $this->load->view("category_view_listing"); 
		?>
	</div>
</div>
<!--End Countrylist of title -->

<!-- Update status of Genre-->
