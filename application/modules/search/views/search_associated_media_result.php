<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="height656 content_3 content overflow_hidden defaultP float_none  pt_34 mCustomScrollbar _mCS_1" id="searchResult">
    <?php
    $formAttributes = array(
        'name'=>'selectAssociatedForm',
        'id'=>'selectAssociatedForm',
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
    );
    $supportingProjectInput = array(
        'name'	=> 'SupportingProjectName',
        'type'	=> 'hidden',
        'id'	=> 'SupportingProjectName',
        'value'	=> '0'
    );
    $createridInput = array(
        'name'	=> 'createrid',
        'type'	=> 'hidden',
        'id'	=> 'createrid',
        'value'	=> '0'
    );
    
    echo form_open($this->uri->uri_string(),$formAttributes);
        echo form_input($entityidInput);
        echo form_input($elementidInput);
        echo form_input($projectidInput);
        echo form_input($supportingProjectInput);
        echo form_input($createridInput);
    echo form_close();
     
    $searchResultCount=count($searchResult);
    if($searchResult && is_array($searchResult) && $searchResultCount > 0) { 
        foreach($searchResult as $k=>$search) {
            //$search=htmlEntityDecode($search);
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
            if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't') {
                $search->creative_name = $userInfo['enterpriseName'];
            }
            /* get Project Image */
            $projectImagePath = getProjectImage($entityid,$elementid,$projectid,$search->section);
            $prosectionId = (isset($prosectionId) && $prosectionId > 0) ? $prosectionId:0;
           
            if(((!empty($sectionId) &&  $sectionId=='media') || isset($prosectionId)) && $fromSection!='abuseReport') {
                if(isset($elementid) && isset($projectid) && $elementid==$projectid) {
                    $projectType =  $this->lang->line('project');
                } else {
                    if($search->section=="news") {
                        $projectType =  $this->lang->line('article'); // add by lokendra
                    } else {
                        $projectType =  $this->lang->line('piece');
                    }
                }
                $ratingAvg=roundRatingValue($search->ratingAvg);
                $ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
                ?>
                <div class="section">
                    <div class="fl">
                        <input type="radio" id="associatedPE_<?php echo $projectid."_".$elementid; ?>"  name="associatedElementId" value="<?php echo $elementid;?>" rel="<?php echo $elementid;?>" projectid="<?php echo $projectid;?>" entityid="<?php echo $entityid;?>" SupportingProjectName="<?php echo $title;?>" createrid="<?php echo $createrid;?>" onclick="recordSelected(this)" >
                    </div>
                    <div class="wrap_list fl fs13"  >
                       <div class=" display_table list_thumb">
                            <div class="table_cell">
                                <img src="<?php echo $projectImagePath;?>" alt="" />
                            </div>
                        </div>
                        <div class="head_list fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                            <p class="fl mt3">
                                <?php echo $search->creative_name; ?>
                            </p>
                            <span class="fr text_alignR ">
                                <p class="red">
                                   <?php echo $this->lang->line($search->section); ?>
                                </p>
                                <?php echo getSubString(string_decode($search->title),40,'...') ; ?>
                            </span>
                        </div>
                        <div class="head_list fr pl15 width_478">
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
            <?php 
            }
        } ?>
    </div>
    <?php if($items_total >  $perPageRecord) { ?>
        <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchMediaResult/0/search_media_result/'.$prosectionId.''),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
        <div class="seprator_10 clear"></div>
    <?php } ?>
    <div class="submint_btn mt25 mr15 fr">
        <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="supportingLink();">Add</button>
        <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
    </div> 
    <?php   
    } else {
        echo '<div class="pt15">';
        $this->load->view('common/no_search_found');
        echo '</div>';
    }?>
   
<script>
    $(document).ready(function() {
        $(".content_3").mCustomScrollbar({
            scrollInertia:600,
            autoDraggerLength:false
        });
        runTimeCheckBox();
    });
    
    // set selected values 
    function recordSelected(obj){
        $('#entityid').val($(obj).attr('entityid'));
        $('#elementid').val($(obj).attr('rel'));
        $('#projectid').val($(obj).attr('projectid'));
        $('#SupportingProjectName').val($(obj).attr('SupportingProjectName'));
        $('#createrid').val($(obj).attr('createrid'));
    }
    
    // manage associated media result
    function supportingLink(){
        var fromSection    = $('#fromSection').attr('value');
        var entityid_from  = $('#entityid').val();
        var projectid      = $('#elementid').val();
        if(entityid_from != 0) {
            var SupportingProjectName = $('#SupportingProjectName').val();
            var createrid      = $('#createrid').val();
            $('#entityid_from').val(entityid_from);
            $('#elementid_from').val(projectid);
            $('#projName').val(SupportingProjectName);
            $('#keywords').val(SupportingProjectName);
            $('#searchedResult').html(SupportingProjectName);
            $('#supportLinkSave').show();
            $('#supportLinkCancel').show(); 
            $('#popup_close_btn').parent().trigger('close');
        } else {
            alert('Please select an item');  
        }
    }
       
        var ht = $('#associMediaHidden').val();
        if(ht!=""){
            if($('#'+ht).val() > 0)
            {
                $('#'+ht).attr("checked","checked");
                $('#'+ht).parent('div').addClass('ez-selected');
                $('#associMediaHidden').val('');
            }
        }
</script>
