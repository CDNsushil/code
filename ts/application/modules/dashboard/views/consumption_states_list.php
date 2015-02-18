<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$stateIds=false;
if(isset($ConsumptionTax) && $ConsumptionTax && is_array($ConsumptionTax) && count($ConsumptionTax) > 0) {
	foreach($ConsumptionTax as $key=>$tax) {
		if($tax['stateId'] > 0){
			$stateIds[]=$tax['stateId'];
		}
	}
}

if(isset($statesList) && $statesList && is_array($statesList) && count($statesList) > 0) {
	$allChecked='';
	if($stateIds && is_array($stateIds) && count($stateIds) > 0) {
		if(count($stateIds)==count($statesList)) {
			$allChecked='checked';
		}
	}
	?>
	<div class=" slect_menu bdr_c4c4c4 width_223 shadow_light  height_30 ">
		<label class=" pt6 pl10 all_click">
			<div class="ez-checkbox">
				<input <?php echo $allChecked;?> type="checkbox"  value="1" id="checkAllStates" name="checkAllStates" onclick="checkUncheck(this, 0, '.checkboxStates'); createStateWiseTaxForm('.checkboxStates');" >
			</div>
			All 
		</label>
		<span onclick="slideMenu('#slider5');" class="fr r_arrow"></span>	
	</div>
	
	<div class="seprator_8"></div>
	<div id="slider5" class="slider small_select shadow_light bdr_c4c4c4 mt8 ">
		<a href="#" class="buttons prev disable "></a>
		<div class="viewport scroll_saller height85 width_223 mb20 mt10 ">
		<ul class="overview clearb slect_menu width_196 pl10 pr10 fl ">
			<?php
			foreach($statesList as $k=>$state){
				if($stateIds && is_array($stateIds) && count($stateIds) > 0 && in_array($k,$stateIds)){
					$checked='checked';
				}else{
					$checked='';
				}
				?>
				<li class="">
					<label>
						<div class="ez-checkbox">
							<input <?php echo $checked;?> type="checkbox" id="checkboxStates<?php echo $k ;?>" class="checkboxStates" value="<?php echo $k ;?>" stateName="<?php echo $state;?>" name="states[]" onclick="checkUncheckParent('.checkboxStates','#checkAllStates');" >
						</div>
						<span> <?php echo $state;?> </span> 
					</label>
				</li>
				<?php
			}?>
		</ul>
		</div>
		<a class="buttons next " href="#"></a>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			runTimeCheckBox();
			 $('#slider5').tinycarousel({ axis: 'y', display: 1});
		});
	</script>
	<?php
}else{ ?>
	<div class="bdr_c4c4c4 bg_white bdr_Radius_2">
		<label class="ml10 mt4 cell font_opensansSBold"><?php echo $this->lang->line('noStateFound');?></label>
		<div class="clear"></div>
	</div>
	<?php
}
