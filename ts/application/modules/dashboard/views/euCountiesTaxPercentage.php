<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if(isset($euCountiesList) && $euCountiesList && is_array($euCountiesList) && count($euCountiesList) > 0){?>
	<div id="stateTaxSlider" class="bdr_c4c4c4 bg_white slider bdr_Radius_5">
		<a href="#" class="buttons prev disable"></a>
		<div class="viewport scroll_saller ">
			<ul class="overview" id="stateWiseTaxUl">
				<?php
				$contiresId[]=0;
				if($territory==1 && isset($ConsumptionTax) && $ConsumptionTax && is_array($ConsumptionTax) && count($ConsumptionTax) > 0){
					foreach($ConsumptionTax as $key=>$tax){
						$contiresId[]=$tax['countryId'];
						$euCounties=$tax['countryName'];?>
						<li id="StateWiseTaxLI<?php echo $tax['countryId'];?>" class="height_30 StateWiseTaxLI">
							<div class="row">
								<div class="cell">
									<div class="defaultP ml10 pt5 pb1">
										<input checked type="checkbox" value="<?php echo $tax['countryId'];?>" name="StateWise[]" onclick="disbaleEnableRow(this,'<?php echo $tax['countryId'];?>');" >
									</div>
								</div>
								<div class="cell">
								<label class="pl20 mt4 cell font_opensansSBold width_142 bdrB_e2e2e2 pb6 oh lH20 height_18"><?php echo $euCounties;?></label>
								</div>
								<div class="cell width210px pt2"><input type="text" id="StateWiseTaxName<?php echo $tax['countryId'];?>" name="StateWiseTaxName<?php echo $tax['countryId'];?>" class="width180px ptb3 required" value="<?php echo $tax['taxName'];?>"></div>
								<div class="cell p -t2"><input type="text" id="StateWiseTaxPercentage<?php echo $tax['countryId'];?>" name="StateWiseTaxPercentage<?php echo $tax['countryId'];?>" class="width100px ptb3 number required" value="<?php echo $tax['taxPercentage'];?>"></div>
								<div class="clear"></div>
							</div>
						</li><?php
					}
				}
				foreach($euCountiesList as $k=>$euCounties){
					if(!in_array($k,$contiresId)){?>
						<!--<li id="StateWiseTaxLI<?php echo $k;?>" class="height_30 StateWiseTaxLI opacity_4">-->
						<li id="StateWiseTaxLI<?php echo $k;?>" class="height_30 StateWiseTaxLI">
							<div class="row">
								<div class="cell">
									<div class="defaultP ml10 pt5 pb1">
										<input checked type="checkbox" value="<?php echo $k;?>" name="StateWise[]" onclick="disbaleEnableRow(this,'<?php echo $k;?>');" >
									</div>
								</div>
								<div class="cell">
								<label class="pl20 mt4 cell font_opensansSBold width_142 bdrB_e2e2e2 pb6 oh lH20 height_18"><?php echo $euCounties;?></label>
								</div>
								<div class="cell width210px pt2"><input type="text" id="StateWiseTaxName<?php echo $k;?>" name="StateWiseTaxName<?php echo $k;?>" class="width180px ptb3"></div>
								<div class="cell p -t2"><input type="text" id="StateWiseTaxPercentage<?php echo $k;?>" name="StateWiseTaxPercentage<?php echo $k;?>" class="width100px ptb3"></div>
								<div class="clear"></div>
							</div>
						</li><?php
					}
				}?>
			</ul>
		</div>
		<a class="buttons next" href="#"></a>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			runTimeCheckBox();
			if($('#stateTaxSlider')){
				$('#stateTaxSlider').tinycarousel({ axis: 'y', display: 4, start:1});	
			}
		});
	</script>
	<?php
}
