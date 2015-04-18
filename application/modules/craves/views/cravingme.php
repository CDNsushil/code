<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
global $craveTypeOrder;
require(APPPATH.'modules/craves/views/cravedata.php');
?>
<div class="row content_wrap" >
  <div class="m_auto Crave_cnt film_video clearb  ">
      
      <?php $this->load->view('crave_navigation_backend'); ?>
      
      <div class=" fl pl20">
         <div class="mb10 width772 display_block fl  clearb">
             <?php
				$formAttributes = array(
					'name'=>'craveSearchForm',
					'id'=>'craveSearchForm',
					'class'=>'fr',
				);
				echo form_open($this->uri->uri_string(),$formAttributes);
				?>
                <div class="position_relative select_1 fl height30 width_208 mr13" >
					<?php 
					if(isset($craveSearchSection) && is_array($craveSearchSection) && count($craveSearchSection) > 0) {
						ksort($craveSearchSection);?>
						<select class="width_208" id="craveSections">
							<option value=""><?php echo "All";?></option>
							<?php
							foreach($craveSearchSection as $key=>$type) {
								if(isset($craveSearchSection[$key]) && !empty($craveSearchSection[$key])) { 
									// get search offset
									$searchOffset = $this->uri->segment(4);
									?>
									<option value="<?php echo $key;?>" <?php if($searchOffset == $key) { ?> selected="selected" <?php } ?> ><?php echo $craveSearchSection[$key];?></option>
								<?php
								}
							} ?>
						</select>
					<?php
					}
					?>
                </div>
                <!--Search bar-->
                <div class="searchbarbg width_auto ff_arial fl font_weight  ml0 mt0">
                    <input name="craveSearch" id="craveSearch" type="text" class="font_wN search_text_box" value="<?php if(empty($craveSearch)){ echo $this->lang->line('searchMembers');} else echo $craveSearch;?>" placeholder="<?php echo $this->lang->line('searchMembers');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','show')">												
                    <input type="submit" name="searchCrave" value="Submit" class="searchbtbbg">     
                </div>
            <?php echo form_close(); ?>
         </div>
         
		<?php
		if($craves && $craveData && is_array($craveData) && count($craveData) > 0){
			echo "<div id='elementListingAjaxDiv' class='row'>";
				$this->load->view('cravingme_list',array('craveData'=>$craveData));
			echo "</div>";
		} else { ?>  
			<div class="nocravebg nocravbg_commonshedow"> 
				<div class="nocravebg_inner">
					<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160"><?php echo $this->lang->line('noCraveFound') ?></div>
				</div>
					
				<div class="nocravebg_btm"></div>
			</div>
			<?php
		} ?>
         
		<!--crave list One-->
		<div class="sap_60 mb50 clearb"></div>
         
      </div>
   </div>
</div>

<script>
	function unCrave(entityId,elementId,userId,currentId){
		confirmBox("Do you really want to delete this crave?", function () {	 
			var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId};   
			var url ='<?php echo base_url(lang().'/craves/postCrave')?>';
			var res= AJAX(url,'',ceavedata);
			if(res){
				$('#uncrave_'+currentId).remove();		
				$('#removecrave_'+currentId).remove();	 		 
				refreshPge();				 
				// alert('#uncrave_'+currentId);
		   }
	   });
	} 
	
	$('#craveSections').change(function() {
		var craveSection = this.value;
		if(craveSection != undefined) {
			window.location.href = '<?php echo base_url(lang().'/craves/cravingme').'/'; ?>'+craveSection;
		}
	}); 	
</script>

