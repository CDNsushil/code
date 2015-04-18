<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set base url
$baseUrl = formBaseUrl();   
$pt10 = '';
// get session value of edit media mode
$isEditMedia = $this->session->userdata('isEditMedia');
$editCls = '';
if(!empty($isEditMedia)) {
	$pt10 = 'pt10';
	$isEditMedia = true;
	$anchorEnd = '</a>';
	$editCls = 'editWizardTab';
}



?>
<div class="TabbedPanelsContent Album_Cover TabbedPanelsContentVisible">
   <div class="step_border2 border_wrap"> </div>
   <div id="TabbedPanels4" class="TabbedPanels tab_setting <?php echo $pt10.' '.$editCls;?>">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab <?php echo isset($coverPageS1Menu)?$coverPageS1Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/selectcoverimage/'.$projectId.'">'; } ?>
					<span>Step 1 <b> Select Image* </b> </span>
				 <?php echo $anchorEnd;?>	
            </li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS2Menu)?$coverPageS2Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/selecttitlendesc/'.$projectId.'">'; } ?>
					<span>Step 2 <b>Title &amp; Description* </b></span>
				<?php echo $anchorEnd;?>
            </li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS3Menu)?$coverPageS3Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/selectcollectioninfo/'.$projectId.'">'; } ?>
					<span>Step 3 <b><?php echo $this->lang->line('collectionInfomation_'.$projCategory); ?> </b></span>
				 <?php echo $anchorEnd;?>
             </li>
            <li class="TabbedPanelsTab <?php echo isset($coverPageS4Menu)?$coverPageS4Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/selectcreativeteam/'.$projectId.'">'; } ?>
					<span>Step 4 <b>Creative Team</b></span>
				 <?php echo $anchorEnd;?>
             </li>
			<li class="TabbedPanelsTab <?php echo isset($coverPageS5Menu)?$coverPageS5Menu:'';?>" >
				<?php if($isEditMedia == true) { echo '<a href="'.$baseUrl.'/selectassociatedmedia/'.$projectId.'">'; } ?>
					<span>Step 5 <b>Associated Media</b></span> 
				<?php echo $anchorEnd;?>
            </li>
        </ul>

        <div class="TabbedPanelsContentGroup  m_auto clearb">
            <?php $this->load->view($subInnerPage); ?>
        </div>
    </div>
</div>
