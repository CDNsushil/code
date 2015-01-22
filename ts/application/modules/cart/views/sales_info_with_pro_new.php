<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row ">
    <?php
        if($get_sales_information['get_num_rows'] > 0){
    ?>
    
    <div class="bdra7a7a7 fl dis_inliB  sale_cnt red">
        <div class="width485  th_head text_alighL pl30">Product</div>
        <div class="width82  th_head "> Quantity</div>
        <div class="width90 th_head "> Price</div>
        <div class="width100 th_head ">Commision</div>
        <div class="width77 th_head ">Tax</div>
    </div>
    <div class="sap_15"></div>
     
     <div class="data_list">
        <?php 
            $chkBorderCount = $get_sales_information['get_num_rows'];
           // $chkBorderCount = $chkBorderCount-1;
            $k=0;
            $countItem=0;
            
            foreach($get_sales_information['get_result'] as $getSalesInformation)  
                {
        ?>
        <div class="row date_div <?php echo ($chkBorderCount==$k || $k==0)?"":"dash_bt"; ?>">
        <?php

        /*************get view and crave count************/

        $elementId = $getSalesInformation->projId;
        $entityId = $getSalesInformation->entityId;
      

        if($getSalesInformation->isProjBlank=="no")
        {	
        ?>
            
            
                    <div class=" fl dis_inliB fs13  sale_cnt ">
                      <div class="width485  th_head text_alighL pl23 pr5"><?php echo ($getSalesInformation->projItemName!="")?$getSalesInformation->projItemName:"&nbsp;" ?> ( <?php echo  $getSalesInformation->projType; ?>  )  </div>
                      <div class="width82 qty  th_head "><?php echo $getSalesInformation->count; ?></div>
                      <div class="width90 price_sale th_head ">
                    <?php 
                            $getPriceArray =    getSalesPriceByProjectId($getSalesInformation->projId);
                            $currencySign  =    '';
                            if($getPriceArray){
                                $currencySign       = getCurrencyByProjectId($getSalesInformation->projId);
                                $baseprice          = $getPriceArray['baseprice'];
                                $taxvalue           = $getPriceArray['taxvalue'];
                                $tsCommissionValue  = $getPriceArray['tsCommissionValue'];
                            }
                            
                            echo (!empty($baseprice))?$currencySign.' '.$baseprice:$baseprice;
                     ?>
                    </div>
                      <div class="width100  cosump th_head "><?php echo (!empty($tsCommissionValue))?$currencySign.' '.$tsCommissionValue:0; ?></div>
                      <div class="width77 th_head  tax"><?php echo (!empty($taxvalue))?$currencySign.' '.$taxvalue:0; ?></div>
                   </div>
                   
        <?php } ?>
                
                <?php
         if(count($getSalesInformation->projElement) > 0){
                    
                    foreach($getSalesInformation->projElement as $getprojElement)
                    {
                        /*************get view and crave count************/
                        
                        $elementId = $getSalesInformation->projId;
                        $entityId = $getSalesInformation->entityId;
                   
                    ?>
                                
                   <div class=" fl dis_inliB fs13  sale_cnt ">
                      <div class="width485  th_head text_alighL pl23 pr5"><?php echo ($getprojElement->itemName!="")?$getprojElement->itemName:"&nbsp;" ?> </div>
                      <div class="width82 qty  th_head "><?php echo $getprojElement->count; ?></div>
                      
                        <div class="width90 price_sale th_head ">
                        <?php 
                                $getPriceArray =    getSalesPriceByProjectId($getSalesInformation->projId);
                                $currencySign  =    '';
                                if($getPriceArray){
                                    $currencySign       = getCurrencyByProjectId($getSalesInformation->projId);
                                    $baseprice          = $getPriceArray['baseprice'];
                                    $taxvalue           = $getPriceArray['taxvalue'];
                                    $tsCommissionValue  = $getPriceArray['tsCommissionValue'];
                                }
                                
                                echo (!empty($baseprice))?$currencySign.' '.$baseprice:$baseprice;
                         ?>
                        </div>
                          <div class="width100  cosump th_head "><?php echo (!empty($tsCommissionValue))?$currencySign.' '.$tsCommissionValue:0; ?></div>
                          <div class="width77 th_head  tax"><?php echo (!empty($taxvalue))?$currencySign.' '.$taxvalue:0; ?></div>
                      
                      
                      
                   </div>
                    
                     <?php   } }  ?>
             
                </div>
                
        <?php  $k++;	}  ?>

    </div>
     
     
     <!-- Pagination  -->
     <?php if(isset($countTotal) && isset($items_per_page) &&  $countTotal > $items_per_page) { ?>
            <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/cart/salesinformation/?isPagi=yes&isProjView=yes&'.$queryString),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
     <?php } ?>
     
     
     <?php if(isset($countTotal) && $countTotal > 0)
					{  ?>
     <div class="sap_45"></div>
     <a href="" class="export_ccv color_444 fr fs12"> Export to CSV </a>
     <div class="sap_45"></div>
    
     <?php } ?>
     
    <?php   }  ?>
     
</div>
