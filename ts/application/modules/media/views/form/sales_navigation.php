<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<ul class="TabbedPanelsTabGroup">
	<li class="TabbedPanelsTab <?php echo isset($s2menuCurrency)?$s2menuCurrency:'';?>" > <span><b>A</b> Set Currency*</span></li>
	<li class="TabbedPanelsTab <?php echo isset($s2menuPF)?$s2menuPF:'';?>" ><span><b>B</b>  Set Price Format*</span></li>
	<li class="TabbedPanelsTab <?php echo isset($s2menuIT)?$s2menuIT:'';?>" ><span><b>C</b> Type of Inventory*</span></li>
	<?php 
    if(isset($projSellType) && $projSellType !=2){?>
		<li class="TabbedPanelsTab <?php echo isset($s2menuSP)?$s2menuSP:'';?>" ><span><b>D</b> Setup Pricing*</span></li>
        <?php 
    }?>
</ul>
              
		
