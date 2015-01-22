<?php
$location2 =  $this->uri->segment(2);
$location5 =  $this->uri->segment(5);
$location3 =  $this->uri->segment(3);
$location4 =  $this->uri->segment(4);

$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";?>


<?php 
//Index page without offered/Wanted

if($location2=='work' && $location3=='' && $location4=='') { ?>
<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $constant['workOffered'];?></h1>
		</div>
		<div class="cell ml12">
			<div class="tds-button fr mr5">
			<?php echo anchor('work/wanted','<span>'.$constant["workWanted"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?>
			<?php echo anchor('work/workAppliedFor', '<span>'.$constant["workAppliedFor"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?>
			<?php echo anchor('work/workApplicationsReceived', '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?>
			</div>
		</div>
	</div>


<?php }

//deleted Items
 if($location2=='work' && $location3=='deletedItems') { ?>

<div class="row">
	<div class="cell frm_heading">
		<h1>
			<?php echo $constant['deletedItems']?>
		</h1>
	</div>
	<div class="frm_btn_wrapper mr10">
		<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType, '<span>'.$constant['indexPage'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>

<?php 
//Index page with offered

if($location2=='work' && $location3=='offered' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 Cat_wrapper">
		<h1 class="padding-top7">
			<?php echo $constant['workOffered'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button Fleft"><?php echo anchor('work/wanted','<span>'.$constant["workWanted"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workAppliedFor', '<span>'.$constant["workAppliedFor"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workApplicationsReceived', '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->

<?php }?>

<?php

//Index page with wanted
 if($location2=='work' && $location3=='wanted' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 Cat_wrapper">
		<h1><?php echo $constant['workWanted'];?></h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button Fleft"><?php echo anchor('work/offered','<span>'.$constant["workOffered"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workAppliedFor', '<span>'.$constant["workAppliedFor"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workApplicationsReceived', '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->

<?php }?>

<?php 
//Index page with workAppliedFor
if($location2=='work' && $location3=='workAppliedFor' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 Cat_wrapper">
		<h1 class="padding-top7">
			<?php echo $constant['workAppliedFor'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button Fleft"><?php echo anchor('work/offered','<span>'.$constant["workOffered"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/wanted', '<span>'.$constant["workWanted"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workApplicationsReceived', '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->

<?php }?>

<?php
//Index page with workApplicationsReceived

 if($location2=='work' && $location3=='workApplicationsReceived' && $location4=='') { ?>

<div class="row">
	<div class="cell width_200 Cat_wrapper">
		<h1 class="padding-top7">
			<?php echo $constant['workApplicationsReceived'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button Fleft"><?php echo anchor('work/offered','<span>'.$constant["workOffered"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/wanted','<span>'.$constant["workWanted"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<div class="tds-button Fleft"><?php echo anchor('work/workAppliedFor', '<span>'.$constant["workAppliedFor"].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->

<?php }?>


<?php
//Add (offered/Wanted) form

 if($location2=='work' && ($location3=='offered' || $location3=='wanted') && ($location4!='' && $location4==0)) { //echo "here";?>

<div class="frm_btn_wrapper">
		<div class="tds-button Fleft">
			
			<a href="javascript:void(0);"><span><?php echo $constant["promoImage"] ?></span></a>
			
			<a href="javascript:void(0);"><span><?php echo $constant["promoVideo"] ?></span></a>
				
			<?php echo anchor('work/'.$entityMediaType, '<span>'.$constant['indexPage'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?>
	</div>
</div><!--frm_btn_wrapper-->

<?php }?>

<?php
//Add (offered/Wanted) form

 if($location2=='work' && ($location3=='offered' || $location3=='wanted') && ($location4!=0) ){ ?>

<div class=" frm_btn_wrapper mr9">
	<div class="tds-button Fleft">
		<?php if($location5=='promotional_image') { ?>
			<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/promotional_information','<span>'.$constant['workInformation'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<?php }else{?>
			<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/promotional_image','<span>'.$constant['promoImage'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<?php }?>
		<?php if($location5=='promotional_video') { ?>
			<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/promotional_information','<span>'.$constant['workInformation'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>			
		<?php }else{?>
			<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/promotional_video', '<span>'.$constant['promoVideo'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
		<?php }?>
		<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType, '<span>'.$constant['indexPage'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
	</div>
</div><!--row-->
<?php }?>
<div class="row line1 mr11 width567px"></div>
<div class="row seprator_5"></div>


<?php
//New and deleted items tab this will come on all listing page
 if($location2=='work' &&($location3=='offered' || $location3=='wanted'|| $location3=='') && $location4=='') { ?>
	
	<div class="row position_relative">
		<?php echo Modules::run("common/strip"); ?>
		<div class="row">
		<div class=" cell  width_200 Cat_wrapper">&nbsp;</div>
		<div class="btn_outer_wrapper margin_left_16 width563px">
			<div class="fr">
				<div class="tds-button Fleft"><?php echo anchor('work/'.$entityMediaType.'/0/promotional_information','<span>'.$constant['new'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
				<div class="tds-button Fleft"><?php echo anchor('work/deletedItems/'.$entityMediaType, '<span>'.$constant['deletedItems'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)'));?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div><!--row-->

<?php }?>

