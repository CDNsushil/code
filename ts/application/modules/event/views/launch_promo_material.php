<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
 	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('promotionalMaterial');?></h1>
		</div>
		
		<?php 
			$navArray['NatureId'] = $eventNatureId;
			$navArray['EventId'] = (isset($EventId) && is_numeric($EventId) )?$EventId:0;
			$navArray['LaunchEventId'] = (isset($LaunchEventId) && is_numeric($LaunchEventId) )?$LaunchEventId:0;
			$navArray['currentMathod'] = 'launchpromomaterial';
			echo Modules::run("event/menuNavigation",$navArray);
		 ?> 
	</div>

<div class="row form_wrapper">	
	<div  class="frm_strip_bg">
		<?php
			if((isset($EventId) && $EventId>0) || (isset($LaunchEventId) && $LaunchEventId>0))
			{
				$eventPromoImages['lastShadow'] = 0;					
				$this->load->view('mediatheme/promoImgAccordView',$eventPromoImages);
			}
		?>
	</div>
</div><!--row wrapper-->	
