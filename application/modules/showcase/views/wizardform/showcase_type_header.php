<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
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
<ul class="TabbedPanelsTabGroup sub_tab">
    <li class="TabbedPanelsTab <?php echo isset($showcaseType1menu)?$showcaseType1menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/showcasetype">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1ShowcaseType');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($showcaseType2menu)?$showcaseType2menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/showcaselanguage">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2ShowcaseType');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <?php //if(isset($isEnterprise)) { ?>
    <li class="TabbedPanelsTab <?php echo isset($showcaseType3menu)?$showcaseType3menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/creativeindustry">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3ShowcaseType');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <?php //} ?>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
