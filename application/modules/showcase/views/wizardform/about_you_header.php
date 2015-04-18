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
<ul class="TabbedPanelsTabGroup sub_tab tab_space0 tab_sap5  <?php //echo  $tabClass;?>">
    <li class="TabbedPanelsTab <?php echo isset($aboutYou1menu)?$aboutYou1menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/aboutyou">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1AboutYou'.$isBusiness);?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou2menu)?$aboutYou2menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/showcasedetails">'; } ?>	
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2AboutYou'.$isBusiness);?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou3menu)?$aboutYou3menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/aboutsection">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3AboutYou'.$isBusiness);?></span>
		<?php echo $anchorEnd;?>
	</li>
    <?php if(!isset($isFans)) { ?>
        <li class="TabbedPanelsTab <?php echo isset($aboutYou4menu)?$aboutYou4menu:'';?>" >
			<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/developmentpath">'; } ?>
				<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4AboutYou'.$isBusiness);?></span>
			<?php echo $anchorEnd;?>
		</li>
    <?php } ?>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou5menu)?$aboutYou5menu:'';?>" >
		<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/otherlanguage">'; } ?>
			<span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5AboutYou'.$isBusiness);?></span>
		<?php echo $anchorEnd;?>
	</li>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
