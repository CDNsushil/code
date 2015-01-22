<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="fl">
<div class="font_museoSlab font_size20 clr_666 ml46 mt6">Apps</div>
<div class="seprator_6"></div>
<div class="dast_container_outer fl">
	<div class=" bg_dashbord_gred pall5">
	<div class="cell dash_link_shedow mt0 ml2 mt2">
		<div class="dash_Atool_list_box pl15 height_122"> 
			<div class="seprator_15"></div>
			<?php
			$mr20='';
			if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
				$mr20='mr20';
				?>
				<a href="<?php echo base_url(lang().'/cms/apps#wp');?>">
					<div class="fl mr20">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img class="bdr_white max_w73_h110 dashbox-shedow" alt="workprofile" src="<?php echo base_url();?>images/default_thumb/Work-Profile_110x73.jpg"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>

					</div> 
				</a>
				<?php
			}?>
				<a href="<?php echo base_url(lang().'/cms/apps#mp');?>">
					<div class="fl <?php echo $mr20;?>">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img class="bdr_white max_w73_h110 dashbox-shedow" alt="workprofile" src="<?php echo base_url();?>images/default_thumb/meetingPoint_110x73.jpg"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>

					</div> 
				</a>
			<?php
			//if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
			if(0){ 
			?>	
				<a href="javascript:viod(0)" class="comingSoon">
					<div class="fl">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img class="bdr_white max_w73_h110 dashbox-shedow" alt="desktopupload" src="<?php echo base_url();?>images/default_thumb/Desktop-App_110x73.jpg"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>
					</div>
				</a>
			<?php
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="seprator_10"></div> 
	</div>  
</div>
</div>
	
