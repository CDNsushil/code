<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ?>
 <div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
    <div id="show_comment" class="dash_boxgradient min_height_125 width228px">
        <a target="_blank" href="<?php  echo base_url().'showcase/aboutme/'.$PurchaseRecord['get_result']->customerUid; ?>">
            <div class="seprator_5"></div>
            <div class="row clr_888 pl10">			
                
            <b><?php echo ucwords($PurchaseRecord['get_result']->custName); ?></b><br /><br />
            <?php echo $PurchaseRecord['get_result']->custStreetAddress; ($PurchaseRecord['get_result']->custStreetAddress!="")?','.$PurchaseRecord['get_result']->custSuburb:''; ?> <br>
            <?php echo $PurchaseRecord['get_result']->custCity; ?>, <?php echo $PurchaseRecord['get_result']->custState; ?>  <?php echo $PurchaseRecord['get_result']->custZip; ?> <br>
            <?php echo $PurchaseRecord['get_result']->custCountry; ?> <br><br />
            <?php echo $PurchaseRecord['get_result']->custPhone; ?><br />
            
        <a class="hoverOrange" href="mailto:<?php echo $PurchaseRecord['get_result']->custEmail; ?>?subject=InvoiceId:<?php echo $invoiceId ?>">	
            <?php echo $PurchaseRecord['get_result']->custEmail; ?></a><br>
            
            <?php if($PurchaseRecord['get_result']->registrationId != 0){ ?>
                <?php echo  $PurchaseRecord['get_result']->registrationId; ?>
            <?php } ?>
            </div>
        <a>	
    </div>

