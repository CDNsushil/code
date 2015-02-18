<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 
		if($membershipOrderDetails->orderType==2)
		{
			//title_refund
			echo $this->lang->line('title_refund');
		}else
		{
			echo $this->lang->line('title_invoice'); 
		}	

?>
</title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />
</head>

<body style="margin:0 auto; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif">
<table width="615" cellspacing="0" cellpadding="0" border="0" align="center" style="margin-bottom:100px; font-size:12px;">
    <tr>
        <td style="padding-top:25px; color:#f15921; font-size:35px; letter-spacing:1px;vertical-align: bottom;"> <?php 
				$invoice_heading=$this->lang->line('invoice_heading');
				if($membershipOrderDetails->orderType==2){
					$invoice_heading=$this->lang->line('refund');
				}
				echo $invoice_heading;
				?>
        </td>
        <td style="text-align:right; padding:27px 3px 0 0;"><img   src="<?php echo base_url(); ?>images/logo_12.png" alt="invoice"></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:solid 1px #000; padding-top:15px;"></td>
    </tr>
    <tr>
        <td colspan="2"><table>
                <tr>
                    <td colspan="2" style="height:62px;"></td>
                </tr>
                <tr>
                    <?php $buyerInfo = json_decode($membershipOrderDetails->buyerInfo); ?>
                    <td style="width:490px; padding:0; vertical-align:top; color:#666666; "><table width="100%">
                            <tr>
                                <td style="padding:0;"><font style="font-weight:bold; font-size:12px;"><?php
						 echo date("d F Y",strtotime($membershipOrderDetails->createDate)); ?></font>
                                    <div style="height:5px"></div>
                                    <font style="color:#f1592a; font-size:12px;  "><?php echo getInvoiceId($membershipOrderDetails->ordNumber,1); ?></font>
                                    <div style="height:20px"></div>
                                    
                                    <?php 
                                      $EuVatIdentificationNumber = 0;
                                      if($buyerInfo->EuVatIdentificationNumber != 0){ 
                                    ?>
                                      <font><?php echo $buyerInfo->EuVatIdentificationNumber; ?> <?php echo $this->lang->line('vat_exemption_invoice'); ?></font> <br />
                                    
                                    <?php } ?>
                                    
                                    </td>
                            </tr>
                        </table></td>
                    <td style="width:183px; line-height:15px; font-size:12px; vertical-align:middle; border-left:3px solid #f15921; padding:4px 0 0 14px; color:#666666;">
                      <font style="color:#666666; font-weight:bold; line-height:0px;"><?php echo $this->lang->line('toadsquare_info'); ?></font> <br />
                        <div style="height:17px"></div>
                       <?php echo $this->lang->line('toadsquare_address_1'); ?><br>
                        <?php echo $this->lang->line('toadsquare_address_2'); ?><br>
                       <?php echo $this->lang->line('toadsquare_address_3'); ?><br />
                        <div style="height:10px"></div>
                       	<?php echo $this->lang->line('toadsquare_webaddress'); ?><br>
                        <font style="line-height:11px; float:left; padding-top:2px;"><?php echo $this->lang->line('membership_email'); ?></font>
                        <?php echo $this->lang->line('membership_regis_no'); ?>
                        </td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td colspan="1" style=" color:#666666; vertical-align:top;  padding:10px 0 0; line-height:14px; width:225px;">
          <font style="font-size:22px; color:#b5b6b9;margin:0; line-height:24px;"><?php echo $this->lang->line('invoice_buyer'); ?></font>
            <div style="height:13px"></div>
            <font style="font-size:12px; font-weight:bold;"><?php echo ucwords($buyerInfo->billing_firstName.' '.$buyerInfo->billing_lastName); ?></font>
            <div style="height:13px"></div>
            <?php echo $buyerInfo->billing_address1; ?><br />
            <?php echo $buyerInfo->billing_city; ?>, <?php echo $buyerInfo->billing_state; ?>, <?php echo $buyerInfo->billing_zip; ?><br />
            <?php echo $buyerInfo->billing_country; ?>
            <div style="height:13px"></div>
            <font style="color:#555555;"></font>  <?php echo $buyerInfo->billing_phone;
                        if($buyerInfo->billing_phone!="") { echo "<br>";}
                         ?>
            <?php echo $buyerInfo->billing_email; ?> </td>
        <td colspan="1" style="padding-left:7px; color:#666666; vertical-align:top;">   </td>
    </tr>
    <tr>
        <td style="border-bottom:solid 1px #000; padding-top:45px;" colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top:65px;"><table border="0" style="background:#f7f8f8; width:615px; padding-top:22px; padding-bottom:24px; padding-left:10px; padding-right:10px;"  bgcolor="#fafafb">
                <tr>
                    <td width="280" style="font-weight:bold; padding-left:48px;">
                      
                      <?php   echo $this->lang->line('invoice_item_mem_desc'); ?>
                      
                      </td>
                    <td width="50" style="font-weight: bold; text-align: right; padding-right: 10px;"><?php echo $this->lang->line('invoice_item_price'); ?></td>
                    <td width="40" style="font-weight: bold; text-align: right; padding-right: 9px;"><?php echo $this->lang->line('invoice_item_qty'); ?></td>
                    <td width="50" style="font-weight: bold; text-align: right; padding-right: 48px;"><?php echo $this->lang->line('invoice_item_total'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:3px;"></td>
                </tr>
                <tr>
                    <td colspan="4" ><table border="0" cellspacing="0" cellpadding="0" style="border:solid 1PX #000; padding:10px 15px; background:#ffffff; width:530px; margin:0 auto; box-shadow:0 0 3px #ccc; -webkit-box-shadow:0 0 3px #ccc; -moz-box-shadow:0 0 3px #ccc; ">
                            
                            <?php
                            	if($get_membership_item['get_num_rows'] > 0){
                              $amountAdd="";
                                            foreach($get_membership_item['get_result'] as $membership_item)	
                              {
                              //print_r($membership_item);	
                              
                               if($membership_item->pkgId==$this->config->item('package_1_year_id')){
                                  $item_name = $this->config->item('package_title_2'); 
                                }elseif($membership_item->pkgId==$this->config->item('package_3_year_id')){
                                  $item_name = $this->config->item('package_title_3'); 
                                }
                                else{
                                  if($membership_item->type=='9'){
                                     $item_name = $membership_item->title.' ('.bytestoMB($membership_item->size).' MB )'; 
                                  }else{
                                     $item_name = $membership_item->title; 
                                  }
                                 
                                }

                            ?>
                            <tr style="background:#f7f8f8;">
                                <td style="padding-right:24px; color:#666666;height:22px;vertical-align: middle;" width="310" valign="top"><?php echo $item_name; ?> </td>
                                <td style="text-align:right; color:#666666;border-right:1px solid #ccc; vertical-align: middle;padding-right: 15px;" width="50" valign="top"><?php echo $this->lang->line('currency'); ?> <?php echo number_format($membership_item->basePrice + getItemAmount($membership_item->memItemId),2); ?></td>
                                <td style="text-align:right; color:#666666;border-right:1px solid #ccc;padding-right: 15px;  vertical-align: middle;" width="40" valign="top">1</td>
                                <td style="text-align:right;    color:#666666; vertical-align: middle;" width="60" valign="top"><?php echo $this->lang->line('currency'); ?> <?php 
                                    echo number_format($membership_item->basePrice + getItemAmount($membership_item->memItemId),2);
                                    //$amountAdd = $membership_item->basePrice + getItemAmount($membership_item->memItemId) +  $amountAdd;
                                     ?></td>
                            </tr>
                            
                               <?php } }
                                
                                $vat_percent =  $membershipOrderDetails->taxPercent;
                                $taxValue = $membershipOrderDetails->taxValue;
                                                $vat_value = $this->lang->line('currency').' '.number_format($taxValue,2);
                                             
                                                // this section for if EuVatIdentification is available
                                               
                                                if($membershipOrderDetails->taxPercent==0)
                                {
                                  $vat_percent = 0;
                                  $vat_value = '----';
                                  $taxValue = 0;
                                }
                                                
                                 ?>
                            
                            <tr>
                                <td style="text-align:right; color:#666666;padding-top:40px; padding-right:30px;height:25px;" colspan="3"><?php echo $this->lang->line('invoice_consumption_tax'); ?> <font style="font-weight:bold; padding-left:5px;"><?php echo $this->lang->line('invoice_VAT'); ?> <?php echo $vat_percent; ?>%</font></td>
                                <td colspan="1" style="text-align:right; color:#666666; padding-top:40px; padding-right:0px;"><?php 
                                    echo $vat_value;
                                     ?>
                                     </td>
                            </tr>
                            <tr >
                                <td style="text-align:right;border-top:1px solid rgb(241, 89, 33); color:#1e1e21; font-weight:bold; font-size:14px; padding:0 30px 15px;height:25px; " colspan="3"><?php echo $this->lang->line('invoice_total'); ?></td>
                                <td width="60" colspan="1" style="text-align:right; color:#1e1e21;border-top:1px solid rgb(241, 89, 33); padding:0px 0 15px;font-weight:bold; font-size:14px; height:25px;"><?php echo $this->lang->line('currency'); ?> <?php
                        
                         //$mainAmount= $taxValue+$amountAdd;
                          $mainAmount= $membershipOrderDetails->totalPaid;
                           echo number_format($mainAmount,2); ?>
                           </td>
                            </tr>
                        </table></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:solid 1px #000;padding-top:150px;"></td>
    </tr>
</table>
</body>
</html>

