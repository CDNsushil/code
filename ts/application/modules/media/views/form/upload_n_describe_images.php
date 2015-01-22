<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$seven_step = '';
if(!empty($ispriceShippingCharge) && !empty($isMediaForm) && $indusrtyName != 'photographyNart') {
    $seven_step = 'seven_step';
}
?>
<div class="TabbedPanels tab_setting" id="TabbedPanels5">
    <ul class="TabbedPanelsTabGroup thrid_list upload_nav <?php echo $seven_step;?>">
        <?php if($isMediaForm){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuForm)?$uploadSubMenuForm:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_uploadform'); ?>*</b></span> </li>
        <?php }?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS1)?$uploadSubMenuS1:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_uploadfile'); ?>*</b></span> </li>
        <?php  if($indusrtyName != 'photographyNart') { ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuDisplayImg)?$uploadSubMenuDisplayImg:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_setDisplayImage'); ?>*</b> </span></li>
        <?php }?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS2)?$uploadSubMenuS2:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_titleDescription'); ?>*</b> </span></li>
        <?php if( $ispriceShippingCharge == 1 || $ispriceShippingCharge == 3 ){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS3)?$uploadSubMenuS3:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_pricing'); ?>*</b> </span></li>
        <?php } ?>
        <?php if( $ispriceShippingCharge == 2 || $ispriceShippingCharge == 3 ){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuShipping)?$uploadSubMenuShipping:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_shipping'); ?>*</b> </span></li>
        <?php } ?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS4)?$uploadSubMenuS4:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_information'); ?>*</b></span></li>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS5)?$uploadSubMenuS5:'';?>" > <span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_teaminfo'); ?></b></span></li>
    </ul>
    
    <?php if(isset($shippingNav) && !empty($shippingNav) && isset($deliveryOptions) && count($deliveryOptions) > 0) { ?>
        <div class="TabbedPanels tab_setting second_inner" id="TabbedPanels8"> 
            <div class="TabbedPanelsContentGroup width635 m_auto ">
                <div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting">
                    <!-- Shipping navigation bar start here -->
                   
                        <ul class="TabbedPanelsTabGroup width100_per">
                            <?php if(in_array('1',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS1Menu)?$shippingS1Menu:'';?>" >
                                    <span>Pickup </span>
                                </li>
                            <?php }  
                            if(in_array('2',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS2Menu)?$shippingS2Menu:'';?>" >
                                    <span>Domestic Shipping</span>
                                </li>
                             <?php }  
                            if(in_array('3',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS3Menu)?$shippingS3Menu:'';?>" >
                                    <span>International  Shipping </span>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- Shipping navigation bar end here --> 
                   
                </div>
            </div>
        </div>
     <?php }?>
    <?php
        //load inner sub page views
        $this->load->view($subInnerPage); 
    ?>
</div>
