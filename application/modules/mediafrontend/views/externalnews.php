<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<td width="800" class=""  valign="top">
	<?php
		$externalUrl=getUrl($externalUrl);
		if($externalUrl){
			echo '<iframe align="top" width="800" height="800" scrolling="auto"  src="'.$externalUrl.'"></iframe>';
		}else{
			echo '<div class="p15 red b f16">'.$this->lang->line('urlNotValid').'</div>';
		}
	?>
	
</td>
<td class="advert_column"  valign="top">
	<div class="cell advert_column ">
	  <div class="seprator_5"></div>
		<div class="ad_box ml11 mt10 mb10"><?php $this->load->view('common/adv_vertical'); ?></div>
	</div>
</td>
<?php
/* End of file media.php */
/* Location: ./application/module/media/view/media.php */
/* Wriiten By Sushil Mishra */

