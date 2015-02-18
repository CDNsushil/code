<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$pickupShippingSetupForm = array(
    'name' => 'pickupShippingSetupForm',
    'id'   => 'pickupShippingSetupForm'
);

// set base url
$baseUrl = formBaseUrl();
?>
	
<div id="TabbedPanels7" class="TabbedPanels tab_setting second_inner"> 
    <!--========== Setup your Auction  =================-->
    <?php echo form_open($baseUrl.'/pickupshipping/'.$projectId.'/'.$elementId,$pickupShippingSetupForm); ?>
        <div class="c_1">
           <h3 class="red fs21   bb_aeaeae"> Setup Pickup details* </h3>
            <div class="sap_35"></div>
            <ul class=" display_table clearb rate_wrap defaultP">
                <li >
                    <label>
                        <input  type="radio" name="isCopy" value="t" checked="checked" >
                        Copy and then edit your Pickup details from your Seller Settings.
                    </label>
                </li>
                <li class="or_text">OR </li>
                <li>     
                    <label>
                        <input  type="radio" name="isCopy" value="f" >
                        Enter new Pickup details.  
                    </label>
                </li>
            </ul>
            <ul class=" clearb org_list">
                <li class="icon_1">Buyers can only buy from you if they live in countries you setup shipping for. </li>
                <li class="icon_2"><?php echo $this->lang->line('settingStoreInGlobal');?></li>
            </ul>           
            <?php 
            // set back page name
            $data['backPage'] = 'shipping';
            $this->load->view('common_view/shipping_buttons',$data);
            ?>
    <?php  echo form_close();?>
</div>
