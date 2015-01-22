<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row form_wrapper">
	<?php
	$competitionMediaLimit = $this->config->item('competitionMediaLimit');
	$countMediaData = (isset($countMediaData) && is_numeric($countMediaData))?$countMediaData:0;
	if(isset($header) ){
		echo $header;
	}?>
		<div class="row position_relative">	
			<?php
			$this->load->view("common/strip");
			if(isset($competitionMediaForm) ){ ?>

				<?php
				echo $competitionMediaForm;
			}

			if(isset($competitionMediaList) ){
				echo $competitionMediaList;
			}?>
		</div>
</div>

