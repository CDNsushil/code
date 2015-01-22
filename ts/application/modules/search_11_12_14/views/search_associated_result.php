<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$searchResultCount=count($searchResult);
if($searchResult && is_array($searchResult) && $searchResultCount > 0){
    $formAttributes = array(
        'name'=>'selectAssociatedForm',
        'id'=>'selectAssociatedForm',
    );
    
    $sectionIdInput = array(
        'name'	=> 'sectionId',
        'type'	=> 'hidden',
        'id'	=> 'sectionID',
        'value'	=> isset($sectionId)?$sectionId:0
    );
    
    $SectionInput = array(
        'name'	=> 'section',
        'type'	=> 'hidden',
        'id'	=> 'Section',
        'value'	=> isset($section)?$section:''
    );
    
    $entityidInput = array(
        'name'	=> 'entityid',
        'type'	=> 'hidden',
        'id'	=> 'entityid',
        'value'	=> '0'
    );
    $elementidInput = array(
        'name'	=> 'elementid',
        'type'	=> 'hidden',
        'id'	=> 'elementid',
        'value'	=> '0'
    );
    $projectidInput = array(
        'name'	=> 'projectid',
        'type'	=> 'hidden',
        'id'	=> 'projectid',
        'value'	=> '0'
    );?>
    <?php echo form_open($this->uri->uri_string(),$selectAssociatedForm);
        echo form_input($sectionIdInput);
        echo form_input($SectionInput);
        echo form_input($entityidInput);
        echo form_input($elementidInput);
        echo form_input($projectidInput);?>
       <div  class="height656 content_3 content overflow_hidden defaultP float_none  pt_34 mCustomScrollbar _mCS_1">
           <?php
           foreach($searchResult as $k=>$search){
                if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
                    continue;
                }
                $elementid = $search->elementid;
                $entityid = $search->entityid;
                $projectid = $search->projectid;
                $section = $search->section;
                $createrid = $search->userid;
                $title = str_replace(array('"',"'"), array('&quot;',"&apos;"),$search->title);
                
                $userInfo =showCaseUserDetails($search->userid);
                
                
                if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
                    $search->creative_name= $userInfo['enterpriseName'];
                }
                $projectImagePath = getProjectImage($entityid,$elementid,$projectid,$search->section);
                $prosectionId = (isset($prosectionId) && $prosectionId > 0) ? $prosectionId:0;
                if(isset($prosectionId) && $fromSection != 'abuseReport'){ 
                    $ratingAvg=roundRatingValue($search->ratingAvg);
                    $ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
                    ?>
                    <div class="section">
                        <div class="fl defaultP">
                            <input type="radio"  name="associatedElementId" value="<?php echo $elementid;?>"  onclick="recordSelected('<?php echo $entityid;?>','<?php echo $elementid;?>','<?php echo $projectid;?>');"; >
                        </div>
                        <div class="wrap_list fl fs13">
                            <div class="display_table fl search_title_img">
                                <div class="table_cell"> 
                                    <img src="<?php echo $projectImagePath;?>" alt="" />
                                </div>
                            </div>
                            <div class="head_list fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                                <p class="fl mt3"><?php echo string_decode($search->title); ?></p>
                                <span class="fr text_alignR ">
                                    <p class="red"><?php echo $search->industry; ?></p>
                                    <?php echo $search->country; ?>
                                </span>
                            </div>
                            <div class="head_list fr pl15 width_478">
                                <p class="fl"><?php echo $search->creative_name; ?></p>
                                <div class="fr wrap_s color_666">
                                    <div class="icon_view3_blog icon_so"><?php echo $search->viewCount>0?$search->viewCount:0;?></div>
                                    <div class="icon_crave4_blog icon_so"><?php echo $search->craveCount>0?$search->craveCount:0;?></div>
                                        <div class="rating fl pt6">
                                            <img  src="<?php echo base_url($ratingImg);?>" />
                                        </div>
                                    <div class="btn_share_icon"><?php echo $search->reviewCount>0?$search->reviewCount:0;?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP
                }
            }
            
            ?>
        </div>
    <?php echo form_close(); 
    if($items_total >  $perPageRecord){ ?>
        <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchresult/0/search_news_reviews_result/'.$prosectionId.''),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>  
        <div class="seprator_10 clear"></div>
    <?php } ?>
    <div class="submint_btn mt25 mr15 fr">
        <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="AddAdditionalInfo();">Add</button>
        <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
    </div>  
    <script>
       runTimeCheckBox();
        function recordSelected(entityid,elementid,projectid){
            $('#entityid').val(entityid);
            $('#elementid').val(elementid);
            $('#projectid').val(projectid);
        }
        function AddAdditionalInfo(){
            var Section = $('#Section').val();
            var elementid = $('#elementid').val();
            if(elementid != 0) {
                if(Section == 'PRmaterial'){
                    if($('#associatedElementId').val() != undefined){
                        $('#associatedElementId').val(elementid);
                    }
                    $('#popup_box').parent().trigger('close');
                    postFormGetHTML("#PRfrom","#PRmaterialListing",1);
                   
                    $("#PRfrom")[0].reset();
                    $("#wordsLimit").html(0);
                    $("#resetFormButton").hide();
                    $("input#PRid").val(0);
                    $("input#externalUrl").focus();
                }
            }else{
              alert('Please select an item');  
            }
        }
    </script>
    <?php
}
else{
    echo '<div class="pt15">';
    $this->load->view('common/no_search_found');
    echo '</div>';
}

?>
<script>
    $(document).ready(function() {
        $(".content_3").mCustomScrollbar({
            scrollInertia:600,
            autoDraggerLength:false
        });
    });
</script>
