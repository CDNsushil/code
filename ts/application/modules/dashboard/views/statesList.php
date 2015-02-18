<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$stateIds=false;
if(isset($ConsumptionTax) && $ConsumptionTax && is_array($ConsumptionTax) && count($ConsumptionTax) > 0){
	foreach($ConsumptionTax as $key=>$tax){
		if($tax['stateId'] > 0){
			$stateIds[]=$tax['stateId'];
		}
	}
}

if(isset($statesList) && $statesList && is_array($statesList) && count($statesList) > 0){
	$allChecked='';
	if($stateIds && is_array($stateIds) && count($stateIds) > 0){
		if(count($stateIds)==count($statesList)){
			$allChecked='checked';
		}
	}
	?>
	<div class="bdr_c4c4c4 bg_white bdr_Radius_2">
		<div class="defaultP ml10 pt5 pb1">
			<input <?php echo $allChecked;?> type="checkbox"  value="1" id="checkAllStates" name="checkAllStates" onclick="checkUncheck(this, 0, '.checkboxStates'); createStateWiseTaxForm('.checkboxStates');" >
		</div>
		<label class="ml20 mt4 fl cell font_opensansSBold">All</label>
		<div class="clear"></div>
	</div>
	<div class="seprator_8"></div>
	<div id="stateSlider" class="bdr_c4c4c4 bg_white slider bdr_Radius_2">
		<a href="#" class="buttons prev disable"></a>
		<div class="viewport scroll_saller ">
		<ul class="overview">
			<?php
			foreach($statesList as $k=>$state){
				if($stateIds && is_array($stateIds) && count($stateIds) > 0 && in_array($k,$stateIds)){
					$checked='checked';
				}else{
					$checked='';
				}
				?>
				<li class="height_30">
					<div class="defaultP ml5 pt5 pb1">
					<input <?php echo $checked;?> type="checkbox" id="checkboxStates<?php echo $k ;?>" class="checkboxStates" value="<?php echo $k ;?>" stateName="<?php echo $state;?>" name="states[]" onclick="checkUncheckParent('.checkboxStates','#checkAllStates'); createStateWiseTaxForm('#checkboxStates<?php echo $k ;?>'); " >
					</div>
					<label class="pl20 mt4 cell font_opensansSBold width_142 bdrB_e2e2e2 pb6 oh lH20 height_18"><?php echo $state;?></label>
					<div class="clear"></div>
				</li><?php
			}?>
		</ul>
		</div>
		<a class="buttons next" href="#"></a>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			runTimeCheckBox();
			if($('#stateSlider')){
				$('#stateSlider').tinycarousel({ axis: 'y', display: 3, start:1});	
			}
		});
	</script>
	<?php
}else{ ?>
	<div class="bdr_c4c4c4 bg_white bdr_Radius_2">
		<label class="ml10 mt4 cell font_opensansSBold">No State, Province or Region found</label>
		<div class="clear"></div>
	</div>
	<?php
}
