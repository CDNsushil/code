<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    //get buyer information
    $buyerName          =  ucwords($buyerInfo['billing_firstName'].' '.$buyerInfo['billing_lastName']);
    $buyerAddress       =  $buyerInfo['billing_address1'];
    $buyerCity          =  $buyerInfo['billing_city']; 
    $buyerState         =  getstateName($buyerInfo['billing_state']);
    $buyerZip           =  $buyerInfo['billing_zip'];
    $buyerCountry       =  getCountry($buyerInfo['billing_country']);
    $buyerPhone         =  $buyerInfo['billing_phone']; 
    $buyerPhone        .=  ($buyerInfo['billing_phone']!="")?"<br>":""; 
    $buyerEmail         =  $buyerInfo['billing_email'];
    $EuVatIdentificationNumber  =  $buyerInfo['EuVatIdentificationNumber'];
?>

 <font style="font-size:22px; color:#b5b6b9;margin:0; line-height:24px;">Buyer</font>
<div style="height:13px"></div>
<font style="font-size:12px; font-weight:bold;"><?php echo $buyerName; ?></font>
<div style="height:13px"></div>
<?php echo $buyerAddress; ?><br />
<?php echo $buyerCity.', '.$buyerState.',  '.$buyerZip; ?><br />
<?php echo $buyerCountry; ?>
<div style="height:13px"></div>
<font style="color:#555555;"></font> 
<?php echo $buyerPhone.$buyerEmail; ?> 
