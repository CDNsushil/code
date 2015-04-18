<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$baseUrl = formBaseUrl();  
$pt10 = '';
// get session value of edit media mode
$isEditMedia = $this->session->userdata('isEditMedia');
$editCls = '';
if(!empty($isEditMedia)) {
	$pt10 = 'pt10';
	$isEditMedia = true;
	$anchorEnd = '</a>';
	$editCls = 'editWizardTab';
}
?>
<!--========================== stage 1 :- second tab  ==============================-->

<div class="TabbedPanels tab_setting <?php echo $pt10.' '.$editCls;?>" id="TabbedPanels2"> 
    <ul class="TabbedPanelsTabGroup scond_li shipless">
        <li class="TabbedPanelsTab <?php echo isset($salesSetupS1Menu)?$salesSetupS1Menu:'';?>" >
			<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/setupsales/'.$projectId.'">'; } ?>
				<span>Step 1 <b>Setup Sales*</b> </span>
			<?php echo $anchorEnd;?>
		</li>
        <?php
        $stepCount=2;
        if(isset($sellPriceType) && $sellPriceType != 3){?>
            <li class="TabbedPanelsTab <?php echo isset($salesSetupS2Menu)?$salesSetupS2Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/pricing/'.$projectId.'">'; } ?>
					<span>Step <?php echo $stepCount;?> <b>Pricing*</b></span>
				<?php echo $anchorEnd;?>
			</li>
        <?php
        $stepCount++;
        }
        if(isset($hasDownloadableFileOnly) && $hasDownloadableFileOnly==0){?>
            <li class="TabbedPanelsTab <?php echo isset($salesSetupS3Menu)?$salesSetupS3Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/shipping/'.$projectId.'">'; } ?>
					<span>Step <?php echo $stepCount;?> <b>Shipping*</b></span> 
				<?php echo $anchorEnd;?>
			</li>
			<?php
			$stepCount++;
        } ?>
        <li class="TabbedPanelsTab <?php echo isset($salesSetupS4Menu)?$salesSetupS4Menu:'';?>" >
			<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/sellerconsumptiontax/'.$projectId.'">'; } ?>
				<span>Step <?php echo $stepCount;?> <b>Seller Settings*</b></span> 
			<?php echo $anchorEnd;?>
		</li>
    </ul>
    <div class="TabbedPanelsContentGroup   clearb shipgroup"> 
        <div class="TabbedPanelsContent TabbedPanelsContentVisible"> 
            <div id="TabbedPanels8" class="TabbedPanels tab_setting second_inner"> 
                <!--========== Setup your Auction  =================-->
                <?php
                    if(isset($sabNavigation) && !empty($sabNavigation)){
                        $this->load->view($sabNavigation);
                    }
                ?>
                <div class="TabbedPanelsContentGroup width635  m_auto ">
                    <div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting">
                        <!-- Shipping navigation bar start here -->
                        <?php if(isset($shippingNav) && !empty($shippingNav) && isset($deliveryOptions) && count($deliveryOptions) > 0) { ?>
                            <ul class="TabbedPanelsTabGroup width100_per">
                                <?php if(in_array('1',$deliveryOptions)) { ?>
                                    <li class="TabbedPanelsTab <?php echo isset($shippingS1Menu)?$shippingS1Menu:'';?>" >
										<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/pickupshipping/'.$projectId.'">'; } ?>
											<span> Pickup </span>
										<?php echo $anchorEnd;?> 
                                    </li>
                                <?php }  
                                if(in_array('2',$deliveryOptions)) { ?>
                                    <li class="TabbedPanelsTab <?php echo isset($shippingS2Menu)?$shippingS2Menu:'';?>" >
										<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/domesticshipping/'.$projectId.'">'; } ?>
											<span> Domestic Shipping</span>
										<?php echo $anchorEnd;?>                                        
                                    </li>
                                 <?php }  
                                if(in_array('3',$deliveryOptions)) { ?>
                                    <li class="TabbedPanelsTab <?php echo isset($shippingS3Menu)?$shippingS3Menu:'';?>" >
										<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/internationalshipping/'.$projectId.'">'; } ?>
											<span> International  Shipping </span>
										<?php echo $anchorEnd;?> 
                                    </li>
                                <?php } ?>
                            </ul>
                        <!-- Shipping navigation bar end here --> 
                         
                        <!-- Seller setting navigation bar start here -->    
                        <?php } else if(isset($sellerNav) && !empty($sellerNav)) { ?>
                            <ul class="TabbedPanelsTabGroup width100_per">
                                <li class="TabbedPanelsTab <?php echo isset($sellerS1Menu)?$sellerS1Menu:'';?>" >
									<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/sellerconsumptiontax/'.$elementId.'">'; } ?>
                                        <span>A Consumption Tax* </span>
                                    <?php echo $anchorEnd;?> 
                                </li>
                                <li class="TabbedPanelsTab <?php echo isset($sellerS2Menu)?$sellerS2Menu:'';?>" >
									<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/sellerpaypal/'.$elementId.'">'; } ?>
                                        <span>B PayPal* </span>
                                    <?php echo $anchorEnd;?> 
                                </li>
                                <li class="TabbedPanelsTab <?php echo isset($sellerS3Menu)?$sellerS3Menu:'';?>" >
									<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/sellersetting/'.$elementId.'">'; } ?>
                                        <span>C Seller Settings* </span>
									<?php echo $anchorEnd;?>
                                </li>
                            </ul>
                        <?php } ?>
                        <!-- Seller setting navigation bar end here --> 
                        
                        <?php $this->load->view($subInnerPage); ?>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>             
