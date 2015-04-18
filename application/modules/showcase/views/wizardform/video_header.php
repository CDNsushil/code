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
    <li class="TabbedPanelsTab <?php echo isset($yourVideo1menu)?$yourVideo1menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/yourvideo">'; } ?>	
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('yourVideo1');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($yourVideo2menu)?$yourVideo2menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/yourvideo/1">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('yourVideo2');?></span>
		<?php echo $anchorEnd;?>
	</li>
  </ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
