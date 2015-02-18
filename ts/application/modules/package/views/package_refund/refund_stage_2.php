<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   

$refundStage2 =   array(
    'name'    =>  'refundStage2',
    'id'      =>  'refundStage2'
);

//get total price for payment condition
$getTotalPrice  =  multiarraysum($selectedContainerList,'totalPrice');

?>
<!--  content wrap  start end -->
<?php echo form_open(base_url(lang().'/package/refundstagetwopost'),$refundStage2); ?>
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
                       <div class="wra_head ad_camp clearb">
                          <h3 class="red  fs21 fnt_mouse bb_aeaeae">Sections in your Showcase.</h3>
                          <ul class=" width100_per mt40 lineH20 <?php echo ($getTotalPrice > 0)?'bb_aeaeae':''; ?> ">
                            
                            <?php if(!empty($selectedContainerList)){ 
                              $totalPrice   =  0;
                              foreach($selectedContainerList as $selectedContainer){
                                $refundSelectionId    =  (!empty($selectedContainer['refundSelectionId']))?$selectedContainer['refundSelectionId']:'0';
                                $sectionName          =  (!empty($selectedContainer['industrySection']))?$selectedContainer['industrySection']:'&nbsp;';
                                $containerTitle       =  (!empty($selectedContainer['title']))?$selectedContainer['title']:'&nbsp;';
                                $containerPrice       =  (!empty($selectedContainer['totalPrice']) && 0 < $selectedContainer['totalPrice'])?$selectedContainer['totalPrice']:'0';
                                $totalPrice           =  $totalPrice + $containerPrice;
                                
                            ?>
                             <li id="row_<?php echo $refundSelectionId; ?>">
                                <span class="red fl width_120 pr16"><?php echo  $sectionName; ?></span>
                                <span > <?php echo  substr($containerTitle, 0, 50); ?></span>
                                <span class="fr red"><b class="pr10"> <?php echo (0 < $containerPrice)?'€ '.number_format($containerPrice,'2'):'FREE'; ?></b>   
                                  <a href="javascript:void(0)" class="delete_selection" id="<?php echo $refundSelectionId; ?>">Delete</a>
                                </span>
                             </li>
                            <?php } }else{ ?>
                                  <h4>No any container selected.</h4>
                            <?php } ?>
                          
                          </ul>
                          <?php if($totalPrice >0 ){ ?>
                            <div class="total_wrap pt20 mr57 fr red font_weight"> <span>Total</span> <span class="pl36"><?php echo '€ '.number_format($totalPrice,'2'); ?></span></div>
                          <?php } ?>
                          
                            <?php 
                              $data['cancelUrl']  =  base_url('package/information'); // set cancel url
                              $data['backUrl'] = base_url('package/refundstageone');
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
    packageStageSwitch('refundStage2',"/package/refundstagetwopost");
  
    // delete selected container delete if you want
    $('.delete_selection').click(function () {
        var selectionId = $(this).attr('id');
        confirmBox("Do you really want to delete this selection?", function () {
             var fromData= {"selectionId":selectionId};
             $.post(baseUrl+language+'/package/refundselectiondelete',fromData, function(data) {
                if(data.isDeleted){
                    refreshPge();
                }
                console.log(data);
            },'json');
        });
    });   
</script> 


