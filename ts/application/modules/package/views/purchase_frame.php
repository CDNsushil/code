<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="seprator_20"></div>
<?php 
if($purchaseDetails){ 
	$formId= 1;
	foreach($purchaseDetails as  $purchaseData){ 
		$purchase_Data['purchaseData'] = $purchaseData;
		
  		$invoiceType=membershipordertitle($purchaseData->orderType);
		
		?>
		<div class="row ml28 mr28 mt7 bdr_cecece pr">
			<div class="fl SCart_item_purchaseleft">
				<div class="width375px  SCart_item_inner_purchase position_relative pt8 pb5 lineh_20 clr_666 font_opensans">
					<div class="cell shadow_wp strip_absolute_right left129">
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
					
					<div class="row">
						<div class="fl width119px text_alignR">Seller</div>
						<div class="fl ml20 width235px clr_333"><?php echo $this->config->item('website_name'); ?></div>	 
					</div>
					
					<div class="row">
						<div class="fl width119px text_alignR">Date</div>
						<div class="fl ml20 width235px clr_f1592a"><?php echo date("d F Y, H:i",strtotime($purchaseData->createDate)) ?></div>	 
					</div>
					
					<div class="row">
						<div class="fl width119px text_alignR">Type</div>
						<div class="fl ml20 width235px ">
							<?php 
								/*if($purchaseData->type==2){
									$item='Space';
								}elseif($purchaseData->type==3){
									$item='Tool';
                }elseif($purchaseData->type==4){
                    $item='Toadsquare Membership';
								}else{
									$item='Tool';
								}*/
                                
                                
								echo membershipitemtitle($purchaseData->type,$purchaseData->pkgId);
							?>
						</div>	 
					</div>
					<?php
					if(is_numeric($purchaseData->size) && $purchaseData->size > 0){?>
						<div class="row">
							<div class="fl width119px text_alignR">Size</div>
							<div class="fl ml20 width235px clr_f1592a">
								<?php 
									$size=$purchaseData->size;
									$size = $purchaseData->size + getItemSize($purchaseData->memItemId);
									$sizeString=bytestoMB($size,'mb').'&nbsp;'.$this->lang->line('mb');
									echo $sizeString;
								?>
							</div>	 
						</div>
						<?php
					}?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="fr height_89 pt2 pb5 ml-24 position_relative pr5 lineH22 font_size13" style="width: 337px;">
				<div class="row clr_f1592a">
					<div class="fl width_313 ml20 tar">
          
          <?php 
							if($purchaseData->type > 3){
                    $item='Toadsquare Membership';
								}else{
									$item='Tool';
								}
								echo $item;
							?>
          
          </div>
					<div class="clear"></div>
				</div>
				<div class="row price_trans_wp clr_444">
					<div class="fl width_313 ml20">
					<?php echo $purchaseData->title; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="pa" style="bottom:5px; right:0px;">
				<div class="cartbtn_pur ml10 mt6 fr"> <a class="hoverOrange" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)" href="<?php echo base_url(lang().'/membershipcart/membershipInvoice').'/'.$purchaseData->orderId; ?>" target="_blank"><span><?php echo $invoiceType;?></span></a> </div>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}
	if($countTotal > 10) {?>
		<div class="clear"></div>
		<div class="pt15 row ml28 mt7 mr15">
		<?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/package/purchases/'),"divId"=>"showInbox","formId"=>"","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
		</div><?php  
	} 
}
else { ?> 
	<div class="tac mt10 pt10 pb10 f16 orange_color"> <!--No Records--></div>
	<?php 
} ?>
<div class="clear"></div>
<div class="seprator_25"></div>


	<!------record export ----->
			
	<?php if($items_total > 0) { ?>
	<div class="fr mr30">
		<label class="fl mt15">Export to</label>
		  <div class="cell join_frm_element_wrapper confirmselect selectbox_small mr30 pl12">
		  <select style="width:80px;" >
			<option selected="selected">CSV</option>
		  </select>
	</div>
	
	<div class="fr mt15">
		<a href="<?php echo base_url('package/purchasedexporttocsv'); ?>"> <img src="<?php echo base_url('templates/default'); ?>/images/export.png"></a>
	</div>

	</div>
	
	<div class="clear"></div>
  
	<div class="seprator_10"></div>
	<?php } ?>
