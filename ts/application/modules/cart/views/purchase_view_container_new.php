<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <?php if($purchaseDetails['get_num_rows']>0){ 
        $formId= 1;
        foreach($purchaseDetails['get_result'] as  $purchaseData)
        { //print_r($purchaseData);

        $purchase_Data['purchaseData'] = $purchaseData;
        $purchase_Data['formId'] = $formId;
        ?>

        <!---div start--->
        <?php 
        //1:shipping,2:download,3:PPV,4:Donation
        $isProductAuction = $purchaseData->isProductAuction;
        
        switch($purchaseData->purchaseType)
        {
            case 1: //shipping
                if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                    $this->load->view('sales_purchase_view/auction_product_purcahsed_view_new',$purchase_Data); 
                }else{    
                    $this->load->view('sales_purchase_view/purchase_shipped_view_new',$purchase_Data); 
                }
                $formId++;
            break;
            case 2: //download
                if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                    $this->load->view('sales_purchase_view/auction_product_purcahsed_view_new',$purchase_Data); 
                }else{
                   $this->load->view('sales_purchase_view/purchase_download_view_new',$purchase_Data); 
                }
            break;
            case 3: //ppv
                if($isProductAuction=="t" || $purchaseData->entityId=="54"){
                    $this->load->view('sales_purchase_view/auction_product_purcahsed_view_new',$purchase_Data); 
                }else{
                   $this->load->view('sales_purchase_view/purchase_ppv_view_new',$purchase_Data); 
                }
            break;
            case 4: //donate
                $this->load->view('sales_purchase_view/purchase_donation_view_new',$purchase_Data); 
            break;
            case 5: //tickets
                $this->load->view('sales_purchase_view/purchase_ticket_view_new',$purchase_Data); 
            break;
            
            case 6: //auction
                $this->load->view('sales_purchase_view/purchase_auction_view_new',$purchase_Data); 
                $formId++;
            break;
        }

        ?>

        <!--div end-->

        <?php } if(isset($countTotal) && isset($items_per_page) &&  $countTotal > $items_per_page) {?>

    <div class="clear"></div>

    <div class="pt15 row ml28 mt7 mr15">
        
            <?php //$this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/cart/purchase_view/'),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
    </div>

    <?php  } }  else { ?> 

            <div class="tac mt10 pt10 pb10 f16 orange_color"> <!--No Records--></div>

    <?php } ?>

