<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$userId = isLoginUser();
	echo Modules::run("event/indexNavigation"); 
?>
<!-- Notification Title get shown END's here -->
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
	?>
	 
	<div class="cell width_569 padding_left16">
		<?php
		$totalRecords = count($listData);
		if($totalRecords > 0)
		{
			echo "<div id='elementListingAjaxDiv' class='row'>";
			$this->load->view('event_notification_data',array('listData'=>$listData));
			echo "</div>";
		}//END IF
		else{
			$sectionId=$this->config->item('eventNotificationsSectionId');
			$returnUrl='/event/eventnotifications/eventform';	// MESSAGE: IF THERE IS NO RECORDS 
			?>
			<div class="cell width_488 margin_left_55 pr">
				<div id="showContainer">
					<script>
							AJAX('<?php echo base_url(lang().'/package/getAvailableUserContainer');?>','showContainer','<?php echo $sectionId?>','<?php echo $returnUrl?>','1');
					</script>
				</div>
			</div>
			<?php
		}	
		?>
		
	</div>
	
	<div class="clear"></div>
	<div class="seprator_10"></div>
	
</div> <!-- End Width --> 
