<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ?>
	<div class="seprator_25"></div>
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
                   switch($purchaseData->purchaseType)
                   
                    {
						case 1: //shipping
							$this->load->view('sales_purchase_view/purchase_shipped_view',$purchase_Data); 
							$formId++;
						break;
						case 2: //download
							$this->load->view('sales_purchase_view/purchase_download_view',$purchase_Data); 
						break;
						case 3: //ppv
							$this->load->view('sales_purchase_view/purchase_ppv_view',$purchase_Data); 
						break;
						case 4: //donate
							$this->load->view('sales_purchase_view/purchase_donation_view',$purchase_Data); 
						break;
						case 5: //tickets
							$this->load->view('sales_purchase_view/purchase_ticket_view',$purchase_Data); 
						break;
					}
                   
                    ?>
					
					<!--div end-->
					
                   <?php } if(isset($countTotal) && isset($items_per_page) &&  $countTotal > $items_per_page) {?>
                   
					<div class="clear"></div>
					
					<div class="pt15 row ml28 mt7 mr15">
						
					        <?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/cart/purchase_view/'),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
					</div>

					<?php  } }  else { ?> 
                   
							<div class="tac mt10 pt10 pb10 f16 orange_color"> <!--No Records--></div>
                    
                  <?php } ?>
                   

                    <div class="clear"></div>
                    <div class="seprator_25"></div>
