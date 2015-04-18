<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
	<!---left div --->
	<div class="fl ml20 width_370">
		<?php 
			$divCount=1;
			$position=1;
			foreach($showcaseEntriesData as $showcaseEntries) { 
				if($divCount%2){
					$entriesData['showcaseEntries'] = $showcaseEntries;
					$entriesData['position'] = $position;
					echo $this->load->view('showcaseentrieslistfullframe',$entriesData);
					$position=$position+2;
				}
				$divCount++;	
			}
		?>
	</div>
	<!---right div --->
	<div class="fr mr6 width_370">
		<?php 
			$divCount=1;
			$position=2;
			foreach($showcaseEntriesData as $showcaseEntries) { 
				if(!($divCount%2)){
					$entriesData['showcaseEntries'] = $showcaseEntries;
					$entriesData['position'] = $position;
					echo $this->load->view('showcaseentrieslistfullframe',$entriesData);
					$position=$position+2;	
				}
				$divCount++;
				
			}
		?>
	</div>
