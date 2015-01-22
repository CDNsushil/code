<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php /*echo "<pre>";print_r($shippingZones); die;*/ ?>

  <div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
  <div class="popup_gredient ">
	<div class="row p15 width_333">
	  <div class="popup_heading_small"><?php echo $this->lang->line('shippingCharges');?></div>
	  <div class="seprator_15"></div>
	  <div class="row">
		<?php 
			//echo form_input($SpId);
			$zoneFlag=false;
			
			if($shippingZones){
				$countSP=count($shippingZones); ?>
				<div class="row">
					<div class="cell mt20">
					  <?php
					  $zoneCountries=array();
					  $l=0;
					  foreach($shippingZones as $k=>$zone){
						  if($zone['spId']>0 && $zone['status']=='t'){
							
							$zoneFlag=true;
							$continentCountries[$zone['zoneId']]=$zone['countriesId'];
							$shortDesc=str_replace("'","&apos;",$zone['shortDesc']);
							$shortDesc=str_replace('"',"&quot;",$zone['shortDesc']);
							$checked='';
							if($l == 0){
								$firstShortDesc=$shortDesc;
								$checked='checked';
								
							}
							$l=($l+1);
							?>
						   <div class="row">
							<div class="defaultP">
							  <input <?php echo $checked;?> type="radio" name="zoneId"  value="<?php echo $zone['zoneId'];?>" onclick="showCurrentHideEach('#countryListing<?php echo $zone['zoneId'];?>','.countryListing'); $('#sippingSD').html('<?php echo $shortDesc;?>')" />
							</div>
							<div class="cell ml10 mr10 width60px">
								<!--<b class="orange_color"><?php echo $zone['title'];?></b>-->
								<?php echo $zone['title'];?>
							</div>
							<div class="SP_popup_input_bg width_40 cell">
							  <input readonly type="text" name="" value="<?php echo $this->lang->line('EURO').number_format($zone['amount'],2);?>">
							</div>
							<div class="seprator_5 clear"></div>
						  </div>
							<?php
						}
					  }?>
					</div>
					<?php
					if($zoneFlag){?>
						<div class="cell ml18">
						  <div class="SP_select_country_box">
							<?php
								$i=0;
								foreach($continentCountries as $zoneId=>$countriesId){
									$Countries=zoneCountries($countriesId);
									$Countries = explode(',',$Countries);
									$dn=$i==0?'':'dn';?>
									 <div class="mr14 ml16 <?php echo $dn?> countryListing" id="countryListing<?php echo $zoneId;?>">
										<?php
											foreach($Countries as $countryName){ ?>
												 <div class="mt11"><?php echo $countryName;?></div>
												 <?php
											}
										?>
										<div class="mt11"></div>
									 </div>
									<?php
									$i++;
								}?>
							
						   </div>
						</div>
						<?php
					}
					
					?>
					</div>
				 <div class="clear seprator_10"></div>
				<div  class="row" id="sippingSD" >
					<?php if(isset($firstShortDesc)) echo $firstShortDesc; ?> 
				</div>
				<?
			}
			if(!$zoneFlag){?>
				<div class="cell pro_title"><?php echo $this->lang->line('noRecord'); ?></div><?php
			}?>
	  </div>
	  <div class="seprator_10"></div>
	  <div class="clear"></div>
	</div>
  </div>
