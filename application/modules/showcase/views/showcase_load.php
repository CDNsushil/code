<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row form_wrapper">
<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $label['showcaseHomePageLabel'];?></h1>
	</div>
	<?php 
		echo Modules::run("showcase/menuNavigation", $values['showcaseId']); 
		//echo '<div class="row line1 mr11 width567px"></div>';
	?>
</div><!--row-end-->
<div id="newshowcase">
	<?php  $this->load->view('showcase/showcase_form',$values); ?>
</div>
</div><!-- End main row-->

<?php // ?>
