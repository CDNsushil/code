<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- TOP NAVIGATION-->
	<span class="clear_seprator "></span>
	<div   class="title-content-center-label">
		<?php echo $label['upcomingProjectDetail']?>
	</div><!-- End title-content-->
	<div class="clear_seprator"> &nbsp;</div>
	<div class="frm_wp" style="width:480px">
		<div class="row">
			<div class="cell orng_lbl"><?php echo $label['projectTitle'];?>:</div>
			<div class="cell" >
				<?php echo $projTitle; ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>
		<div class="row">
			<div class="cell orng lh16"><?php echo $label['oneLineDescription'];?>:</div>
			<div class="cell pop_right_text" ><?php echo $proShortDesc; ?></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>
		<div class="row">
			<div class="cell orng lh16"><?php echo $label['Tags'];?>:</div>
			<div class="cell pop_right_text" ><?php echo $projTag; ?></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>
		<div class="row">
			<div class="cell orng lh16"><?php echo $label['FurDescription'];?>:</div>
			<div class="cell pop_right_text" ><?php echo $projDescription; ?></div>
		</div>
		<?php
		if(isset($projUpType) && $projUpType!=''&& $projUpType!=0)
		{
		?>
		<div class="clear_seprator"> &nbsp;</div>
		<div class="cell orng_lbl lh16"><?php echo $this->lang->line('variety');?>:</div>
			<div class="cell pop_right_text" >
			<?php 
			if($projUpType==1) 
				echo $this->lang->line('EducationalMaterial');
			if($projUpType==2) 
				echo $this->lang->line('perOrEvent');
			if($projUpType==3) 
				echo $this->lang->line('mediaProject');
			?>
		</div>
		<?php 
		}
		?>
		<div class="clear_seprator"> &nbsp;</div>
		<div class="cell orng_lbl lh16"><?php echo $label['Industry'];?>:</div>
			<div class="cell pop_right_text" ><?php $projIndustryName = getFieldValueFrmTable('IndustryName','MasterIndustry','IndustryId',$projIndustry);
			echo $projIndustryName[0]->IndustryName;?>
</div>


		<div class="clear_seprator"> &nbsp;</div>
		<div class="cell orng_lbl lh16"><?php echo $label['Language'];?> :</div>
			<div class="cell pop_right_text" ><?php echo getLanguage($projLanguage);?></div>

		<div class="clear_seprator"> &nbsp;</div>
<?php /*
		<?php  if($projAddress !='') { ?>
		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['address'];?>:</div>
			<div class="cell pop_right_text" >
				<?php echo $projAddress;  ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>
		<?php }?>

		<?php  if($projStreet !='') { ?>
		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['street'];?>:</div>
			<div class="cell pop_right_text" >
				<?php echo $projStreet;  ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>

		<div class="clear_seprator"> &nbsp;</div>
		<?php }?>
		<div class="cell orng_lbl lh16"><?php echo $label['country'];?>:</div>
		<div class="cell pop_right_text" ><?php echo getCountry($projCountry);?></div>

		<div class="clear_seprator"> &nbsp;</div>
		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['city'];?>:</div>
			<div class="cell pop_right_text" >
				<?php echo $projCity; ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>

		<?php  if($projZip!='') {?>
		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['zipcode'];?>:</div>
			<div class="cell pop_right_text" >
				<?php echo $projZip; ?>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<div class="clear_seprator"> &nbsp;</div>
		<?php } ?>
*/?>
		<div class="cell orng_lbl lh16"><?php echo $label['ReleaseDate'];?>:</div>
		<div class="cell pop_right_text" style="margin-right:10px">
			<?php //echo $projReleaseDate; ?>
			<?php $workPostedDate = date("d.m.y", strtotime($projReleaseDate));
			echo $workPostedDate; ?>
		</div>
<?php /*
		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['EducationalMaterial'];?>:</div>
			<div class="cell pop_right_text" ><?php if($isEducationMaterial=='t'){ echo $label['yes']; } else { echo $label['no']; }?>
		</div></div>
		<div class="clear_seprator"> &nbsp;</div>

		<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['event'];?>:</div>
			<div class="cell pop_right_text" ><?php if($isEvent=='t'){ echo $label['yes']; } else { echo $label['no']; }?>
			</div></div>
*/?>
		<div class="clear_seprator"> &nbsp;</div>
			<div class="row">
			<div class="cell orng_lbl lh16"><?php echo $label['AskingforDonation'];?>:</div>
			<div class="cell pop_right_text" ><?php if($askForDonation=='t'){ echo $label['yes']; } else { echo $label['no']; }?>
			</div></div>
		<div class="clear_seprator"> &nbsp;</div>
</div>
