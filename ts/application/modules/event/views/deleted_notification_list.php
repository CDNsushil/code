<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
echo Modules::run("event/indexNavigation"); ?>

<div class="clear"></div>
<!-- Notification records get displayed here -->
<div class="row mt6 position_relative">
	<?php 
		//LEFT SHADOW STRIP
		echo Modules::run("common/strip");
	?>
	<!-- Left Menu List Of All Event Sections -->
	<?php
		$NatureId=1;
		$sectionArray = array('NatureId'=>$NatureId,'isArchive'=>$isArchive);
		$this->load->view('events_left_section',$sectionArray);
		//echo Modules::run("event/eventsLeftSection",$sectionArray);
	?>
	<div class="cell width_569 padding_left16">
		<?php

		//MAIN FOR LOOP FOR ALL TYPE OF EVENTS
		$totalRecords = count($listData);
		if($totalRecords > 0)
		{
			echo "<div id='elementListingAjaxDiv' class='row'>";
			$this->load->view('deleted_notification_data',array('listData'=>$listData));
			echo "</div>";

		}//END IF
		else
		{
			// MESSAGE: IF THERE IS NO RECORDS 
			/*
				echo '<div class="row heightSpacer">&nbsp;</div>';
				echo '<div>'.$label['noDelNotification'].'</div>';
				echo '<div class="row heightSpacer">&nbsp;</div>';
			*/
					
		}	
		?>
		<div class="clear"></div>
		<div class="seprator_10"></div>
	</div> <!-- End Width --> 
</div> <!-- End position_relative --> 

