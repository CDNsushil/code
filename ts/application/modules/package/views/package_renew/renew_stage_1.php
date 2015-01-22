<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   

$renewStage1 = array(
  'name'=>'renewStage1',
  'id'=>'renewStage1'
);

?>

<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$renewStage1); ?>
<div class="newlanding_container ">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
      <!-- membership stages start -->
       <?php $this->load->view('common_view/renew_stage_menus') ?>
      <!-- membership stages end-->
        <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
         <div class="TabbedPanelsContent TabbedPanelsContentVisible">
            <div id="TabbedPanels5" class="TabbedPanels tab_setting">
               <div class="TabbedPanelsContentGroup ">
                  <div class="TabbedPanelsContent TabbedPanelsContentVisible">
                     <div class="wra_head ad_camp clearb">
                        <h3 class="red  fs21 fnt_mouse bb_aeaeae"> <?php echo $this->lang->line('pack_renew_which_add_camp'); ?> </h3>
                        <ul class=" width100_per mt60 lineH20  defaultP">
                           
                           <?php 
                              if(!empty($campaignList)){
                              $totalPrice = 0;   
                              foreach($campaignList as $campaign){
                                
                                $userContainerId          =  $campaign->userContainerId;
                                $campaignTitle            =  $campaign->campaignname;
                                $campaignDescription      =  $campaign->comments;
                                $price                    =  number_format($campaign->totalPrice,2);
                                $totalPrice               =  $totalPrice + $price;
                                $totalPrice               =  number_format($totalPrice, 2);
                           ?>
                             
                             <li>
                                <input type="checkbox" name="campaignId[]" value="<?php echo  $userContainerId; ?>"  />
                                <span class="red pl5 width_115"><?php echo $campaignTitle; ?></span><span class="pl50"><?php echo $campaignDescription; ?></span><b class="fr red"> &euro;<?php echo $price; ?></b>
                             </li>
                           
                           <?php } ?>
                           
                              <li class="bt_aeaeae pt20 mt38"><b class="fr fs16 red "> &euro;<?php echo $totalPrice; ?></b></li>
                          
                           <?php  } ?>
                           
                        </ul>
                        
                        <?php 
                            $data['cancelUrl']  =  base_url('package/information'); // set cancel url
                            $data['backUrl']    =  base_url('package/information');
                            $this->load->view('common_view/common_buttons',$data);
                          ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>      
<!--  content wrap  end -->

<script type="text/javascript">
  //call stage switch method
  packageStageSwitch('renewStage1',"/package/renewstageonepost");
</script>
