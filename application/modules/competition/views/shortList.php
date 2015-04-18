<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row form_wrapper">
    
    <?php $this->load->view('backendTab'); ?>
    
    <div class="row position_relative">
		<?php $this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute')); ?>
		<div class="cell width_200">
			<div class="clear"></div>
			<div class="notification_menu mt35">
				<ul>
					<?php
					 for($i=0;$i<count($competitionData);$i++) { ?>
					<li><a href="<?php echo base_url('competition/shortlist/'.$competitionData[$i]['competitionId']); ?>" class="active"> <?php echo getSubString($competitionData[$i]['title'],20);?> <span> <?php echo '('.$competitionData[$i]['count'].')';?></span></a></li>	
					<?php } ?>				
				</ul>
			</div><!--cat_wrapper-->
		</div><!--width_200-->
		
		<div class="cell width_582 pl13" id="craveElementList">	
			<div class="row seprator_10"></div>
			<?php
			if(is_array($shortListData) && count($shortListData) > 0){
				echo "<div id='elementListingAjaxDiv' class='row'>";
				 $this->load->view('shortlist_listing',array('shortListData'=>$shortListData));
				echo "</div>";
				
			}else{ ?>  
			   <div class="nocravebg nocravbg_commonshedow"> 
					<div class="nocravebg_inner">
					<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160"><?php echo $this->lang->line('noCraveFound') ?></div>
					</div>
					
					<div class="nocravebg_btm">
					</div>
				</div>
				<?php
			}	?>
		</div>
	</div><!--position relative-->
</div><!--row form_wrapper-->
