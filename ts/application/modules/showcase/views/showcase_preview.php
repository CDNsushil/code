<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
//echo '<pre />Gurutva Singh:';
//print_r($object);die;

?>
<div class="row">
<div class="cell">
	<span style="font-size:18px; font-weight:bold"><?php echo $object['firstName'].' '.$object['lastName'];?></span>
<?php echo $object['optionAreaName'];?>
</div>
</div>


<div class="row heightSpacer"> &nbsp;</div>

<div class="row">
	<div class="cell dblBorder" style="min-width:300px;max-width:300px; padding:5px;">
		<div class="row"><div class="cell"><strong><?php echo $labelFocus;?></strong></div></div>
		<div class="row"><div class="cell"><?php echo $object['creativeFocus'];?></div></div>
	</div>
	<div class="cell" style="padding-left:10px;">&nbsp;</div>
		<div class="cell dblBorder" style="min-width:500px;max-width:500px; padding:5px;">
		<div class="row"><div class="cell"><strong><?php echo $labelPath;?></strong></div></div>
		<?php echo $object['creativePath'];?>
	</div>
</div><!-- End Row -->

<div class="row heightSpacer"> &nbsp;</div>

<div class="row">
	<div class="cell dblBorder" style="min-width:600px;max-width:600px; padding:5px;">	
		<?php echo $object['promotionalsection'];?>
	</div>
	<div class="cell" style="padding-left:10px;">&nbsp;</div>
	<div class="cell dblBorder" style="min-width:200px;max-width:200px; padding:5px;">
		<?php //echo Modules::run("showcase/showcaseNewsPreview/"); ?> 
		<?php // echo Modules::run("showcase/showcaseReviewsPreview"); ?> 
		<?php //echo Modules::run("showcase/showcaseAwardsPreview"); ?> 
		<?php //echo Modules::run("showcase/showcaseSocialNetPreview"); ?>
		
	</div>
</div><!-- End Row -->

<div class="row heightSpacer"> &nbsp;</div>
