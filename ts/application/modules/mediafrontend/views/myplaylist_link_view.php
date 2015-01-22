<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--------show myplaylist div start-------->
<?php if(getMyPlaylistCount($userId)) { ?>
 <div class="seprator_10"></div>
 <div onclick="window.location.href='<?php echo base_url('mediafrontend/myplaylist/'.$userId);?>'" class="row summery_right_archive_wrapper width_auto ptr ">

		 <h1 class="sumRtnew_strip gray_light_hover"><?php echo $this->lang->line('myplaylist'); ?>
			 
		<div class="Fright mt9 mr20">
			<span  class="status_bar_play_btn ptr Fright mt-3 playAudioIcon"></span>
		</div>
	</h1>
 </div>
<?php } ?>
<!--------show myplaylist div start-------->
