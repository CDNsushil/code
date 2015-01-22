<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$currencySign    =  $this->config->item('toadCurrencySgine');
$taxPercent      =  $membershipDetails['taxPercent'];
$taxValue        =  (!empty($membershipDetails['taxValue']))?$currencySign.' '.number_format($membershipDetails['taxValue'],2):'----';
$grandTotal      =  $currencySign.' '.number_format($membershipDetails['grandTotal'],2);
?>


<table border="0" style="background:#f7f8f8; width:615px; padding-top:22px; padding-bottom:24px; padding-left:10px; padding-right:10px;"  bgcolor="#fafafb">
   <tr>
      <td width="200" style="font-weight:bold; padding-left:48px;">Tool</td>
      <td width="90" style="font-weight: bold; text-align: right; padding-right: 10px;">Size</td>
      <td width="50" style="font-weight: bold; text-align: right; padding-right: 10px;">Price</td>
      <td width="40" style="font-weight: bold; text-align: right; padding-right: 9px;">Qty</td>
      <td width="50" style="font-weight: bold; text-align: right; padding-right: 48px;">Total</td>
   </tr>
   <tr>
      <td colspan="5" style="padding-top:3px;"></td>
   </tr>
   <tr>
      <td colspan="5" >
         <table border="0" cellspacing="0" cellpadding="0" style="border:solid 1PX #000; padding:10px 15px; background:#ffffff; width:530px; margin:0 auto; box-shadow:0 0 3px #ccc; -webkit-box-shadow:0 0 3px #ccc; -moz-box-shadow:0 0 3px #ccc; ">
            
             <?php if(!empty($membershipItemList)){
                 foreach($membershipItemList as $membershipItem){
                    
                    //get parent container id for associated space get
                    $parentContId   =   $membershipItem['parentContId'];
                  
                    // show only container and add  space will show with associated container
                    // container + add extra space
                    if($parentContId==0){
                        
                        $itemType       =  $membershipItem['type']; 
                        if($itemType=="1"){    
                            $itemName       =  $membershipItem['title'];     
                        }else{
                            $itemName       =  'Space';   
                         }
                        $basePrice      =  $membershipItem['basePrice']; 
                        $memItemId      =  $membershipItem['memItemId']; 
                        $itemSize       =  bytestoMB($membershipItem['size'] + getItemSize($memItemId)).' MB'; 	
                        $itemPrice      =  $currencySign.' '.number_format($basePrice + getItemAmount($memItemId),2); 	
                        $itemQuantity   =  1; 	
                        $itemTotalPrice =  $itemPrice;
                        
                   ?>
                    <tr style="background:#f7f8f8;">
                        <td style="padding-right:24px; color:#666666;height:22px;vertical-align: middle;" width="220" valign="top"><?php echo $itemName; ?> </td>
                        <td style="text-align:right; color:#666666;border-right:1px solid #ccc; vertical-align: middle;padding-right: 10px;" width="75" valign="top"><?php echo $itemSize; ?></td>
                        <td style="text-align:right; color:#666666;border-right:1px solid #ccc; vertical-align: middle;padding-right: 10px;" width="50" valign="top"><?php echo $itemPrice; ?></td>
                        <td style="text-align:right; color:#666666;border-right:1px solid #ccc;padding-right: 15px;  vertical-align: middle;" width="40" valign="top"><?php echo $itemQuantity; ?></td>
                        <td style="text-align:right;    color:#666666; vertical-align: middle;" width="60" valign="top"><?php echo $itemTotalPrice; ?></td>
                    </tr>

            <?php }  }  } ?>
            
            <tr>
               <td style="text-align:right; color:#666666;padding-top:40px; padding-right:30px;height:25px;" colspan="4">Consumption tax <font style="font-weight:bold; padding-left:5px;">VAT <?php echo $taxPercent; ?>%</font></td>
               <td colspan="1" style="text-align:right; color:#666666; padding-top:40px; padding-right:0px;"><?php echo $taxValue; ?></td>
            </tr>
            <tr >
               <td style="text-align:right;border-top:1px solid rgb(241, 89, 33); color:#1e1e21; font-weight:bold; font-size:14px; padding:0 30px 15px;height:25px; " colspan="4">Total</td>
               <td width="60" colspan="1" style="text-align:right; color:#1e1e21;border-top:1px solid rgb(241, 89, 33); padding:0px 0 15px;font-weight:bold; font-size:14px; height:25px;"><?php echo $grandTotal; ?></td>
            </tr>
         </table>
      </td>
   </tr>
</table>
