<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <?php if($purchaseDetails['get_num_rows']>0){
    $formId= 1;
    foreach($purchaseDetails['get_result'] as  $purchaseData)
    { 
    
        //get buyer name    
        if(!empty($purchaseData->enterprise) && $purchaseData->enterprise=="t"){
            $buyerName  =   $purchaseData->enterpriseName;
        }else{
            $buyerName  =   $purchaseData->firstName.' '.$purchaseData->lastName;
        }

        $purchase_Data['purchaseData']  =   $purchaseData;
        $purchase_Data['buyerName']     =   $buyerName;
        $purchase_Data['formId']        =   $formId;
    ?>

    <!---div start--->
    <?php 
    //1:shipping,2:download,3:PPV,4:Donation
    $isProductAuction = $purchaseData->isProductAuction;
    switch($purchaseData->purchaseType)

    {
        case 1: 
            //shipping
            if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                $this->load->view('sales_purchase_view/auction_product_sales_view_new',$purchase_Data); 
            }else{
                $this->load->view('sales_purchase_view/sales_shipped_view_new',$purchase_Data); 
            }
            $formId++;
        break;
        case 2: 
             //download
            if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                $this->load->view('sales_purchase_view/auction_product_sales_view_new',$purchase_Data); 
            }else{   
                $this->load->view('sales_purchase_view/sales_download_view_new',$purchase_Data); 
            }
        break;
        case 3:
             //PPV
            if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                $this->load->view('sales_purchase_view/auction_product_sales_view_new',$purchase_Data); 
            }else{    
                $this->load->view('sales_purchase_view/sales_ppv_view_new',$purchase_Data); 
            }
        break;
        case 4: 
             //Donation
            $this->load->view('sales_purchase_view/sales_donation_view_new',$purchase_Data); 
        break;
        case 5: 
             //ticket
            if($isProductAuction=="t"){
                $this->load->view('sales_purchase_view/auction_product_sales_view_new',$purchase_Data); 
            }else{
                $this->load->view('sales_purchase_view/sales_ticket_view_new',$purchase_Data); 
            }
        break;
        
        case 6: //auction
            $this->load->view('sales_purchase_view/sales_auction_view_new',$purchase_Data); 
            $formId++;
        break;
    }

    ?>

    <!--div end-->

    <?php }   } ?>
