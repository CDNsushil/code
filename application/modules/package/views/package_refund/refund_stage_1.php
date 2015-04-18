<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   

$refundStage1 =   array(
    'name'    =>  'refundStage1',
    'id'      =>  'refundStage1'
);

?>

<!--  content wrap  start end -->
<?php echo form_open(base_url(lang().'/package/refundstageonepost'),$refundStage1); ?>
<div class="newlanding_container ">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
      <!-- membership stages start -->
       <?php $this->load->view('common_view/refund_stage_menus') ?>
      <!-- membership stages end-->
      
      <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
       <div class="TabbedPanelsContent TabbedPanelsContentVisible">
          <div id="TabbedPanels5" class="TabbedPanels tab_setting">
             <div class="TabbedPanelsContentGroup ">
                <div class="TabbedPanelsContent TabbedPanelsContentVisible">
                  
                   <div class="wra_head clearb">
                     
                      <!--load view typ industry-->
                      <?php $this->load->view('package_refund/refund_project_list') ?>
                    
                        <?php 
                            //if user is renew the redirect to renew page
                            $data['cancelUrl']  =  base_url('package/information'); // set cancel url
                            $data['backClass']  =  'back_container'; // set back button url
                            $data['nextClass']  =  'next_container'; // set next button url
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
 


