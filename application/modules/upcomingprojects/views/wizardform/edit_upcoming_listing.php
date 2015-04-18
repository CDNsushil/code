<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="showcase_wizard">
    <div id="TabbedPanels1" class="TabbedPanels"> 
        <div class="content display_table  TabbedPanelsContent width635 m_auto">
			<div class="c_1 clearb">
				<h3><?php echo $editUpcomingListing;?></h3>
				   <div class="select_session_wap" id="searchResultDiv">
					<?php
						if(!empty($upcomingProjects)) {
							echo $projectCollectionResult;
						} else {
							echo '<h4 class="fs18">No record available for your selection.</h4>';
						}
					?>
				 </div>
			</div>
        </div>
    </div>
</div>
<div class="sap_45"></div>
<!--  content wrap  end --> 
<script>
    
    function deleteShowcase(upcomingId){
        confirmBox("Do you really want to delete this upcoming showcase?", function () {
            var fromData='projId='+upcomingId;
            loader();
            $.post(baseUrl+language+'/upcomingprojects/movetoarchive',fromData, function(data) {
                window.location.href = window.location.href;
            });
        });
    }
 
</script>
