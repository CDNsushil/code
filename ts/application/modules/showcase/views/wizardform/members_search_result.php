<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="scroll_right  fr">
    <div class="height656 content_3 content overflow_hidden defaultP float_none  pt_34" id="searchResult">
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
            $userIdInput = array(
                'name'	=> 'userId',
                'type'	=> 'hidden',
                'id'	=> 'userId',
                'value'	=> ''
            );
            
            echo form_open($this->uri->uri_string(),$formAttributes);
                echo form_input($enterpriseNameInput);
                echo form_input($userIdInput); 
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
                // set user profile type
                $userType = ($usersData->creative=='t')?'Creative':(($usersData->associatedProfessional=='t')?'Associated Professional':(($usersData->enterprise=='t')?'Enterprise':'Fan'));
               
                ?>
                <div class="section">
                    <div class="fl">
                        <input type="radio" name="associatedElementId" value="<?php echo $usersData->showcaseId;?>" userId="<?php echo $usersData->tdsUid;?>" onclick="recordSelected(this)" >
                    </div>
                    <div class="wrap_list fl fs13">
                        <div class="display_table list_thumb">
                            <div class="table_cell">
                                <img src="<?php echo $userImage;?>" alt="" />
                            </div>
                        </div>
                        <div class="head_list fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                            <p class="fl mt3">
                                <?php echo $usersData->firstName.' '.$usersData->lastName;;?>
                            </p>
                            <span class="fr text_alignR ">
                                <p class="red">
                                  <?php echo $userType;?>
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
<div class="pag_1 pr15 pl30">
    <div class="mr15 fr">
        <button id="cancelButton" class=" bg_ededed p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
        <button class="bg_f1592a fr p10  bdr_a0a0a0 font_weight" type="button" onclick="setSelectedMember();">Compose Tmail</button>
    </div>
    <div class="sap_15"></div>

    <?php if($items_total >  $perPageRecord) { ?>
        <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/showcase/searchmembersresult/0/'),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
        <div class="seprator_10 clear"></div>
    <?php } ?>
    <div class="sap_30"></div>
</div>

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
        $('#userId').val($(obj).attr('userId'));
    }
     
    // manage search result
    function setSelectedMember() {
        
        var userId = $('#userId').val();
        if(userId != 0) {
            // set redirect tmail compose url
            var tmailComposeUrl  = baseUrl+language+'/tmail/compose/'+userId;
            window.open(tmailComposeUrl, '_blank'); 
            // close popup 
            $('#popup_close_btn').parent().trigger('close');
        } else {
            alert('Please select a member');  
        }
    }
</script>
