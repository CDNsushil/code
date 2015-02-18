<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
global $craveTypeOrder;
?>
<div class="row form_wrapper">
    <?php $this->load->view('crave_navigation_backend'); ?>
    <div class="row position_relative">
		
		<?php $this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute'));
		require(APPPATH.'modules/craves/views/cravedata.php'); ?>
		  
		<div class="cell width_200">
			<div class="search_box_wrapper frm_mid_search ml18 mt18">
				<?php
				$formAttributes = array(
					'name'=>'craveSearchForm',
					'id'=>'craveSearchForm',
				);
				echo form_open($this->uri->uri_string(),$formAttributes);
					?>
					<input name="craveSearch" id="craveSearch" type="text" class="search_text_box" value="<?php if(empty($craveSearch)){ echo $this->lang->line('searchMembers');} else echo $craveSearch;?>" placeholder="<?php echo $this->lang->line('searchMembers');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','show')">												
					
					<div> 
						<input type="submit" name="searchCrave" value="" class="search_btn_glass">
						<!--<input type="image" src="<?php //echo base_url();?>images/btn_search_box.png" name="searchCrave" value="searchCrave" >-->
					</div>
				<?php echo form_close(); ?>
					
			</div>
			<div class="clear"></div>
			<div class="notification_menu mt35">
				<?php
				
				if(isset($craveTypeString) && is_array($craveTypeString) && count($craveTypeString) > 0){
					ksort($craveTypeString);
					?>
					<ul>
						<?php
							$setMyworkSeparator=false;
							foreach($craveTypeOrder as $type){
								
								
								if(isset($craveTypeString[$type])){
									echo $craveTypeString[$type];
								}
								if(($setMyworkSeparator == false) && isset($craveTypeString[$type]) && ($type == 'creatives' || $type == 'associatedprofessionals' || $type == 'enterprises') ){
									$setMyworkSeparator=true;
									echo '<li class="cravingMywork"><div class="cell frm_heading"><h2>'.$this->lang->line('cravingMywork').'</h2></div></li>';
								}
							}
						
						?>
					</ul>
					<?php
				}
				?>
			</div><!--cat_wrapper-->
		</div><!--width_200-->
		
		<div class="cell width_582 pl13" id="craveElementList">	
			<?php
			$section = (isset($section) && !empty($section))?$section:$craveSection;
			$cravelistUrl=(empty($section)?'craves/'.$currentMathod.'/':'craves/'.$currentMathod.'/'.$craveSection);
			$this->load->view('common/shortingView',array('url'=>$cravelistUrl,'startFromWord'=>$startFromWord,'class'=>'my_carve_bdc_box mt20 crave_alphbet','activeClass'=>'orange'));
			?>
			
			<div class="row seprator_10"></div> <?php
			
			if($craves && $craveData && is_array($craveData) && count($craveData) > 0){
				echo "<div id='elementListingAjaxDiv' class='row'>";
				  $this->load->view('cravingme_list',array('craveData'=>$craveData));
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
			}?>
		</div>
	</div><!--position relative-->
</div><!--row form_wrapper-->

<script>
	function unCrave(entityId,elementId,userId,currentId){			 
		var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId};   
		var url ='<?php echo base_url(lang().'/craves/postCrave')?>';
		var res= AJAX(url,'',ceavedata);
		if(res){
		 $('#uncrave_'+currentId).remove();				 
		 refreshPge();				 
		// alert('#uncrave_'+currentId);
	   }
	}  	
</script>

