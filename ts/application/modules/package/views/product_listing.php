<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$formAttributes = array(
'name'=>'packageList',
'id'=>'packageList'
);

$cartId=$this->session->userdata('currentCartId'); 
?>
<div class="row">
  <div class=" cell frm_heading mt3">
	<h1>Membership</h1>
  </div>
  <div class="frm_btn_wrapper">
	<div class="tds-button-big fr mr11">
		<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard'); ?>"><span >Dashboard </span></a>
		<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard/globalsettings'); ?>" ><span>Global Settings</span></a>
	</div>
  </div>
</div>
<div class="row line1 mr14"></div>
<div class="row seprator_5"></div>
<div class="row">
  <div class="main_project_heading">
	<div class="btn_outer_wrapper width_auto pl5 mr14 ml5">
	  <div class="fr">
		<div class="tds-button-big Fleft">
			<a href="<?php echo base_url(lang().'/package/information/'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Information</span></a>
			<a class="a_dash_navactive" href="#" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span class="span_dash_navactive" style="background-position: right 0px;">Buy Tools</span></a>
			<a href="<?php echo base_url(lang().'/package/purchases/'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Purchases</span></a>
			</div>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</div>
<div class="clear"></div>
<div class="row form_wrapper">
  <div class="row position_relative">
	<div class="cart_container_outer_solid ml0 mr0 mt2">
	  <div class="cart_container bg_white pl12">
		   
   <?php echo form_open(base_url_secure(lang().'/membershipcart/buyspaceinfo'),$formAttributes);
			if($packages && is_array($packages) && count($packages) > 0){
				foreach($packages as $key=>$info){
					
					       $productCart=  getSelectedTools($cartId,$info['tsProductId']);
					       
					      // print_r($productCart);
					      // $productCart=  getSelectedTools($cartId,$info['tsProductId']);
					       $productCart=1;
					       if(isset($productCart->count) && ($productCart->count!='') )
					        {
								$checked= "checked";
								$selectedVal = $productCart->count;
								$selected = "class = selectBox-label";
								} else {									
									   $checked="";
								       $selectedVal = '1';									
								       $selected = "class = selectBox-label";
									}
					       
					       
					       
					
					$pkgPrice= ($info['pkgPrice'] > 0)?$info['pkgPrice']:$info['price'];
					$pkgPrice= number_format($pkgPrice,2);
					$duration= ($info['initialValidity'] > 0)?$info['initialValidity']:(($info['pkgValidity'] > 0)?$info['pkgValidity']:$info['duration']);
					$size=bytestoMB($info['size'],'mb');
					$size=number_format($size,0);
					$defaultImage='images/default_thumb/'.$info['defaultImage'];
					$defaultImage=getImage($defaultImage);
					?>
					<div class="cell Members-Buy-Tools_shedow width_367 mt0 pr15 pt12 pb4  Fleft">
					<div class="dash_Atool_list_box  ">
					<div class="dash_Atool_fackleftbox heightAuto left14 height_106 width_82 bdr_white1"></div>
					  <div class="dash_Atool_leftbox heightAuto left14 bdr_white1 mt-1 width_82 bdr_bottom0">
						<div class="height_117">
						  <div class="AI_table">
							<div class="AI_cell"> <img src="<?php echo $defaultImage;?>" alt="Media" class="bdr_white max_w58_h88"> </div>
						  </div>
						</div>
					  </div>
					  <div class="dash_headgrad font_museoSlab font_size20 clr_D45730 pt7 pb8 pl_120"><?php echo $info['title'];?></div>
					  
					  <div class="dash_Atool_text minH44 fl pl_120 pb5 pr2">
						<div class="dash_Atool_space font_opensansSBold  clr_555 border0 width_70 text_alignl pt4 min_heigh40 fl font_size13">
							<div class="font_opensansSBold"><?php echo $size.' '.$this->lang->line('mb');?></div>
						  <div class="seprator_3"></div>
							<div class="font_opensansSBold"><?php if($duration > 0){ echo $duration.' '.$this->lang->line('months');}?> </div>
						  </div>
						  
						  <div class="dash_Atool_space font_opensansSBold  clr_555 border0 width_105 text_alignl pt4 min_heigh40 fl">
							<div class="clr_f1592a font_size13 lineH16 font_opensansSBold"><?php if($pkgPrice > 0){  echo $this->lang->line('EURO').$pkgPrice; } ?> excl. VAT</div>
						  </div>
						  
						   <div class="dash_Atool_space font_opensansSBold  clr_555 border0 width_63 text_alignl pt4 min_heigh40 fl">
							<div class="cell position_relative height4 width_73 mt_minus11 left-18">
									<select style="width: 70px; display: none;" name="select[<?php echo $info['tsProductId'] ?>]" class="main_SELECT productPrice<?php echo $info['pkgRoleId']?>" style="width:70px" productPrice="<?php echo $pkgPrice;?>" productPriceDiv="#productTotalPrice<?php echo $info['pkgRoleId']?>" onchange="calculateTotalPrice(this);">
									  
								<?php 								  
								  for($i=1;$i<=6;$i++){
							            $select='';
										if($i==$selectedVal){ 
											$select = 'selected';
											?>
										 
									   <?php } ?>
									   
									   <option <?php echo $select ?> value='<?php echo $i?>'><?php echo $i?></option>
							
						 <?php	       }   ?>
									  
									</select>
							</div>
						  </div>
						  
					  </div>
						  <div class="clear"> </div>
						  <div class="dash_Atool_footer pl_120 pt0 pb0 minH37">
						  <div class="defaultP mt8">
							<input type="checkbox" <?php echo $checked ?> value="<?php echo $info['tsProductId'] ?>" name="item[<?php echo $info['tsProductId'] ?>]" class="ez-hide productchk">
						  </div>
						   <div class="defaultP mt10 Fright mt10">
							<div class="fl font_size13 width_80 clr_666 font_normal text_alignR font_opensansSBold"> Sub-Total</div>
							<div id="productTotalPrice<?php echo $info['pkgRoleId']?>" class="fl font_size13 width_56 text_alignR clr_666 font_normal font_opensansSBold"> <?php echo $this->lang->line('EURO').$pkgPrice;?></div>
						  </div>
						  </div>
						  
			<?php if($info['tsProductId']==118) { ?>					  
		 <div class="font_opensansSBold font_size11 mt2 Fleft">
			 *You can use this tool for Projects in Film & Video, Music & Audio, Photography & Art, Writing & Publishing and Educational Material.
		</div>
	<?php } ?>			  
						  
						  
						  
					</div>
				  </div>
				  <?php
				}
			}
		 ?>
			
			<div class="clear"> </div>
			<div class="seprator_30"> </div>
			<div class="Shodowverticaldivider mb6"> </div>
		
			<div class="fr mr15"> 
				<div class="tds-button fr mt15">
				<!----<button type="button" href="javascript:void:none" class="comingSoon" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"  value="Save" name="submit" type="submit" id="checkSave"><span><div class="Fleft font_opensansSBold clr_E76D34 font_size14 pr_13 pl13">Buy</div><div class="buy_button"></div></span></button>--->
				 
