<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl(); 
?>
<div class="data_box1 content_3 content overflow_hidden">
    <?php
    $elementCount = 1;
    foreach($elementList as $elementList) {
        // get element image
        $elementImage = getElementImage($elementList->displayImageType,$elementList->imagePath,$indusrty);
        // set title
        $title = (!empty($elementList->title))?$elementList->title:'Untitled';
        // set checked value
        $checked = '';
        if($elementCount == 1) {
            $checked = 'checked';
        }
        ?>
        <!-- ======= box ======== -->
        <div class="fl   sah_box">
            <div class="bdrcece display_table share_box">
                <div class="table_cell radio_wrap ver_b ">
                    <span class="number"><?php echo $elementCount;?></span>
                    <input name="elementId" type="radio" <?php echo $checked;?> value="<?php echo $elementList->elementId?>"  />
                </div>
                <div class="table_cell share_thumb">
                    <img src="<?php echo  $elementImage ;?>"  alt="" />
                </div>
                <div class="display_table  mt4 ">
                    <p class="blc4c4c4 table_cell height38 pl10">
                       <?php echo getSubString(html_entity_decode($title),35);?>
                    </p>
                </div>
            </div>
        </div>
    <?php 
    $elementCount++;
    } ?>
</div>
<?php
if($items_total >  $perPageRecord) { ?>
    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/searchshareelementsresult/0/'.$industry.'/'.$projectId.''),"divId"=>"searchResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
<?php } ?>
<script>
 $(document).ready(function() {
    $(".content_3").mCustomScrollbar({
        scrollInertia:600,
        autoDraggerLength:false
    });
    runTimeCheckBox();
});
</script>
