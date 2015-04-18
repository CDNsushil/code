<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="scroll_right  fr">
    <div class="height656 content_3 content overflow_hidden defaultP float_none pt_34" id="searchResult">
        <?php
        $usersData = $searchData;
        if(!empty($usersData)) {
            $formAttributes = array(
                'name'=>'selectCreativeForm',
                'id'=>'selectCreativeForm',
            );
            $enterpriseNameInput = array(
                'name'	=> 'enterpriseName',
                'type'	=> 'hidden',
                'id'	=> 'enterpriseName',
                'value'	=> ''
            );
            $showcaseIdInput = array(
                'name'	=> 'showcaseId',
                'type'	=> 'hidden',
                'id'	=> 'showcaseId',
                'value'	=> ''
            );
            
            echo form_open($this->uri->uri_string(),$formAttributes);
                echo form_input($enterpriseNameInput);
                echo form_input($showcaseIdInput); 
            echo form_close();
            
            foreach($usersData as $usersData) { 
                
                // set user profile type
                $userType = ($usersData->creative=='t')?'Creative':(($usersData->associatedProfessional=='t')?'Associated Professional':(($usersData->enterprise=='t')?'Enterprise':'Fan'));
               
                // set user profile image
                $userDefaultImage = ($usersData->creative=='t')?$this->config->item('defaultCreativeImg'):(($usersData->associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($usersData->enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
                if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
               
                if($usersData->profileImagePath!='') {
                    $userImage = $usersData->profileImagePath;
                }

                $userImage = addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
                $userImage = getImage($userImage,$userDefaultImage);
               
                $showcaseEntityId = getMasterTableRecord('UserShowcase');
             
                $viewCount    = $usersData->viewCount;
                $craveCount   = $usersData->craveCount;
                $ratingAvg    = $usersData->ratingAvg;
                $reviewCount  = $usersData->reviewCount;
                // set rating avg image
                $ratingAvg = roundRatingValue($ratingAvg);
                $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
                ?>
                <div class="section">
                    <div class="fl">
                        <input type="radio" name="associatedElementId" value="<?php echo $usersData->tdsUid;?>" showcaseId=<?php echo $usersData->showcaseId;?> enterpriseName="<?php echo $usersData->enterpriseName;?>" onclick="recordSelected(this)" >
                    </div>
                    <div class="wrap_list fl fs13">
                        <div class="display_table list_thumb">
                            <div class="table_cell">
                                <img src="<?php echo $userImage;?>" alt="" />
                            </div>
                        </div>
                        <div class="head_list fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                            <p class="fl mt3">
                                <?php echo nl2br(getSubString($usersData->creativeFocus,50));?>
                            </p>
                            <span class="fr text_alignR ">
                                <p class="red">
                                  <?php echo $usersData->enterpriseName;?>
                                </p>
                            </span>
                        </div>
                        <div class="head_list fr pl15 width_478">
                            <div class="fr wrap_s color_666">
                                <div class="icon_view3_blog icon_so">
                                    <?php echo $viewCount;?>
                                </div>
                                <div class="icon_crave4_blog icon_so">
                                    <?php echo $craveCount?>
                                </div>
                                <div class="rating fl pt6">
                                    <img  src="<?php echo base_url($ratingImg);?>" />
                                </div>
                                <div class="btn_share_icon">
                                   <?php echo $reviewCount;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            } ?>
        <?php
        } ?>
    </div>
</div>
<div class="sap_60"></div>
<?php if($items_total >  $perPageRecord) { ?>
    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/showcase/searchenterprisesresult/0/'),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
    <div class="seprator_10 clear"></div>
<?php } ?>
<div class="sap_35"></div>
<div class="mr15 fr">
    <button id="cancelButton" class="bg_ededed p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
    <button class="bg_f1592a fr p10  bdr_a0a0a0 font_weight" type="button" onclick="setSelectedMember();">Select</button>
</div>
<div class="sap_30"></div>
<script>
    $(document).ready(function() {
        $(".content_3").mCustomScrollbar({
            scrollInertia:600,
            autoDraggerLength:false
        });
        runTimeCheckBox();
    });
    
    // set selected values 
    function recordSelected(obj) {
        $('#enterpriseName').val($(obj).attr('enterpriseName'));
        $('#showcaseId').val($(obj).attr('showcaseId'));
    }
     
    // manage search result
    function setSelectedMember() {
        
        var showcaseId = $('#showcaseId').val();
        var enterpriseName = $('#enterpriseName').val();
        if(showcaseId != 0) {
            // set field values 
            $('#searchSelectedDiv').html(enterpriseName);
            $('#associateShowcaseId').val(showcaseId);
            $('#popup_close_btn').parent().trigger('close');
        } else {
            alert('Please select an Creative member');  
        }
    }
</script>
