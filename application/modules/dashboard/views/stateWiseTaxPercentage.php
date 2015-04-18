<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
	<div id="stateTaxSlider" class="bdr_c4c4c4 bg_white slider bdr_Radius_5 p10">
		<a href="#" class="buttons prev disable"></a>
		<div class="viewport scroll_saller height_120">
			<ul class="fs13 width100_per overview slect_coustom slect_menu defaultP" id="stateWiseTaxUl">
				<?php
				if($territory!=1 &&  isset($ConsumptionTax) && $ConsumptionTax && is_array($ConsumptionTax) && count($ConsumptionTax) > 0){
					foreach($ConsumptionTax as $key=>$tax){
						$euCounties=$tax['stateName'];
						?>
						<li id="StateWiseTaxLI<?php echo $tax['stateId'];?>" class="height_30 StateWiseTaxLI">
							<label >
                                <input checked type="checkbox" value="<?php echo $tax['stateId'];?>" name="StateWise[]" onclick="disbaleEnableRow(this,'<?php echo $tax['stateId'];?>');" >
								<span><?php echo $euCounties;?></span> 
							</label>
							<input type="text" onblur="placeHoderHideShow(this,'General Sales Tax','show')" onclick="placeHoderHideShow(this,'General Sales Tax','hide')" id="StateWiseTaxName<?php echo $tax['stateId'];?>" name="StateWiseTaxName<?php echo $tax['stateId'];?>"  value="<?php echo $tax['taxName'];?>" placeholder="General Sales Tax" class="font_wN mr15 width_175 required">
							<input type="text" onblur="placeHoderHideShow(this,'10.00','show')" onclick="placeHoderHideShow(this,'10.00','hide')" placeholder="10.00" id="StateWiseTaxPercentage<?php echo $tax['stateId'];?>" name="StateWiseTaxPercentage<?php echo $tax['stateId'];?>" class="width100px ptb3 number required" value="<?php echo $tax['taxPercentage'];?>">
							% 

							
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
	
