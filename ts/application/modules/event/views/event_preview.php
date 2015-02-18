<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="frm_wp" style="background:#FFFFFF;">
<span class="clear_seprator "></span>
	<div class="title-content" style="width:100%">
		<div class="title-content-left">
			<div class="title-content-right">
				<div class="title-content-center">
					<div class="title-content-center-label">Event Information </div>
					
				</div><!-- End title-content-center-->
			</div><!-- End title-content-right-->
		</div><!-- End title-content-left-->
	</div><!-- End title-content-->
	
<?php
//echo "<pre>"; print_r($event);
	
if(count($event) > 0){

?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['title'];?></div>
<div class="cell" >
<?php echo $event['Title']; ?>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['oneLineDescription'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">
<?php echo $event['OneLineDescription']; ?>

</div>
</div>
<?php if(isset($event['Tagwords']) && $event['Tagwords']>0  && $event['Tagwords']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['tagWords'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">
<?php echo $event['Tagwords'];?>
</div>
</div>
<?php } ?>

<?php if(isset($event['Industry']) && $event['Industry']>0){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['selectIndustry'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">

<?php
echo getIndustry($event['Industry']);
?>
</div>
</div>
<?php } ?>
<?php if(isset($event['StartDate']) && $event['StartDate']>0  && $event['StartDate']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventStartDate'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">
<?php echo substr($event['StartDate'],0,-9);?>
</div>
</div>
<?php } ?>
<?php if(isset($event['FinishDate']) && $event['FinishDate']>0  && $event['FinishDate']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventFinishDate'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">
<?php echo substr($event['FinishDate'],0,-9);?>
</div>
</div>
<?php } ?>
<?php if(isset($event['Time']) && $event['Time']>0  && $event['Time']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventSelectTime'];?></div>
<div class="cell"  style="min-width:595px;max-width:595px;">
<?php echo $event['Time'];?>
</div>
</div>
<?php } ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell  orng_lbl">&nbsp;</div>
<div class="cell">
<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label" style="width: 541px;"><?php echo $label['venueLocation']; ?></div>
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
</div>

<?php if(isset($event['Address']) && $event['Address']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['address'];?></div>
<div class="cell">
<?php echo $event['Address'];?>
</div>
</div>
<?php } ?>
<?php if(isset($event['City']) && $event['City']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['city'];?></div>
<div class="cell">
<?php echo $event['City'];?>
</div>
</div>
<?php } ?>
<?php if(isset($event['State']) && $event['State']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['state'];?></div>
<div class="cell">
<?php echo $event['State'];?>
</div>
</div>
<?php } ?>
<?php if(isset($event['Zip']) && $event['Zip']!=''){ ?>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['zipcode'];?></div>
<div class="cell">
<?php echo $event['Zip'];?>
</div>
</div>
<?php } ?>
<?php if(isset($event['URL']) && $event['URL']!=''){ ?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['addUrl'];?></div>
<div class="cell">
<?php echo $event['URL'];?>
</div>
</div>
<?php } ?>
<?php

}
else{
echo 'No Record!';
} 
?>
<div class="row heightSpacer"> &nbsp;</div>	
</div>
