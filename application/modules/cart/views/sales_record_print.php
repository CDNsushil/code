<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<pre>";
//print_r($PurchaseRecord['get_result']);

//get currency type
 
$currencyType =  getCurrencyType($PurchaseRecord['get_result']->ordCurrency); ?>
<!------- for print --------->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Record: Toadsquare</title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />
<style>
/*@media print
{
	.height_first { height:300px; }
}*/
</style>
</head>

<body style="margin:0 auto; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif">

	<table width="615" cellspacing="0" cellpadding="0" border="0" align="center" style="margin-bottom:100px; font-size:12px;">
    	<tr>
        	<td style="padding-top:25px; color:#f15921; font-size:28px; letter-spacing:1px;vertical-align: bottom;">
           Sales Record
            </td>

            <td style="text-align:right; padding-top:27px;">
				<font style="color:#555555;"> Brought to you by</font><br>
             <img width="200" src="<?php echo base_url(); ?>images/toademaillogo_invoice.jpg" alt="salerecodd"/>
            </td>  
        </tr>
        
        <tr>
        	<td colspan="2" style="border-bottom:solid 1px #d4d4d4; padding-top:14px;">	
            </td>
        </tr>
        
        
        <tr>
        	<td colspan="2">
            	<table>
                	<tr>
                    	<td colspan="2" style="height:44px;"></td>
                    </tr>
                	<tr>
                    
                    	<td style="width:490px; vertical-align:top;">
                        	
                        	<table width="100%">
                            	<tr>
                                	<td>
                        <font style="color:#666666; font-weight:bold;">
							<?php echo date("d F Y H:i",strtotime($PurchaseRecord['get_result']->ordDateComplete)); ?></font><br>
							<font style="color:#666666; font-size:11px">
								Central European Time
							</font>
						<div style="height:6px"></div>
					    <font style="color:#f1592a;"><?php echo getInvoiceId($PurchaseRecord['get_result']->receiverTransactionId); ?></font> <br />
                        			</td>
                        		</tr> 
                       	 	</table>
                        </td>
                        
                        <td style="width:210px; vertical-align:top; <?php echo (!empty($getSellerDetail) && isset($getSellerDetail->email))?' border-left:3px solid #f15921;':'height:130px;'; ?>  padding-left:14px; color:#666666;">
						<?php if(!empty($getSellerDetail) && isset($getSellerDetail->firstName) && isset($getSellerDetail->email)) { ?>
                        <font style="font-size:22px; color:#888888;margin:0">Seller</font> <br /> <br />
                        <font style="font-weight:bold;"><?php echo ucwords($getSellerDetail->firstName.' '.$getSellerDetail->lastName); ?></font><br /> 
                        <?php echo $getSellerDetail->seller_address1; ?> <br>
                        <?php echo $getSellerDetail->seller_city; echo ($getSellerDetail->seller_city!="")?', ':''; ?> <?php echo $getSellerDetail->seller_state; ?>  <?php echo $getSellerDetail->seller_zip; ?> <br>
                        <?php echo $getSellerDetail->territoryCountryId; ?><br /><div style="height:6px"></div>
                        <?php echo $getSellerDetail->seller_phone; ?><br />
                        <?php echo $getSellerDetail->email; ?><br />
                        <?php
                        if(isset($getSellerDetail->sellerEuIdnumber) && $getSellerDetail->sellerEuIdnumber!='')
							{
								echo '#'.$getSellerDetail->sellerEuIdnumber;	
							} ?>
						<?php } ?>	
							
                        </td>
                        
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
        	<td style="border-bottom:solid 1px #d4d4d4; padding-top:30px;" colspan="2"></td> 
        </tr>
        
        
         <tr>
        	<td style="padding-bottom:25px;" colspan="2"></td> 
        </tr>
        
        <tr>
        	<td colspan="1" style="padding-left:14px; color:#666666; border-left:3px solid #f15921; vertical-align:top; width:225px;">    
                 <font style="font-size:22px; color:#888888;margin:0">Buyer</font> <br /> <br />
            	 <font style="font-weight:bold;"><?php echo ucwords($PurchaseRecord['get_result']->custName); ?></font> <br />
                       <?php echo $PurchaseRecord['get_result']->custStreetAddress; 
                        echo ($PurchaseRecord['get_result']->custStreetAddress!="")?', '.$PurchaseRecord['get_result']->custSuburb:''; ?> <br>
						<?php echo $PurchaseRecord['get_result']->custCity; ?>, <?php echo $PurchaseRecord['get_result']->custState; ?>  <?php echo $PurchaseRecord['get_result']->custZip; ?> <br>
						<?php echo $PurchaseRecord['get_result']->custCountry; ?> <br><div style="height:6px"></div>
                        <?php echo $PurchaseRecord['get_result']->custPhone; ?><br />
                        <?php echo $PurchaseRecord['get_result']->custEmail; ?><br><div style="height:6px"></div>
                        <?php if($PurchaseRecord['get_result']->registrationId != 0){ ?>
							<font style="color:#555555;"><?php echo  $PurchaseRecord['get_result']->registrationId; ?> (VAT Exemption)</font><br>
                        <?php } ?>
                         <?php if($PurchaseRecord['get_result']->otherInfoConsumptionTax !=''){ ?>
							<font style="color:#555555;"><?php echo  $PurchaseRecord['get_result']->otherInfoConsumptionTax; ?></font>
                        <?php } ?>
            </td>
            
            
            <td colspan="1" style="padding-left:7px; color:#666666; vertical-align:top;">    
            
            <?php if($isShipping=="yes") { ?>
            
                 <font style="font-size:22px; color:#888888;margin:0">Shipping Details</font> <br /> <br />
            	 <font style="font-weight:bold;"><?php echo ucwords($PurchaseRecord['get_result']->deliveryName); ?></font> <br />
                    <?php echo $PurchaseRecord['get_result']->deliveryStreet;
						  echo ($PurchaseRecord['get_result']->deliveryStreet!="")?', '.$PurchaseRecord['get_result']->deliverySuburb:'';?> 
                    <br>
					<?php echo $PurchaseRecord['get_result']->deliveryCity; ?>, <?php echo $PurchaseRecord['get_result']->deliveryState; ?>,  <?php echo $PurchaseRecord['get_result']->deliveryZip; ?> <br>
					<?php echo $PurchaseRecord['get_result']->deliveryCountry; ?> <br><div style="height:6px"></div>
					<?php echo $PurchaseRecord['get_result']->custPhone; ?><br />
					<?php echo $PurchaseRecord['get_result']->custEmail; ?>
			<?php } else { ?>
		         &nbsp;	
			<?php } ?>		
					
            </td>
            
            
        </tr>
        
        
      
        
        <tr>
        	<td colspan="2" style="padding-top:30px;">
            	<table style="border:8px solid #bdbec0; padding-top:24px; padding-bottom:24px; padding-left:10px; padding-right:10px;" width="100%;" bgcolor="#fafafb">
                	<tr>
                    	<td style="font-weight:bold; padding-left:10px;" width="210"> &nbsp; Description </td> 
                        <td style="font-weight:bold; text-align:right; padding-right:0px;" width="60">Price</td> 
                        <td style="font-weight:bold; text-align:right;" width="40">Qty</td>
                        <td style="font-weight:bold; text-align:right; padding-right:25px;" width="48">Total</td>
                    </tr>
                    
                    
                    <tr>
                    	<td style="padding-top:10px;"></td> 
                    </tr>
                    
                    <?php //print_r($getItemsDetils); 
					if($getItemsDetils['get_num_rows'] > 0){
					$addTotal=0;	
					$i=0;	
					foreach($getItemsDetils['get_result'] as $itemsDetils)	
					{
						$getClass = ($i==0)?'class="height_first"':'';
						//print_r($itemsDetils);
					?>
					
                    
                    <tr>
                    	<td colspan="4" <?php echo $getClass; ?> >
                        	<table border="0" style="border:solid 1PX #d4d4d4; padding-top:12px; padding-bottom:12px; background:#ffffff;" width="100%;">
                            	<tr>
                                	<td style="padding-left:10px; color:#666666" width="210" valign="top"><?php echo $itemsDetils->itemName; ?> 
                                    <br /> <br />
                                    
                                    <?php if($isEventDate=="yes") { 
										
								 $sessionDate = 	date("d M Y",strtotime($getSessionDetails->date));	
								 $sessionTime = 	$getSessionDetails->startTime;
								 $getTimeFormate= explode(":",$getSessionDetails->startTime);
							     $sessionTime = 	$getTimeFormate[0].':'.$getTimeFormate[1];	
										?>
                                    
                                    <font color="000;" style="padding-right:14px;"> Date </font> <?php echo  $sessionDate; ?>
                                     <br />
                                     <font color="000" style="padding-right:14px;"> Time </font> <?php echo  $sessionTime; ?>
                                    
                                    <?php } ?> 
                                    
                                    </td>  
                                    <td style="text-align:right; color:#666666" width="60" valign="top"><?php echo $currencyType.' '.number_format($itemsDetils->basePrice,2);?></td> 
                                    <td style="text-align:right; color:#666666" width="40" valign="top"><?php echo $itemsDetils->itemQty; ?></td>
                                    <td style="text-align:right;  padding-right: 20px;  color:#666666" width="50" valign="top">
										<?php
										$itemPrice = $itemsDetils->basePrice; 
										$itemQty = $itemsDetils->itemQty;
										$priceTotal = ($itemQty*$itemPrice);
										echo  $currencyType.' '.number_format($priceTotal,2);?></td>
                                </tr>
                                
                                <tr>
                                	<td style="text-align:right; 
                                	color:#666666;" 
                                	colspan="3">Consumption tax <font style="font-weight:bold; padding-left:5px;"><?php echo $itemsDetils->taxName.' '.$itemsDetils->taxPercent; ?>%</font></td>
                                    <td colspan="1" style="text-align:right; color:#666666; padding-right:20px;"><?php 
									$vatTaxValue =  $itemsDetils->taxValue;
                                    echo $currencyType.' '.number_format($itemsDetils->taxValue,2); ?></td>
                                </tr>
                                <tr>
                         <td style="text-align:right; color:#666666; font-weight:bold; font-size:14px;" colspan="3">Total</td>
                        <td colspan="1" style="text-align:right; color:#666666; padding-right:20px;font-weight:bold; font-size:14px"> <?php 
							$mainPriceTotal = $priceTotal+$vatTaxValue;
							echo  $currencyType.' '.number_format($mainPriceTotal,2);?></td> 
                                </tr> 
                                
                                 <tr>
                                
                         <td colspan="4" valign="top"> <hr color="#f15921" width="540px;" size="1"/></td>
                        		
                                </tr>  
                                
                                
                                <tr>
                                <td style="padding-top:15px;" colspan="4"></td>
                                </tr>
                                
                                <tr>
                                	<td valign="top" colspan="1" style="padding-left:10px;color:#f1592a;">Type <font style="font-weight:bold; color:#666666; padding-left:4px;"><?php echo getPurchaseType($itemsDetils->purchaseType); ?></font></td>
                                    <td valign="top" colspan="2" 
                                    style="text-align:right; 
                                    color:#666666;">Toadsquare Service Fee * 
                                    <br /> <font style="font-weight:bold;">VAT <?php echo $itemsDetils->tsVatPercent; ?>%</font>
                                    </td>
                                    <td valign="top" colspan="1" style="text-align:right; padding-right:20px; color:#666666;"><?php echo $currencyType.' '.number_format($itemsDetils->tsCommissionValue,2); ?><br /> <?php echo $currencyType.' '.number_format($itemsDetils->tsVatValue,2); ?></td>
                                </tr>
                                
                                
                                <tr>
									
									<td width="35%" style="color:#666666; padding-left:10px; width: auto;vertical-align: top;padding-top: 3px; text-align: justify;">
									<font color="666666" style="font-size:10px;" >
                                    <?php 
                                   //This section show  message according to type 
                                   //1:shipping,2:download,3:PPV,4:Donation, 5: event
                                    switch($itemsDetils->purchaseType)
										{
											case 1:
											$purchaseMessage='Shipping details entered by the Seller on their Sales page can be seen on the Buyer\'s Purchses page.';
											
											break;
											case 2:
											$getDownloadPeriod = getDownloadPeriod($itemsDetils->itemId);
											$startDateShow  =  date("d F Y",strtotime($getDownloadPeriod->dwnDate));
											$dwnMaxday = $getDownloadPeriod->dwnMaxday;
											$endDataShow = mktime(0,0,0,date("m",strtotime($getDownloadPeriod->dwnDate)),date("d",strtotime($getDownloadPeriod->dwnDate))+$dwnMaxday,date("Y",strtotime($getDownloadPeriod->dwnDate)));
											$endDataShow = date("d F Y", $endDataShow);
											$purchaseMessage='The Purchase can be downloaded from the Buyer\'s Purchases page  '.$startDateShow.' to '.$endDataShow.'.';
											break;
											case 3:
											$getDownloadPeriod = getDownloadPeriod($itemsDetils->itemId);
											$startDateShow  =  date("d F Y",strtotime($getDownloadPeriod->dwnDate));
											$dwnMaxday = $getDownloadPeriod->dwnMaxday;
											$endDataShow = mktime(0,0,0,date("m",strtotime($getDownloadPeriod->dwnDate)),date("d",strtotime($getDownloadPeriod->dwnDate))+$dwnMaxday,date("Y",strtotime($getDownloadPeriod->dwnDate)));
											$endDataShow = date("d F Y", $endDataShow);
											$purchaseMessage='The Purchase can be viewed from the Buyer\'s Purchases page '.$startDateShow.' to '.$endDataShow.'.';
											break;
											case 4:
											$purchaseMessage='';
											break;
											case 5:
											$purchaseMessage='Buyers will receive their tickets by email and they can also print them from their Purchases page.';
											break;
											default:
												$purchaseMessage="None";
										}
                                    echo $purchaseMessage;
                                     ?>
                                     </font>
									
								</td>
                                    <td  width="30%" colspan="3" style="text-align:right;color:#666666; padding-right:20px; width: auto;vertical-align: top;padding-top: 3px;">
										<font style='font-size:10px;'>* The Toadsquare Service Fee is not refundable.</font></td>
                                </tr>
                                
                                
                            </table>
                        </td>
                    </tr>
                
                <?php $i++; } } ?>
                    

                </table>
            </td>
        </tr>
    
    </table>
    
</body>
</html>

