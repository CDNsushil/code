<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    $orderDate              =  date("d F Y",strtotime($membershipDetails['createDate']));
    $orderInvoiceNumber     =  getInvoiceId($membershipDetails['ordNumber'],1);

    //decode buyer info
    $buyerInfo              =  json_decode($membershipDetails['buyerInfo']);

    $vatNumber              =  (!empty($buyerInfo->EuVatIdentificationNumber))?$this->lang->line('vat_header_info_show').$buyerInfo->EuVatIdentificationNumber:'';

?>
    <font style="font-weight:bold; font-size:12px;"><?php echo $orderDate; ?></font>
    <div style="height:5px"></div>
    <font style="color:#f1592a; font-size:12px;  "><?php echo $orderInvoiceNumber; ?></font>
    <div style="height:20px"></div>
    <font><?php echo $vatNumber; ?></font> <br />