<button onclick="return checkout();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="checkSave"><span><div class="Fleft font_opensansSBold clr_E76D34 font_size14 pr_13 pl13">Buy</div><div class="buy_button"></div></span></button>
				</div></div>
		<div class="clear"></div>		
	<div class="font_opensansSBold font_size11 mt2 Fleft ">* You can add Extra Space to a Tool in the Cart. It costs EUR 0.80 per 100 MB.  </div>			
	<div class="font_opensansSBold font_size11 mt2 Fleft ">* We will refund the price of a Tool and its Extra Space until you save it.  </div>
	<div class="clear"></div>
	<div class="font_opensansSBold font_size11 mt2 Fleft ">* VAT will be added, if applicable, as you checkout. </div>					
	
	

	
				
				<div class="seprator_55"></div>
			<?php echo form_close(); ?>  
	  </div>
	
	</div>
	<div class="clear"></div>
	<div class="seprator_10"></div>
  </div>
</div>
<div class="clear"></div>
<script>
	function calculateTotalPrice(obj){
		var productPrice = 0;
		var productTotalPrice = 0;
		var sumOfPrice = 0;
		var qty = 0;
		var productPriceDiv = '';
		var sumOfPriceDiv = '';
		productPriceDiv=$(obj).attr("productPriceDiv");
		sumOfPriceDiv= $(obj).attr("sumOfPriceDiv");
		productPrice= $(obj).attr("productPrice");
		productPrice= parseFloat(productPrice);
		qty= $(obj).attr("value");
		qty=parseInt(qty);
		productTotalPrice=(qty*productPrice);
		productTotalPrice=parseFloat(productTotalPrice).toFixed(2);
		$(productPriceDiv).html('<?php echo $this->lang->line('EURO');?> '+productTotalPrice);
	}
	
	
	
function checkout(){	
	 var chktools = checkedCount();
	 	 
	 if(chktools==0){
		customAlert('You must select at least one Tool.'); 
	  return false;
	 }else {  
	     return true;
	   }
 }  
	
	

 // check count on load
 function checkedCount(){	
	var val = [];
	var count=0;		
	$('.productchk:checked').each(function(i){	
		val[i] = 1;		
		count = count + val[i];			
	}); 		
	 return count;	
 }	
	
	
	
	
</script>

