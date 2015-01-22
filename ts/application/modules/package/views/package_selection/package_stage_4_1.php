<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$packageStage4_1 = array(
  'name'=>'packageStage4_1',
  'id'=>'packageStage4_1'
);

?>
<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$packageStage4_1); ?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
       <?php $this->load->view('common_view/package_stage_menus') ?>
      <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
          <div class="TabbedPanelsContent TabbedPanelsContentVisible">
             <div id="TabbedPanels5" class="TabbedPanels tab_setting">
               <?php $this->load->view('common_view/package_stage_sub_menus') ?>
                <div class="TabbedPanelsContentGroup ">
                   <div class="TabbedPanelsContent TabbedPanelsContentVisible">
                      <div class="wra_head clearb width635">
                         <h3 class="red   fs21 fnt_mouse bb_aeaeae">
                            <?php 
                                if($selectedPacakge==$this->config->item('package_type_2')){
                                  echo $this->lang->line('packpayment_annual_membership_payment'); 
                                }elseif($selectedPacakge==$this->config->item('package_type_3')){
                                  echo $this->lang->line('packpayment_three_year_membership'); 
                                }
                             ?>
                         </h3>
                         <ul class="display_table clearb mt40 defaultP ">
                            <li class=" font_weight">
                               <label>
                               <input  type="radio" name="item12" value="2" checked="checked" />
                               <?php 
                                  if($selectedPacakge==$this->config->item('package_type_2')){
                                     echo '€ '.number_format($this->config->item('package_1_year_price'),2); 
                                  }elseif($selectedPacakge==$this->config->item('package_type_3')){
                                    echo '€ '.number_format($this->config->item('package_3_year_price'),2); 
                                  }
                                ?>
                               </label>
                            </li>
                            
                            <li class="clearb fl fs17 pt15 mb5 ml36">  </li>
                            
                            <?php 
                                if(!isLoginUser()){
                            ?>
                            <li class="font_weight">
                               <label>
                               <input  type="text" id="promoCode" name="promoCode" class="font_wN" onclick ="placeHoderHideShow(this,'Have a promo code?','hide')",
                                onblur = "placeHoderHideShow(this,'Have a promo code?','show')" placeholder="Have a promo code?" value=""  />
                               </label>
                            </li>
                            <?php } ?>
                            
                         </ul>
                         <div class="sap_40"></div>
                          <?php 
                            $data['cancelUrl'] =  base_url('package'); // set cancel url
                            $data['backUrl']   = base_url('package/packagestagethree');
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
  packageStageSwitch('packageStage4_1',"/package/membershipselectedpost");
</script>
