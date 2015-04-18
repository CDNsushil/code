<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$seven_step = '';
if(!empty($ispriceShippingCharge) && !empty($isMediaForm) && $indusrtyName != 'photographyNart') {
    $seven_step = 'seven_step';
}
// set base url
$baseUrl = formBaseUrl();
// set project element link params in edit
$editprojectIds = $projectId;
if(!empty($elementId)) {
	$editprojectIds = $projectId.'/'.$elementId;
}
// get session value of edit media mode
$isEditMedia = $this->session->userdata('isEditMedia');
// get session value of element add status
$isAddElement = $this->session->userdata('isAddElement');

// set enchor end tag in edit mode
$anchorEnd = '';
$pt10 = '';
$editCls = '';
if(!empty($isEditMedia)) {
	$isEditMedia = true;
	$anchorEnd = '</a>';
	$pt10 = 'pt10';
	$editCls = 'editWizardTab';
}
?>
<div class="TabbedPanels tab_setting <?php echo $editCls;?>" id="TabbedPanels5">
    <ul class="TabbedPanelsTabGroup thrid_list upload_nav <?php echo $seven_step;?>">
        <?php if($isMediaForm){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuForm)?$uploadSubMenuForm:'';?>" >
				<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/uploadform/'.$editprojectIds.'">'; } ?>
					<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_uploadform'); ?>*</b></span>
				<?php echo $anchorEnd;?>	
			</li>
        <?php }?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS1)?$uploadSubMenuS1:'';?>" >
			<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/uploadfile/'.$editprojectIds.'">'; } ?> 
				<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_uploadfile'); ?>*</b></span> 
			<?php echo $anchorEnd;?>
			</li>
        <?php  if($indusrtyName != 'photographyNart') { ?>
			<li class="TabbedPanelsTab <?php echo isset($uploadSubMenuDisplayImg)?$uploadSubMenuDisplayImg:'';?>" > 
				<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/setdisplayimage/'.$editprojectIds.'">'; } ?>
					<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_setDisplayImage'); ?>*</b> </span>
				<?php echo $anchorEnd;?>
			</li>
        <?php }?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS2)?$uploadSubMenuS2:'';?>" > 
			<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/uploadtitle/'.$editprojectIds.'">'; } ?>
				<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_titleDescription'); ?>*</b> </span>
			<?php echo $anchorEnd;?>
		</li>
        <?php if( $ispriceShippingCharge == 1 || $ispriceShippingCharge == 3 ){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS3)?$uploadSubMenuS3:'';?>" > 
				<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/priceshippingcharge/'.$editprojectIds.'">'; } ?>
					<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_pricing'); ?>*</b> </span>
				<?php echo $anchorEnd;?>
			</li>
        <?php } ?>
        <?php if( $ispriceShippingCharge == 2 || $ispriceShippingCharge == 3 ){ ?>
            <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuShipping)?$uploadSubMenuShipping:'';?>" >
				<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/shippingcharge/'.$editprojectIds.'">'; } ?>
					<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_shipping'); ?>*</b> </span>
				<?php echo $anchorEnd;?>	
			</li>
        <?php } ?>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS4)?$uploadSubMenuS4:'';?>" > 
			<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/uploadimageinfo/'.$editprojectIds.'">'; } ?>
				<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_information'.$projCategory); ?>*</b></span>
			<?php echo $anchorEnd;?>
		</li>
        <li class="TabbedPanelsTab <?php echo isset($uploadSubMenuS5)?$uploadSubMenuS5:'';?>" >
			<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/uploadcreativeteam/'.$editprojectIds.'">'; } ?>
				<span><?php echo $this->lang->line('stepLabel'); ?> <?php echo $stageNumber; $stageNumber = $stageNumber +1; ?> <b><?php echo $this->lang->line('uploadStage_teaminfo'); ?></b></span>
			<?php echo $anchorEnd;?>
		</li>
    </ul>
    
    <?php if(isset($shippingNav) && !empty($shippingNav) && isset($deliveryOptions) && count($deliveryOptions) > 0) { ?>
        <div class="TabbedPanels tab_setting second_inner" id="TabbedPanels8"> 
            <div class="TabbedPanelsContentGroup width635 m_auto ">
                <div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting">
                    <!-- Shipping navigation bar start here -->
                   
                        <ul class="TabbedPanelsTabGroup width100_per">
                            <?php if(in_array('1',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS1Menu)?$shippingS1Menu:'';?>" >
									<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/pickupshipping/'.$editprojectIds.'">'; } ?>
										<span>Pickup </span>
                                    <?php echo $anchorEnd;?>
                                </li>
                            <?php }  
                            if(in_array('2',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS2Menu)?$shippingS2Menu:'';?>" >
									<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/domesticshipping/'.$editprojectIds.'">'; } ?>
										<span>Domestic Shipping</span>
                                    <?php echo $anchorEnd;?>  
                                </li>
                             <?php }  
                            if(in_array('3',$deliveryOptions)) { ?>
                                <li class="TabbedPanelsTab <?php echo isset($shippingS3Menu)?$shippingS3Menu:'';?>" >
									<?php if($isEditMedia == true && empty($isAddElement)) { echo '<a href="'.$baseUrl.'/internationalshipping/'.$editprojectIds.'">'; } ?>
										<span>International  Shipping </span>
                                    <?php echo $anchorEnd;?> 
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
