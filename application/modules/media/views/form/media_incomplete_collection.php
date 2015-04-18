<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row content_wrap" >
   <div class="bg_f3f3f3 fl width100_per title_head">
      <h1 class="fs30 letrP-1 opens_light mb0  fl pl25  textin30"><?php echo $this->lang->line($indusrty.'_collections'); ?></h1>
   </div>
   <div class="m_auto sc_list clearb pt30 pl30 pr30 pb30">
        
        <div id="searchMediaResultDiv">
			<?php
			//$projRecords = (array)$projectListingData; //  cast object to an array
			$projRecords = $projectListingData; //  cast object to an array
			
			
			if(!empty($projRecords)) {
				echo $mediaCollectionResult;
			} else {
				echo '<h4 class="fs18">No record available for your selection.</h4>';
			}?>
		</div>
   </div>
</div>


