<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$currentDashboardMethod = $this->router->method; ?>
<div class="bg_444 pl6 pr6 pt6">
    <div class="bg_white"> 
        <?php $this->load->view('topDashBox');?>
		<div class="fl width724">
			<div class="cell bdr_non pl0 pr0 pt0 ml9 position_relative">
				<div class="fl">
					<div class="newdash_orangepatern font_museoSlab font_size19 clr_white text_alignC lineH38">Setup your Showcase</div>
					<?php $this->load->view('dashboard_new_left_navigation');?>
				</div>
				<?php 
				if(!isset($innerWelcomePage) && empty($innerWelcomePage)) {
					$this->load->view('newContainer');
				} else {
					$this->load->view($innerWelcomePage);
				} ?>
				<div class="clear"></div>
				<div class="seprator_10"></div>
				<div class="font_opensans clr_666 pr8 text_alignR dash_welcome_hover"><a class="orange" href="<?php echo base_url(lang().'/dashboard/loadWelcomePage/'.$welcomePage);?>"><?php echo $welcomeHeading;?></a></div>
				
				<div class="clear"></div>
				<div class="seprator_10"></div>
				<div class="dashboard_bottomshedow_small"></div>
			</div>
			<!--newdastleftbox-->
      		<div class="clear"></div>
			<div class="heightAuto mr3 fl position_relative">
                <?php $this->load->view('dashboard/dashboard_new_link');?>
				<div class="clear"></div>
				<div class="seprator_22"></div>
				<div class="seprator40ie"></div>
					<?php $this->load->view('dashboard/dashboard_site_info');?>
                    <div class="clear"></div>
                    <div class="seprator_22"></div>         
                   <?php $this->load->view('dashboard/dashboard_new_app');?>
                    
                   <?php $this->load->view('dashboard/dashboard_new_toad_icon');?>                            
                	<div class="clear"></div>
                    <div class="dashboard_bottomshedow_small"></div>
            </div>      
		</div>
		<div class="sidedescription mt-3 position_relative">
			<?php
			if(isset($helpPage) && !empty($helpPage)){
				echo $this->load->view($helpPage);
			}?>
		</div> 
		<div class="clear"></div>
		<div class="seprator_40"></div>
	</div>
</div>
