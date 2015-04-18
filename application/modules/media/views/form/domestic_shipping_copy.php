<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$domesticShippingSetupForm = array(
	'name' => 'domesticShippingSetupForm',
	'id'   => 'domesticShippingSetupForm'
);

// set base url
$baseUrl = formBaseUrl(); 
?>
	
<div id="TabbedPanels7" class="TabbedPanels tab_setting"> 
    <!--========== Setup your Auction  =================-->
    <div class="TabbedPanelsContentGroup"> 
        <!--========== Setup your Auction  =================-->
        <?php echo form_open($baseUrl.'/domesticshipping/'.$projectId.'/'.$elementId,$domesticShippingSetupForm); ?>
            <div class="TabbedPanelsContent">
                <div class="c_1">
                    <h3 class="red fs21 "> Setup Domestic Shipping* </h3>
                    <div class="sap_40"></div>
                    <ul class=" display_table clearb rate_wrap defaultP">
                        <li >
                            <label>
                                <input  type="radio" name="isCopy" value="t" checked="checked" >
                                Copy and then edit your Domestic Shipping details from your Seller Settings
                            </label>
                        </li>
                                 
                        <li class="pt20 pb20 pl30">OR </li>
                        <li> 
                            <label>
                                <input  type="radio" name="isCopy" value="f" >
                                Enter new Domestic Shipping details. 
                            </label>
                        </li>
                    </ul>
                    <ul class=" clearb  org_list">
                        <li class="icon_1">Buyers can only buy from you if they live in countries you setup shipping for. </li>
                        <li class="icon_2">This setting is stored in your <b>Seller Settings</b>. <b>Your Toadsquare</b> menu > <b>Global Setttings</b>. </li>
                    </ul>
                </div>
                <?php 
                // set back page name
                $data['backPage'] = 'shipping';
                $this->load->view('common_view/shipping_buttons',$data);
                ?>
            </div>
        <?php  echo form_close();?>
    </div>
</div>
