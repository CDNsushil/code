<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
//echo "<pre>";
//print_r($upcomingProjects);die;
foreach($upcomingProjects as $upcomingProject) {
	// set default image 
	$defaultImage = $this->config->item('upcomingImage');
	if($upcomingProject['thumbFileId'] > 0) {
		// get image data of media
		$thumbImageData = getMediaDetail($upcomingProject['thumbFileId']);
		$thumbImgPath = (!empty($thumbImageData)) ? $thumbImageData[0]->filePath : '';
		$thumbImgName = (!empty($thumbImageData)) ? $thumbImageData[0]->fileName : '';
		// set image file path
		$filePath = $thumbImgPath.$thumbImgName;
	} else {
		// set image file path
		$filePath = $upcomingProject['filePath'].$upcomingProject['fileName'];
	}
	// get media image
	$smallImg = addThumbFolder($filePath,'_m');										
	$projImg  = getImage($smallImg,$defaultImage);	
	
	// set project url
	$upcomingProjLink = base_url(lang().'/upcomingprojects/donation/'.$upcomingProject['projId']);
	if($section == 'publicise') {
		$upcomingProjLink = base_url(lang().'/upcomingprojects/share/'.$upcomingProject['projId']);
	}
	// set publish link label
	$publishLabel = $this->lang->line('Publish');
	if($upcomingProject['isPublished'] == 't') {
		$publishLabel = $this->lang->line('hide');
	}
?>
<div class="sap_25"></div>
<div id="media_150" class="alt_cntwrap bdrcece ">
	<div class="width106 alt_img table_cell"><img alt="" src="<?php echo $projImg;?>"></div>
	<div class=" table_cell width520 text_alighL">
		<p class="stripv fl mt3 width350 letter_spP7"> 
			<b><?php echo nl2br(getSubString($upcomingProject['projTitle'],50));?></b>
			<br/>
			<?php echo nl2br(getSubString($upcomingProject['proShortDesc'],70));?>
		</p>	
		<span class="red pt30 fr">
		<a href="<?php echo $upcomingProjLink;?>"> Edit</a> / 
		<?php if($isPublished != 2) { ?>
			<a href="<?php echo base_url(lang().'/upcomingprojects/previewpublish/'.$upcomingProject['projId'])?>"> <?php echo $publishLabel;?></a> / 
		<?php } ?>
		<a onclick="deleteShowcase(<?php echo $upcomingProject['projId'];?>)">Delete </a> </span>
	</div>
</div>
<?php } ?>
<?php
if($items_total >  $perPageRecord) { ?>
     <div class="sap_15"></div>
     <div class="sesion_pag">
        <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/upcomingprojects/upcomingeditmediaresult/0/'.$projIndustry.'/'.$isPublished.'/'.$isCompleted.'/'.$section),"divId"=>"searchResultDiv","formId"=>"editCollectionForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
    </div>
<?php } ?>  
