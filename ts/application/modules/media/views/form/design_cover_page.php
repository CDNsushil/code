<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set base url
$baseUrl = formBaseUrl(); 
?>
<div class="TabbedPanelsContent Album_Cover TabbedPanelsContentVisible">
   <div class="step_border2 border_wrap"> </div>
   <div id="TabbedPanels4" class="TabbedPanels tab_setting">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab <?php echo isset($coverPageS1Menu)?$coverPageS1Menu:'';?>" ><span>Step 1 <b> Select Image* </b> </span></li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS2Menu)?$coverPageS2Menu:'';?>" ><span>Step 2 <b>Title &amp; Description* </b></span></li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS3Menu)?$coverPageS3Menu:'';?>" ><span>Step 3 <b>Collection Information* </b></span> </li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS4Menu)?$coverPageS4Menu:'';?>" ><span>Step 4 <b>Creative Team</b></span> </li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS5Menu)?$coverPageS5Menu:'';?>" ><span>Step 5 <b>Associated Media</b></span> </li>
        </ul>

        <div class="TabbedPanelsContentGroup  m_auto clearb">
            <?php $this->load->view($subInnerPage); ?>
        </div>
    </div>
</div>
