<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
global $craveTypeOrder;
?>
<div class="row form_wrapper">
    
    <?php $this->load->view('crave_navigation_backend'); ?>
    
    <div class="row position_relative">
		<?php $this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute'));
		 ?>
		  
		<div class="cell width_200">
			
			<div class="notification_menu mt35">
				&nbsp;
			</div><!--cat_wrapper-->
		</div><!--width_200-->
		
		<div class="cell width_582 pl13" id="craveElementList">	
			
			
			<div class="row seprator_10"></div> 
			<?php
		 
			if($myPlaylistData && !empty($myPlaylistData)  && getMyPlaylistCount($userId)){
				
				echo "<div id='elementListingAjaxDiv' class='row'>";
					$this->load->view('myplaylist_frame');
				echo "</div>";
				
			}else{ ?>  
			   <div class="nocravebg nocravbg_commonshedow"> 
					<div class="nocravebg_inner">
					<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160"><?php echo $this->lang->line('noPlaylistFound') ?></div>
					</div>
					
					<div class="nocravebg_btm">
					</div>
				</div>
				<?php
			}	?>
		</div>
	</div><!--position relative-->
</div><!--row form_wrapper-->

<script>
	function removeMusic(entityId,elementId,userId,currentId){			 
		var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId};   
		var url ='<?php echo base_url(lang().'/craves/removeMusic')?>';
		var res= AJAX(url,'',ceavedata);
		if(res){
		 $('#uncrave_'+currentId).remove();				 
		// refreshPge();				 
		// alert('#uncrave_'+currentId);
	   }
	}  	
</script>

