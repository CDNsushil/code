<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$maxworkprofileMedia=$this->config->item('maxworkprofileMedia');
$showFormIE=$showForm='dn';
$userBrowser = get_user_browser();
if($userBrowser == 'ie'){
	$showFormIE='';
}?>
<!-- Promo Image View -->

	<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line($sectionHeading); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">			
			<div class="tds-button-top" >
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="<?php echo $toggleId;?>ToggleIcon" toggleDivId="<?php echo $toggleId;?>-Content-Box" ></div></span>
				</a>
			</div>
			<?php if($count < $maxworkprofileMedia){?>
			<div class="tds-button-top" id="addIcon"> 				
				<a class="formTip formToggleIcon" title="<?php echo  $this->lang->line('add');?>" toggleDivId="<?php echo $toggleId;?>-Content-Box" toggleDivForm="<?php echo $toggleId;?>Form-Content-Box" toggleDivIcon="<?php echo $toggleId;?>ToggleIcon" cancelId="addButton<?php echo $toggleId;?>" >
					<span><div class="projectAddIcon"></div></span>
				</a>
			</div>
			<?php }?>			
		</div>
	</div>
	</div><!--row-->	
	<div class="clear"></div>
	<div id="addButton<?php echo $toggleId;?>" onclick="cancelMediatoggle('<?php echo $toggleId;?>',1);"></div>
	<div id="<?php echo $toggleId;?>-Content-Box" class="frm_strip_bg">	
		
		<div class="row"><div class="tab_shadow"></div></div>
		
		<div id="<?php echo $toggleId;?>Form-Content-Box" class="row <?php echo $showFormIE;?>">	 
			<?php $this->load->view('mediatheme/mediaForm');
			// echo Modules::run("mediatheme/mediaForm"); ?>
		</div> <!-- EventPromoForm-Content-Box-->	         
	
		<div id="<?php echo $toggleId;?>-Content">
			<?php 
			 $this->load->view('mediatheme/'.$toggleId.'MediaList');
			//echo Modules::run("mediatheme/mediaList",$toggleId); ?>
			<div class="clear"></div>
		</div><!-- EventPromo-Content -->
	<!--<div class="seprator_10 row"></div>-->
	</div> <!-- EventPromo-Content-Box -->
<?php

if(isset($last) && $last!='')
echo '<div class="row"><div class="tab_shadow"></div></div>';
// browser is IE Start
	if(isset($showForm) && $showForm=='dn' && $userBrowser == 'ie'){?>
		<script> toggleWithDelay("#<?php echo $toggleId;?>Form-Content-Box");</script>
		<?php 
	}
// browser is IE END
