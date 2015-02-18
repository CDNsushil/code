<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL" class="minHeight600px">
	<h1><?php echo $this->lang->line('tmailManager');?></h1>
	<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail');?>">Home </a>|
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail/compose_tmail');?>"><?php echo $this->lang->line('composeTmail');?></a>
	</div>
	<!-- End box language -->
	<div class="box" id="showUserList">
		<?php 
			echo $this->load->view("tmail_listing"); 
		?>
	</div>
</div>

