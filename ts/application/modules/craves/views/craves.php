<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
global $craveTypeOrder;
require(APPPATH.'modules/craves/views/cravedata.php');
?>


<div class="row content_wrap" >
  <div class="m_auto Crave_cnt film_video clearb  ">
      
      <?php $this->load->view('crave_navigation_backend'); ?>
      
      <div class="width772 fl pl20">
         <div class="mb10 display_block fr  clearb 	">
             <?php
				$formAttributes = array(
					'name'=>'craveSearchForm',
					'id'=>'craveSearchForm',
				);
				echo form_open($this->uri->uri_string(),$formAttributes);?>
                <div class=" position_relative select_1 fl height30 width_208 mr13" >
                    
                   <select class="width_208" >
                      <option >Associated Professionals</option>
                      <option >Blogs</option>
                      <option >Creatives</option>
                      <option >Educational Material</option>
                      <option >Enterprises</option>
                      <option >Film &amp; Video</option>
                      <option >Music &amp; Audio</option>
                      <option >Performances &amp; Events</option>
                      <option >Photography &amp; Art</option>
                      <option >Products</option>
                      <option >Work</option>
                      <option >Writing &amp; Publishing</option>
                   </select>
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
				 $this->load->view('crave_list',array('craveData'=>$craveData));
			}?>
         
         <!--crave list One-->
         <div class="sap_60 mb50 clearb"></div>
         
      </div>
      <div class="adver fr cour_poin  pr20 ">
          <?php 
                $this->load->view('common/adv_rhs');
            ?>
      </div>
   </div>
</div>


<script>
	function unCrave(entityId,elementId,userId,currentId){			 
		var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId};   
		var url ='<?php echo base_url(lang().'/craves/postCrave')?>';
		var res= AJAX(url,'',ceavedata);
		if(res){
		 $('#uncrave_'+currentId).remove();				 
		 refreshPge();				 
	   }
	}  	
</script>

