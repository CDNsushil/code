<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
global $craveTypeOrder;
require(APPPATH.'modules/craves/views/cravedata.php');
?>
<div class="row content_wrap" >
  <div class="m_auto Crave_cnt film_video clearb  ">
      
      <?php $this->load->view('crave_navigation_backend'); ?>
      
      <div class=" fl pl20">
         <div class="mb10 width772 display_block fl  clearb 	">
             <?php
				$formAttributes = array(
					'name'=>'craveSearchForm',
					'id'=>'craveSearchForm',
					'class'=>'fr',
				);
				echo form_open($this->uri->uri_string(),$formAttributes);?>
                <div class="position_relative select_1 fl height30 width_208 mr13" >
					<?php 
					if(isset($craveSearchSection) && is_array($craveSearchSection) && count($craveSearchSection) > 0) {
						ksort($craveSearchSection);?>
						<select class="width_208" id="craveSections">
							<option value="" ><?php echo "All";?></option>	
							<?php
							foreach($craveSearchSection as $key=>$type) {
								if(isset($craveSearchSection[$key]) && !empty($craveSearchSection[$key])) { 
									// get search offset
									$searchOffset = $this->uri->segment(4);?>
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
                   
                    <input name="craveSearch" id="craveSearch" type="text" class="font_wN" value="<?php if(empty($craveSearch)){ echo $this->lang->line('searchCraves');} else echo $craveSearch;?>" placeholder="<?php echo $this->lang->line('searchCraves');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchCraves');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchCraves');?>','show')">												
                    <input type="submit" name="searchCrave" value="Submit" class="searchbtbbg">
                        
                </div>
            <?php echo form_close(); ?>
         </div>
         
         <?php
			if($craves && $craveData && is_array($craveData) && count($craveData) > 0){
				echo "<div id='elementListingAjaxDiv' class='row'>";
					$this->load->view('crave_list',array('craveData'=>$craveData));
				echo "</div>";
			}?>
         
         <!--crave list One-->
         <div class="sap_60 mb50 clearb"></div>
         
      </div>
      <!--<div class="adver fr cour_poin  pr20 ">
          <?php 
            //$this->load->view('common/adv_rhs');
            ?>
      </div>-->
   </div>
</div>

<script>
	function unCrave(entityId,elementId,userId,currentId) {	
		confirmBox("Do you really want to delete this crave?", function () {	 
			var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId};   
			var url ='<?php echo base_url(lang().'/craves/postCrave')?>';
			var res= AJAX(url,'',ceavedata);
			if(res) {
			 $('#uncrave_'+currentId).remove();	
			 $('#removecrave_'+currentId).remove();	 			 
			 refreshPge();				 
		   }
		});
	}  	
	
	$('#craveSections').change(function() {
		var craveSection = this.value;
		if(craveSection != undefined) {
			window.location.href = '<?php echo base_url(lang().'/craves/index').'/'; ?>'+craveSection;
		}
	});
	
</script>

