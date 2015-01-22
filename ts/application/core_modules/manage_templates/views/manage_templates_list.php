<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL">
	<h1><?php echo $heading;?></h1>
	<div class="box menu">
			<a href="#">Home</a>
	</div>
	<div class="box language">
		<div id="contentLeft">
			<ul class="ui-sortable">
			<li id="recordsArray_10">
				<a class="get_link" href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_templates');?>" >Email Templates</a>
			</li>
			<li id="recordsArray_10">
				<a class="get_link" href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_templates/tmail_tmp');?>" >Tmail Templates</a>
			</li>
			</ul>
		</div>
	</div><!-- End box language -->
	<div class="box files" id="showTemplateList">
		<?php 
			echo $this->load->view("template_list"); 
		?>
	</div>
</div>
