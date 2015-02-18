<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="height656 content_3 content overflow_hidden defaultP float_none  pt_34 mCustomScrollbar _mCS_1" id="searchResult">
    <?php
    $usersData = $searchResult;
    if(!empty($usersData)) {
        $formAttributes = array(
            'name'=>'selectCreativeForm',
            'id'=>'selectCreativeForm',
        );
        $crtNameInput = array(
            'name'	=> 'crtSearchName',
            'type'	=> 'hidden',
            'id'	=> 'crtSearchName',
            'value'	=> ''
        );
        $crtLastNameInput = array(
            'name'	=> 'crtLastSearchName',
            'type'	=> 'hidden',
            'id'	=> 'crtLastSearchName',
            'value'	=> ''
        );
        $tdsUidInput = array(
            'name'	=> 'tdsUidSearch',
            'type'	=> 'hidden',
            'id'	=> 'tdsUidSearch',
            'value'	=> '0'
        );
        
        echo form_open($this->uri->uri_string(),$formAttributes);
            echo form_input($crtNameInput);
            echo form_input($crtLastNameInput);
            echo form_input($tdsUidInput);
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
            $logSummryDta = $this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$showcaseEntityId,'elementId'=>$usersData->showcaseId), '','','',1);
            $logSummryDta = $logSummryDta[0];
            $viewCount    = (isset($logSummryDta->viewCount))?$logSummryDta->viewCount:0;
            $craveCount   = (isset($logSummryDta->craveCount))?$logSummryDta->craveCount:0;
            $ratingAvg    = (isset($logSummryDta->ratingAvg))?$logSummryDta->ratingAvg:0;
            $reviewCount  = (isset($logSummryDta->reviewCount))?$logSummryDta->reviewCount:0;
            // set rating avg image
            $ratingAvg = roundRatingValue($ratingAvg);
            $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
            ?>
            <div class="section">
                <div class="fl">
                    <input type="radio"  name="associatedElementId" value="<?php echo $elementid;?>" tdsUid="<?php echo $usersData->tdsUid;?>" crtName="<?php echo $usersData->firstName;?>" crtLastName="<?php echo $usersData->lastName;?>" onclick="recordSelected(this)" >
                </div>
                <div class="wrap_list fl fs13">
                    <div class="display_table list_thumb">
                        <div class="table_cell">
                            <img src="<?php echo $userImage;?>" alt="" />
                        </div>
                    </div>
                    <div class="head_list fr pl15 width_478 bb_F1592A pb4 lineH15 mb6">
                        <p class="fl mt3">
                            <?php echo $usersData->firstName.' '.$usersData->lastName ;?>
                        </p>
                        <span class="fr text_alignR ">
                            <p class="red">
                               <?php echo $userType;?>
                            </p>
                            <?php echo getCountry($usersData->countryId); ?>
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
<?php if($items_total >  $perPageRecord) { ?>
    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchMediaResult/0/search_media_result/'.$prosectionId.''),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
    <div class="seprator_10 clear"></div>
<?php } ?>
<div class="submint_btn mt25 mr15 fr">
    <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="setSelectedMember();">Add</button>
    <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
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
        $('#crtSearchName').val($(obj).attr('crtName'));
        $('#crtLastSearchName').val($(obj).attr('crtLastName'));
        $('#tdsUidSearch').val($(obj).attr('tdsUid'));
    }
     
    // manage search result
    function setSelectedMember() {
        
        var crtName = $('#crtSearchName').val();
        var crtLastName = $('#crtLastSearchName').val();
        var tdsUid = $('#tdsUidSearch').val();
        if(tdsUid != 0) {
            // set field values 
            $('#tcrtName').val(crtName);
            $('#tcrtLastName').val(crtLastName);
            $('#tdsUid').val(tdsUid);
            $('#tcrtDesignation').val('');
            $('#tcrtId').val(0);
            // set first and last name input as readonly
            $('#tcrtName').attr('readonly', true);
            $('#tcrtLastName').attr('readonly', true);
            $('#toadMemSave').show();
            $('#popup_close_btn').parent().trigger('close');
        } else {
            alert('Please select an Creative member');  
        }
    }
</script>
