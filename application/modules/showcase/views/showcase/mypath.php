<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$creativeFocus = (isset($creativeFocus) && !empty($creativeFocus))? nl2br($creativeFocus):false;
$creativePath = (isset($creativePath) && !empty($creativePath))? nl2br($creativePath):false;
echo '<div class="cnt_abtme width605 fs15 alllink display_cell  verti_top pl41">';
    if($creativeFocus){
        ?> 
        <div class="open_conbold lineH22 pb3 pr50 fs21">My Creative or Work Focus </div>
        <div class="sap_20"></div>
        <div class="lineH20 letter_Spoint2"><?php echo $creativeFocus;?></div>
        <div class="sap_60"></div>
        <?php
    }if($creativePath){?>
        <div class="open_conbold lineH22 pb3 pr50 fs21">My Development Path </div>
        <div class="sap_20"></div>
        <div class="lineH20 letter_Spoint2"><?php echo $creativePath;?></div>
        <?php
    }
echo '</div>';
?>
