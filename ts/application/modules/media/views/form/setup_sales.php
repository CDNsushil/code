<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$baseUrl = formBaseUrl();  
?>
<!--========================== stage 1 :- second tab  ==============================-->

<div class="TabbedPanels tab_setting" id="TabbedPanels2"> 
    <ul class="TabbedPanelsTabGroup scond_li shipless">
        <li class="TabbedPanelsTab <?php echo isset($salesSetupS1Menu)?$salesSetupS1Menu:'';?>" ><span>Step 1 <b>Setup Sales*</b> </span></li>
        <?php
        $stepCount=2;
        if(isset($sellPriceType) && $sellPriceType != 3){?>
            <li class="TabbedPanelsTab <?php echo isset($salesSetupS2Menu)?$salesSetupS2Menu:'';?>" ><span>Step <?php echo $stepCount;?> <b>Pricing*</b></span></li>
        <?php
        $stepCount++;
        }
        if(isset($hasDownloadableFileOnly) && $hasDownloadableFileOnly==0){?>
            <li class="TabbedPanelsTab <?php echo isset($salesSetupS3Menu)?$salesSetupS3Menu:'';?>" ><span>Step <?php echo $stepCount;?> <b>Shipping*</b></span> </li>
        <?php
        $stepCount++;
        } ?>
        <li class="TabbedPanelsTab <?php echo isset($salesSetupS4Menu)?$salesSetupS4Menu:'';?>" ><span>Step <?php echo $stepCount;?> <b>Seller Settings*</b></span> </li>
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
                                        <span> Pickup </span>
                                    </li>
                                <?php }  
                                if(in_array('2',$deliveryOptions)) { ?>
                                    <li class="TabbedPanelsTab <?php echo isset($shippingS2Menu)?$shippingS2Menu:'';?>" >
                                        <span> Domestic Shipping</span>
                                    </li>
                                 <?php }  
                                if(in_array('3',$deliveryOptions)) { ?>
                                    <li class="TabbedPanelsTab <?php echo isset($shippingS3Menu)?$shippingS3Menu:'';?>" >
                                        <span> International  Shipping </span>
                                    </li>
                                <?php } ?>
                            </ul>
                        <!-- Shipping navigation bar end here --> 
                         
                        <!-- Seller setting navigation bar start here -->    
                        <?php } else if(isset($sellerNav) && !empty($sellerNav)) { ?>
                            <ul class="TabbedPanelsTabGroup width100_per">
                                <li class="TabbedPanelsTab <?php echo isset($sellerS1Menu)?$sellerS1Menu:'';?>" >
                                    <a href="<?php echo $baseUrl.'/sellerconsumptiontax/'.$elementId;?>">
                                        <span>A Consumption Tax* </span>
                                    </a>
                                </li>
                                <li class="TabbedPanelsTab <?php echo isset($sellerS2Menu)?$sellerS2Menu:'';?>" >
                                    <a href="<?php echo $baseUrl.'/sellerpaypal/'.$elementId;?>">
                                        <span>B PayPal* </span>
                                    </a>
                                </li>
                                <li class="TabbedPanelsTab <?php echo isset($sellerS3Menu)?$sellerS3Menu:'';?>" >
                                    <a href="<?php echo $baseUrl.'/sellersetting/'.$elementId;?>">
                                        <span>C Seller Settings* </span>
                                    </a>
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
