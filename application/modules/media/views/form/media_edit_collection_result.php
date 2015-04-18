<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes =   array(
    'name' =>  'editCollectionForm',
    'id'   =>  'editCollectionForm'
);
// set base url
$baseUrl = formBaseUrl();
$isPublicise = '';
if(isset($isPubliciseSection) && !empty($isPubliciseSection)) {
    $isPublicise = $isPubliciseSection;
}

echo form_open($baseUrl.'/editproject/',$formAttributes); ?>
    <ul class="edit_select_video defaultP">
        <?php if(!empty($projList) && count($projList)>0) {
           
            $i=0;
            foreach($projList as $projData) {
            // set project cover image
            $getProjectCoverImage = getProjectCoverImage($projData->projId);
            // set price
            $price = '';
            if($projData->hasDownloadableFileOnly == 1 && $projData->sellPriceType != 3) {
                $price = $projData->projDownloadPrice;
            } else if($projData->hasDownloadableFileOnly == 0 && $projData->sellPriceType == 1) {
                $price = $projData->projPrice;
            }
            ?>
            <li class="video_block">
                <div class="table_cell">
                     <img alt="" src="<?php echo $getProjectCoverImage;?>">
                    <div class="thum_text">
                        <div class="rate_wrap">
                            <input type="radio" id="projectId" class="check_img ez-hide" name="projectId" value="<?php echo $projData->projId;?>">
                            <div class="font_bold title_edit text_alighL fl "> <?php echo getSubString(html_entity_decode($projData->projName),25);?></div>
                            <?php if(!empty($price)) {
                                echo ' <div class="edit_price pt5 clearb pl30"> '.$this->lang->line('mediaFileName').' <b>€ '.$price.'</b></div>';
                            }?>
                        </div>
                    </div>
                </div>
            </li>
           
        <?php 
        $i++;
        }  }?>
    </ul>
<?php echo form_close();?>
<div class="mediaPagination">
	<?php
	if($items_total >  $perPageRecord) { 
		$this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/getmediacollectionresult/0/'.$indusrty.'/'.$isPublicise),"divId"=>"searchMediaResultDiv","formId"=>"editCollectionForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); 
	}
	?>  
</div>
<script type="text/javascript">
	radioCheckboxRender(); 
</script>


