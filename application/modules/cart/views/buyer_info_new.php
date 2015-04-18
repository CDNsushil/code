<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 <!--
<div class="poup_bx min_wi250 shadow">
<div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
<div class="row clr_444 pt10">
    <a target="_blank" class="color_444_imp td_imp" href="<?php  //echo base_url().'showcase/aboutme/'.$PurchaseRecord['get_result']->customerUid; ?>">
<b><?php //echo ucwords($PurchaseRecord['get_result']->custName); ?></b><br /><br />
            <?php //echo $PurchaseRecord['get_result']->custStreetAddress; ($PurchaseRecord['get_result']->custStreetAddress!="")?','.$PurchaseRecord['get_result']->custSuburb:''; ?> <br>
            <?php //echo $PurchaseRecord['get_result']->custCity; ?>, <?php //echo $PurchaseRecord['get_result']->custState; ?>  <?php //echo $PurchaseRecord['get_result']->custZip; ?> <br>
            <?php //echo $PurchaseRecord['get_result']->custCountry; ?> <br><br />
            <?php //echo $PurchaseRecord['get_result']->custPhone; ?><br />
            
        <a class="hoverOrange" href="mailto:<?php //echo $PurchaseRecord['get_result']->custEmail; ?>?subject=InvoiceId:<?php //echo $invoiceId ?>">	
            <?php //echo $PurchaseRecord['get_result']->custEmail; ?></a><br>
            
            <?php if($PurchaseRecord['get_result']->registrationId != 0){ ?>
                <?php //echo  $PurchaseRecord['get_result']->registrationId; ?>
            <?php } ?> <br>
</div>
-->

<div class="poup_bx min_wi250 shadow">
<div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
            <div class="row clr_444 pt10"> 
    <a target="_blank" class="color_444_imp td_imp" href="<?php  echo base_url().'showcase/aboutme/'.$PurchaseRecord['get_result']->customerUid; ?>">
    
	<p class="opens_light fs20 red"><?php echo ucwords($PurchaseRecord['get_result']->custName); ?></p> 
        <br>
        <?php echo $PurchaseRecord['get_result']->custStreetAddress; ($PurchaseRecord['get_result']->custStreetAddress!="")?','.$PurchaseRecord['get_result']->custSuburb:''; ?> <br>
            <?php echo $PurchaseRecord['get_result']->custCity; ?>, <?php echo $PurchaseRecord['get_result']->custState; ?>  <?php echo $PurchaseRecord['get_result']->custZip; ?> <br>
            <?php echo $PurchaseRecord['get_result']->custCountry; ?> <br><br />
            <?php echo $PurchaseRecord['get_result']->custPhone; ?><br />
            

     </a>  <a href="mailto:<?php echo $PurchaseRecord['get_result']->custEmail; ?>?subject=InvoiceId:<?php echo $invoiceId ?>">     <?php echo $PurchaseRecord['get_result']->custEmail; ?></a> <br>
             <?php if($PurchaseRecord['get_result']->registrationId != 0){ ?>
                <?php echo  $PurchaseRecord['get_result']->registrationId; ?>
            <?php } ?> <br>
      </div>
          </div>
