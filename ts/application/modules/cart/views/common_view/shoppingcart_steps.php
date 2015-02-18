<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>

<ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab <?php echo ($shoppingCartStage=="stage1")?'TabbedPanelsTabSelected':''; ?>"><span> Stage 1 <b>Billing Detail</b> </span> </li>
    <li class="TabbedPanelsTab <?php echo ($shoppingCartStage=="stage2")?'TabbedPanelsTabSelected':''; ?> " ><span>Stage 2 <b>Purchase Summary</b> </span> </li>
    <li class="TabbedPanelsTab <?php echo ($shoppingCartStage=="stage3")?'TabbedPanelsTabSelected':''; ?>"><span> Stage 3 <b> Payment</b> </span> </li>
</ul>
