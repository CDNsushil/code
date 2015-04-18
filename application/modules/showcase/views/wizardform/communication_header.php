<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$isBusiness = '';
$tabClass = '';
if(isset($isEnterprise)) {
    $isBusiness = 'Business'; 
    $tabClass = 'sub_tab';
}
// get session value of edit showcase mode
$isShowcaseEdit = $this->session->userdata('isShowcaseEdit');
// set enchor end tag in edit mode
$anchorEnd = '';
$isEditShowcase = false;
if(!empty($isShowcaseEdit)) {
	$isEditShowcase = true;
	$anchorEnd = '</a>';
}
// set base url
$baseUrl = base_url(lang().'/showcase');
?>
<!--  content wrap  start end -->
<ul class="TabbedPanelsTabGroup  sub_tab tab_space0">
    <li class="TabbedPanelsTab <?php echo isset($communication1menu)?$communication1menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/communication">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu1');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($communication2menu)?$communication2menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/addcommicationlinks">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu2');?></span>
		<?php echo $anchorEnd;?>
    </li>
    <li class="TabbedPanelsTab <?php echo isset($communication3menu)?$communication3menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/socialmedialinks">'; } ?>	
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu3');?></span>
		<?php echo $anchorEnd;?>
    </li>
 
  </ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
