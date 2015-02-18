<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if($isNotPopup != 1){
?>
	<div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<?php
}?>
<div class="popup_gredient ">
	<?php $this->load->view('dashboard/freeContainer',array('availableContainer'=>$userContainers,'sectionId'=>$sectionId,'formSubmitUrl'=>base_url(lang().'/'.$retunUrl))); ?>
</div>
<script>
runTimeCheckBox();
</script>
