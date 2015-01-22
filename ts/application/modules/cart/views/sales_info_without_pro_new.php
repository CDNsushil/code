<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row ">
    <?php 
        if(count($get_sales_information) > 0)
        {
    ?>
                                 
     <div class="bdra7a7a7 fl dis_inliB  sale_cnt red">
        <div class="width_114  th_head text_alighL">Period</div>
        <div class="width355  th_head text_alighL pl30">Product</div>
        <div class="width82  th_head "> Quantity</div>
        <div class="width90 th_head "> Price</div>
        <div class="width100 th_head ">Commision</div>
        <div class="width77 th_head ">Tax</div>
     </div>
     <div class="sap_15"></div>
     <div class="data_list">
        
        <?php 
                $chkBorderCount =   count($get_sales_information);
                $k              =   0;
                $countItem      =   0;
                foreach($get_sales_information as $getSalesInformation)  
                {
            ?>
                <div class="row date_div  <?php echo ($chkBorderCount==$k || $k==0)?"":"dash_bt"; ?>">
            <?php

                if($getSalesInformation['get_num_rows'] > 0 )
                {
                $i=0;	
                foreach($getSalesInformation['get_result'] as $salesInformation)	
                    {

                    $elementId          =   $salesInformation->elementId;
                    $entityId           =   $salesInformation->entityId;
                    
                    $tsCommissionValue  =   (!empty($salesInformation->tsCommissionValue))?$salesInformation->tsCommissionValue:0;
                    $basePrice          =   (!empty($salesInformation->basePrice))?$salesInformation->basePrice:0;
                    $taxValue           =   (!empty($salesInformation->taxValue))?$salesInformation->taxValue:0;
                    $ordCurrency        =   $salesInformation->ordCurrency;
                    $ordCurrency        =   (!empty($ordCurrency) && $ordCurrency>0)?$ordCurrency:0;
                    $currencySign       =   $this->config->item('currency'.$ordCurrency);
                    
                    $craveCount         =   0;
                    $ratingAvg          =   0;
                    $LogSummarywhere    =   array(
                        'entityId'      =>  $entityId,
                        'elementId'     =>  $elementId
                    );

            ?>
                        <div class=" fl dis_inliB fs13  sale_cnt ">
                          <div class="width_114 th_head red text_alighL">
                            <?php

                            switch($show_by)
                            {
                                case "day":	
                                echo ($i==0)?date("d F Y",strtotime($getSalesInformation['showDate'])):"&nbsp;"; 
                                break;
                                case "month":	
                                echo ($i==0)?date("F Y",strtotime($getSalesInformation['showDate'])):"&nbsp;"; 
                                break;
                                case "year":	
                                echo ($i==0)?date("Y",strtotime($getSalesInformation['showDate'])):"&nbsp;"; 
                                break;
                            } 
                             ?>
                                     </div>
                          <div class="width355  th_head text_alighL pl23 pr5"><?php echo $salesInformation->itemName ?> </div>
                          <div class="width82 qty  th_head "><?php echo $salesInformation->count; $countItem =  $countItem + $salesInformation->count;  ?></div>
                          <div class="width90 price_sale th_head "><?php echo (!empty($basePrice))?$currencySign.' '.$basePrice:$basePrice; ?></div>
                          <div class="width100  cosump th_head "><?php echo (!empty($tsCommissionValue))?$currencySign.' '.$tsCommissionValue:$tsCommissionValue; ?></div>
                          <div class="width77 th_head  tax"><?php echo (!empty($taxValue))?$currencySign.' '.$taxValue:$taxValue; ?></div>
                        </div>
                    
                
                 <?php $i++; } } ?>
                 
                    </div>
                 <?php
                 
                   $k++;  }   ?>
                
				     
   
    </div>
        <?php if(isset($countTotal) && isset($items_per_page) &&  $countTotal > $items_per_page) { ?>
             
            <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/cart/salesinformation/?isPagi=yes&isProjView=no&'.$queryString),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
             
         <?php } ?>
     
    <?php   if(isset($countTotal) && $countTotal > 0){  ?>
         <div class="sap_45"></div>
         <a href="<?php echo base_url().'cart/salesInfoExportToCSV/'.base64_encode($from_date).'/'.base64_encode($to_date); ?>" class="export_ccv color_444 fr fs12"> Export to CSV </a>
         <div class="sap_45"></div>
    <?php } ?>
   <?php } ?>
</div>
