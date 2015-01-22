<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="cart_container position_relative pt8 pb8 pl8 pr8 show_gradiant_inner">
                 	
                    
                    <!------------Record show day wise start ----------->
                    
                <?php
                
                 if($get_sales_information['get_num_rows'] > 0)
					{
						
						$chkBorderCount = $get_sales_information['get_num_rows'];
						$chkBorderCount = $chkBorderCount-1;
						$k=0;
						$countItem=0;
						
						foreach($get_sales_information['get_result'] as $getSalesInformation)  
							{
								
						  ?>
                     <div class="position_relative <?php echo ($chkBorderCount==$k)?"":"bdrB_selldot"; ?>">
                     
                     		        <div class="cell shadow_wp strip_absolute_right left480">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_top.png"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_bottom.png"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    
                                    <div class="cell shadow_wp strip_absolute_right left576">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_top.png"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_bottom.png"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    
                                    <div class="cell shadow_wp strip_absolute_right left672">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_top.png"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_bottom.png"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    
                                    <div class="cell shadow_wp strip_absolute_right left767">
                                      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_top.png"></td>
                                          </tr>
                                          <tr>
                                            <td class="line_mid_extraspace">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="30"><img src="<?php echo base_url('templates/default'); ?>/images/cart_extraspacedivider_bottom.png"></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="clear"></div>
                                    </div>
                                    
                                 <?php if($k==0) { ?>
                                  <div class="bdr_cecece font_arial font_size13 clr_f1592a lineH_32 bg_white">
										<div class="row">
											<div class="fl width468px pl6"><?php echo $this->lang->line('sales_info_item'); ?></div>
											<div class="fl width96 text_alignC"><?php echo $this->lang->line('sales_info_price'); ?></div>
											<div class="fl width96 text_alignC"><?php echo $this->lang->line('sales_info_sales'); ?></div>
											<div class="fl width96 text_alignC"><?php echo $this->lang->line('sales_info_craves'); ?></div>
											<div class="fl width96 text_alignC"><?php echo $this->lang->line('sales_info_views'); ?></div>
									   <div class="clear"></div>
										</div>
									</div>
									
								<?php } ?>	
					 
							<div class="seprator_16"></div>
                  
						<?php
					 
					 	
								
								/*************get view and crave count************/
								
								$elementId = $getSalesInformation->projId;
								$entityId = $getSalesInformation->entityId;
								$craveCount=0;
									$ratingAvg=0;
										$LogSummarywhere=array(
											'entityId'=>$entityId,
											'elementId'=>$elementId
										);
								
								$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
					
									if($resLogSummary)
									{
										$resLogSummary = $resLogSummary[0];											
										$craveCount = $resLogSummary->craveCount;
										$viewCountShow = $resLogSummary->viewCount;
									}else
									{										
										$craveCount=0;
										$viewCountShow=0;
									}
								
								
								
							if($getSalesInformation->isProjBlank=="no")
							{	
							?>
							<div class="row">
								<div class="price_trans_wp_sale font_size12 lineH24 clr_444">
								<div class="fl width468px pl6"><?php echo ($getSalesInformation->projItemName!="")?$getSalesInformation->projItemName:"&nbsp;" ?> ( <?php echo  $getSalesInformation->projType; ?>  ) </div>
								<div class="fl width96 text_alignC font_weight">
									<?php 
										if(getPriceByProjectId($getSalesInformation->projId) > 0)
										{
											echo getCurrencyByProjectId($getSalesInformation->projId);
										}
										echo ' '.getPriceByProjectId($getSalesInformation->projId);
								 ?></div>
									<div class="fl width96 text_alignC font_weight"><?php echo $getSalesInformation->count; ?></div>
									<div class="fl width96 text_alignC"><?php  echo $craveCount; ?></div>
									<div class="fl width96 text_alignC clr_f1592a"> <?php  echo $viewCountShow; ?> </div>
								</div>
								<div class="seprator_3"></div>
							</div>
							<?php } ?>
						<!---------show project element here---------->
						<?php if(count($getSalesInformation->projElement) > 0){
							
							foreach($getSalesInformation->projElement as $getprojElement)
							{
								/*************get view and crave count************/
								
								$elementId = $getSalesInformation->projId;
								$entityId = $getSalesInformation->entityId;
								$craveCount=0;
									$ratingAvg=0;
										$LogSummarywhere=array(
											'entityId'=>$entityId,
											'elementId'=>$elementId
										);
								
								$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
					
									if($resLogSummary)
									{
										$resLogSummary = $resLogSummary[0];											
										$craveCount = $resLogSummary->craveCount;
										$viewCountShow = $resLogSummary->viewCount;
									}else
									{										
										$craveCount=0;
										$viewCountShow=0;
									}
								
								
								?>	
							
							<div class="row">
								<div class="price_trans_wp_sale font_size12 lineH24 clr_444">
									<div class="fl width468px pl6"><?php echo ($getprojElement->itemName!="")?$getprojElement->itemName:"&nbsp;" ?></div>
									<div class="fl width96 text_alignC font_weight"><?php
										if(getPriceByProjectId($getSalesInformation->projId) > 0)
										{
											echo getCurrencyByProjectId($getSalesInformation->projId);
										}
									   echo  ' '.getPriceByProjectId($getSalesInformation->projId); ?></div>
									<div class="fl width96 text_alignC font_weight"><?php echo $getprojElement->count; ?></div>
									<div class="fl width96 text_alignC"><?php  echo $craveCount; ?></div>
									<div class="fl width96 text_alignC clr_f1592a"> <?php  echo $viewCountShow; ?> </div>
								</div>
								<div class="seprator_3"></div>
							</div>
							
						 <?php   } }  ?>
                    
						<div class="seprator_10"></div>
				</div>
                
                <?php  $k++;	}   }  else {   ?>
                 
					<div class="tac mt10 pt10 pb20 f16 orange_color"><!-- No Records --></div>
                 
                 <?php } ?>
                 <!------------Record show day wise end ----------->
                 
                    
                 </div>
                 
                 
                 <?php if(isset($countTotal) && isset($items_per_page) &&  $countTotal > $items_per_page) { ?>
                 
					   <div class="clear"></div>
						
						<div class="pt10 ml20  row mb8 mr5">
							
								<?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/cart/sales_information/?isPagi=yes&isProjView=yes'.$queryString),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
						</div>
						<div class="clear"></div>
					
				<?php } ?>
					
				<div class="seprator_5"></div>
					<!--------------export code ------->
				
				<?php if(isset($countTotal) && $countTotal > 0)
					{  ?>	
					<div class="fr mr18">
            	<label class="fl mt15"><?php echo $this->lang->line('export_to'); ?></label>
                  <div class="cell join_frm_element_wrapper confirmselect selectbox_small mr30 pl12">
                  <select style="width:80px;" >
                    <option selected="selected"><?php echo $this->lang->line('csv'); ?></option>
                  </select>
                </div>
                
                <div class="fr mt15">
                <a href="<?php echo base_url().'cart/salesInfoExportToCSV/'.base64_encode($from_date).'/'.base64_encode($to_date); ?>"> <img src="<?php echo base_url('templates/default'); ?>/images/export.png"></a>
                </div>
            
            </div>
            
            <div class="clear"></div>
          
          <div class="seprator_10"></div>
            
            <?php } ?>
            
          
          
			
