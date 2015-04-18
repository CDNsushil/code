<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl();
// get session value of edit media mode
$isEditMedia = $this->session->userdata('isEditMedia');
// set enchor end tag in edit mode
$anchorEnd = '';
if(!empty($isEditMedia) && isset($projectId)) {
	$isEditMedia = true;
	$anchorEnd = '</a>';
}
?>
<ul class="TabbedPanelsTabGroup">
	<li class="TabbedPanelsTab <?php echo isset($s2menuCurrency)?$s2menuCurrency:'';?>" > 
		<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/setupsales/'.$projectId.'">'; } ?>
			<span><b>A</b> Set Currency*</span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($s2menuPF)?$s2menuPF:'';?>" >
		<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/setpriceformat/'.$projectId.'">'; } ?>
			<span><b>B</b>  Set Price Format*</span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($s2menuIT)?$s2menuIT:'';?>" >
		<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/inventorytype/'.$projectId.'">'; } ?>
			<span><b>C</b> Type of Inventory*</span>
		<?php echo $anchorEnd;?>
	</li>
	<?php 
    if(isset($projSellType) && $projSellType !=2){?>
		<li class="TabbedPanelsTab <?php echo isset($s2menuSP)?$s2menuSP:'';?>" >
			<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/setuppricing/'.$projectId.'">'; } ?>
				<span><b>D</b> Setup Pricing*</span>
			<?php echo $anchorEnd;?>
		</li>
        <?php 
    }?>
</ul>
              
		
