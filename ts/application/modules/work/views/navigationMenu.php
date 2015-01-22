<?php
$location2 =  $this->uri->segment(2);
$location5 =  $this->uri->segment(5);
$location3 =  $this->uri->segment(3);
$location4 =  $this->uri->segment(4);

$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";
$userId=isLoginUser();
$workApplicationsReceivedCount=countResult('WorkApplication',array('workOwnerId'=>$userId));
$workApplicationsReceivedCount=($workApplicationsReceivedCount > 0)?$workApplicationsReceivedCount:0;
$workApplicationsSentCount=countResult('WorkApplication',array('tdsUid'=>$userId));
$workApplicationsSentCount=($workApplicationsSentCount > 0)?$workApplicationsSentCount:0;

$hrefSent=($workApplicationsSentCount > 0)?'work/workAppliedFor':'javascript:void(0);';
$hrefReceived=($workApplicationsReceivedCount > 0)?'work/workApplicationsReceived':'javascript:void(0);';
$DCs=($workApplicationsSentCount > 0)?'':'disable_btn';
$DCr=($workApplicationsReceivedCount > 0)?'':'disable_btn';
$two_line =' class="two_line"';
?>


<?php 
//Index page without offered/Wanted

if($location2=='work' && $location3=='' && $location4=='') { ?>
<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $constant['workOfferedHeading'];?></h1>
		</div>
		<div class="cell ml12">
			<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/wanted','<span'.$two_line.'>'.$constant["workBRWanted"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
			</div>
			<div class="tds-button-big Fleft mr5 <?php echo $DCs?>">
			<?php echo anchor($hrefSent, '<span>'.$constant["appSent"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
			</div>
			
			<div class="tds-button-big Fleft mr5 <?php echo $DCr?>">
			<?php echo anchor($hrefReceived, '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
			</div>
			
		</div>
	</div>


<?php }

//deleted Items
 if($location2=='work' && $location4=='deletedItems') { ?>

<div class="row">
	<div class="cell frm_heading clr_red">
		<h1>
			<?php echo $constant['deletedItems']?>
		</h1>
	</div>
	<div class="frm_btn_wrapper mr10">
		<?php if($entityMediaType == 'offered') { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('work/'.$entityMediaType, '<span'.$two_line.'>'.$constant['workBROffered'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<?php } else { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('work/'.$entityMediaType, '<span'.$two_line.'>'.$constant['workBRWanted'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<?php } ?>
	</div>
</div><!--row-->


<?php }?>

<?php 
//Index page with offered

if($location2=='work' && $location3=='offered' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $constant['workOfferedHeading'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/wanted','<span'.$two_line.'>'.$constant["workBRWanted"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>		
		<div class="tds-button-big Fleft mr5 <?php echo $DCr?>">
			<?php echo anchor($hrefReceived, '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
		<div class="tds-button-big Fleft mr5 <?php echo $DCs?>">
			<?php echo anchor($hrefSent, '<span>'.$constant["appSent"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
	</div>
</div><!--row-->

<?php }?>

<?php

//Index page with wanted
 if($location2=='work' && $location3=='wanted' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1><?php echo $constant['workWantedHeading'];?></h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button-big Fleft mr5">
		<?php echo anchor('work/offered','<span'.$two_line.'>'.$constant["workBROffered"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)')); ?>
		</div>		
		<div class="tds-button-big Fleft mr5 <?php echo $DCr?>">
		<?php	echo anchor($hrefReceived, '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)')); ?>
		</div>
		<div class="tds-button-big Fleft mr5 <?php echo $DCs?>">
		<?php	echo anchor($hrefSent, '<span>'.$constant["appSent"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)')); ?>
		</div>
	</div>
</div><!--row-->

<?php }?>

<?php 
//Index page with workAppliedFor
if($location2=='work' && $location3=='workAppliedFor' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $constant['appSent'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/offered','<span'.$two_line.'>'.$constant["workBROffered"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>			
		<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/wanted', '<span'.$two_line.'>'.$constant["workBRWanted"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
		<div class="tds-button-big Fleft mr5 <?php echo $DCr?>">
			<?php echo anchor($hrefReceived, '<span>'.$constant["workApplicationsReceived"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>		
	</div>
</div><!--row-->

<?php }?>

<?php
//Index page with workApplicationsReceived

 if($location2=='work' && $location3=='workApplicationsReceived' && $location4=='') { ?>

<div class="row">
	<div class="cell frm_heading">
		<h1 class="padding-top7">
			<?php echo $constant['workApplicationsReceived'];?>
		</h1>
	</div>
	<div class="cell ml12">
		<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/offered','<span '.$two_line.'>'.$constant["workBROffered"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
			<div class="tds-button-big Fleft mr5">
			<?php echo anchor('work/wanted','<span '.$two_line.'>'.$constant["workBRWanted"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
			<div class="tds-button-big Fleft mr5 <?php echo $DCs?>">
			<?php echo anchor($hrefSent, '<span>'.$constant["appSent"].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
			</div>
	</div>
</div><!--row-->

<?php }?>


<?php
//Add (offered/Wanted) form

 if($location2=='work' && ($location3=='offered' || $location3=='wanted')  && ($location4!='' && $location4==0 && $location4!='deletedItems')) { //echo "here";?>

<div class="frm_btn_wrapper">	
			
		<div class="tds-button-big Fleft disable_btn"><a href="javascript:void(0);"><span class="two_line"><?php echo $constant["promotionalBRMaterial"] ?></span></a></div>
		<?php if($entityMediaType == 'offered') { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('work/'.$entityMediaType, '<span class="two_line">'.$constant['workOfferedIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>			
		<?php } else { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('work/'.$entityMediaType, '<span class="two_line">'.$constant['workWantedIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<?php } ?>
</div><!--frm_btn_wrapper-->

<?php }?>

<?php
//Add (offered/Wanted) form

 if($location2=='work' && ($location3=='offered' || $location3=='wanted') && ($location4!=0) ){ 
	if($entityMediaType == 'offered') $workDescriptionHeading = $constant['workOfferedBRDesc'];
	else $workDescriptionHeading = $constant['workWantedBRDesc'];
?>

<div class=" frm_btn_wrapper mr9">
	<div class="tds-button-big Fleft">
		<?php if($location5=='promotional_image') { ?>
			<?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/description','<span class="two_line">'.$workDescriptionHeading.'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php }else{?>
			<?php echo anchor('work/'.$entityMediaType.'/'.$workId.'/promotional_image','<span class="two_line">'.$constant['promotionalBRMaterial'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php }?>
		
		<?php 
		if($entityMediaType == 'offered')
			echo anchor('work/'.$entityMediaType,  '<span class="two_line">'.$constant['workOfferedIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		else
			echo anchor('work/'.$entityMediaType, '<span class="two_line">'.$constant['workWantedIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		?>
		
	</div>
</div><!--row-->
<?php } ?>
<div class="row line1 mr11 width567px"></div>

<?php
//New and deleted items tab this will come on all listing page
 if($location2=='work' &&($location3=='offered' || $location3=='wanted'|| $location3=='') && $location4=='') { 
?>
	<div class="row seprator_5"></div>
	
	
	<div class="row">
		<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
		<div class="btn_outer_wrapper fr width_auto pl5 mr14">
			<div class="fr">
				<div class="tds-button-big Fleft">
					<?php 
					$sectionId=$this->config->item('worksSectionId');
					$newsHref='javascript:getUserContainers(\''.$sectionId.'\',\'/work/'.$entityMediaType.'/0/description\');'; ?>
					<a onmouseover="mouseover_big_button(this)" onmouseup="mouseup_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo $newsHref;?>"><span><?php echo $this->lang->line('new');?></span></a>
					<?php echo anchor('work/'.$entityMediaType.'/deletedItems', '<span class="two_line">'.$constant['deletedBRItems'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div><!--row-->
	
	
<?php 
	}
?>
	<div class="row position_relative">
			<?php echo Modules::run("common/strip"); ?>
	</div>
<div class="row seprator_5"></div>
