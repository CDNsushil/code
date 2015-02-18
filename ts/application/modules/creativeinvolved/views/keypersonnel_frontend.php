<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
  <div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
  <div class="popup_gredient ">
	  <div class="row p15 width_263">
		<div class="popup_heading_small"><?php echo $heading;?></div>
		<div class="seprator_10"></div>
		<div class="seprator_5"></div>
		<?php
			$dn='';
			if($creativeInvolved){
				$dn='dn';
				foreach($creativeInvolved as $k=>$user){?>
					<div class="row">
						 <div class="cell pt3 pr10 font_opensansSBold width45percent"><?php echo $user->crtDesignation;?></div>
						 <div class="cell pt3 pr10 font_opensansSBold width45percent"><?php echo $user->crtName;?></div>
						 <!--<div class="cell pt3 pr10 font_opensansSBold"><?php echo $user->crtEmail;?></div>-->
						<div class="clear"></div>
					</div>
					<?php
				}
			}else{?>
				<div class="row"><div class="cell pro_title"><?php echo $this->lang->line('noRecord'); ?></div></div>
				<?php
			}	?>
		<div class="clear"></div>
	  </div>
  </div>
