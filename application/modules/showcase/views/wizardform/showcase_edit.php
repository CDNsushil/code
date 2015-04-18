<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
    // set base url
    $baseUrl = base_url(lang().'/showcase/');
    // set rating avg image
    $ratingAvg = roundRatingValue($ratingAvg);
    $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
    //get user showcase details
    $userInfo  =  showCaseUserDetails($userId,'userBackend');
    //get user first name
    $userFullName = $userInfo['userFullName'];
    if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])) {
        $userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_m'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_m'):$this->config->item('defaultCreativeImg_m'));
    } else {
        $userDefaultImage=$this->config->item('defaultMemberImg_m');
    }
    $userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_m');
    $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
    // set language name
    $langName = (!empty($showcaseRes->languageId))?getLanguage($showcaseRes->languageId):'English';
    // set membershil label
    $manageMembershipLbl = 'Upgrade Membership';
    if($subscriptionType == 3) {
        $manageMembershipLbl = 'Downgrade Membership';
    }
	// set publish link lable
	$publishLable = $this->lang->line('editShowcasePublish');
    if($showcaseRes->isPublished == 't') {
		$publishLable = $this->lang->line('editShowcaseUnPublish');
	}
   
?>
<div class="wizard_wrap fs14 ">
    <div class="width900 m_auto display_table">
        <!-- left wrap start-->
        <div class="sap_30"></div>
        <div class="widht_300 lineH18 fl mr40">
            <div class="head_list fl pt8 pb7 pl13 width_273  bg_fdfdfd bdr_ececec ">
                <div class="fl color_666">
                    <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                    <div class="fl mr5 mt6">
                       <img  src="<?php echo base_url($ratingImg);?>" />
                    </div>
                    <div class="btn_share_icon"><?php echo $reviewCount;?></div>
                </div>
            </div>
            <div class="sap_35"></div>
            
            <div class="pt3"><img src="<?php echo $userImage;?>" alt=""  /></div>
            <div class="sap_35"></div>
          
            <div class="clearbox mt3">
                <p class="red"> MEMBERSHIP STORAGE SPACE</p>
                <b><?php echo $remainingSize .' of '. $containerSize?></b>
            </div>
            <div class="sap_15"></div>
            <a href="<?php echo $baseUrl.'/membershipcart/'.$projData->projId;?>">
                <button type="button" class="white_button height40 fs13 pl30 pr30">
                    Add Space
                </button> 
            </a>
            <div class="sap_40"></div>
            <?php 
            if($subscriptionType != 3) { ?>
                <a href="<?php echo base_url(lang().'/package/index');?>">
                    <button class="red pl15 pr15 bdr_a0a0a0 white_button" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $manageMembershipLbl;?></span></button>
                </a>
            <?php } ?>
        </div>
        <!-- left wrap end-->
        
        <!-- right wrap start-->                              
        <div class="right_wrap fl edit_al width_485">
           <div class="sap_65"></div>
           <div class="edit_vedio display_inline_block edit_asoisates mt7 bg_f5f5f5	">
                <ul class="fs18 ml106 pl45 mt46 ">
                    <li>
                        <a href="<?php echo $baseUrl.'/previewnpublishhowcase/';?>" >
                            <?php echo $publishLable;?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                   
                    <li>
                        <a href="<?php echo $baseUrl.'/showcasetype';?>" >
                            <?php echo $this->lang->line('editHomepageIn').$langName;?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $baseUrl;?>" >
                            <?php echo $this->lang->line('viewHomepage');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <li class="sap_5"></li>
                    <li>
                        <a href="<?php echo $baseUrl.'/managerecommendations';?>" >
                            <?php echo $this->lang->line('manageRecomendations');?>
                            <span class="red pl5">&gt;</span>
                        </a>
                    </li>
                    <li class="sap_5"></li>
                    <li>
                        <a href="<?php echo $baseUrl.'/associateshowcase';?>" > 
                            <?php echo $this->lang->line('associateWithBusiness');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                   <li class="sap_5"></li>
                    <li>
                        <a href="<?php echo $baseUrl.'/addotherlanguage';?>" >
                            <?php echo $this->lang->line('addAnotherLang');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <?php if(!empty($multilangData)) { ?>
                        <li>
                           <?php echo $this->lang->line('editMultilangData');?>
                         </li>  
                        <ul class="aso_sub font_bold">
                        <?php
                        foreach($multilangData as $multilangData) { ?>
                            <li>
                                <a href="<?php echo $baseUrl.'/addotherlanguage/'.$multilangData->showcaseLangId;?>" target='_blank'>
                                    <?php echo getLanguage($multilangData->langId);?>
                                    <span class="red pl5"> &gt;</span>
                                </a>
                                
                             </li>
                        <?php }?>
                        </ul>
                    <?php
                    } ?>
                </ul>
                <div class="sap_30"></div>
            </div>
        </div>
        <!-- right wrap end-->
        <div class="sap_60"></div>
    </div>
</div>

<script>
/**
 * Remove Project from media collection
 */
function deleteMediaCollection(projId) {
    confirmBox("Do you really want to delete this project?", function () {
        var fromData='projId='+projId;
        $.post('<?php echo $baseUrl.'/deleteproject';?>',fromData, function(data) {
            window.location.href = '<?php echo $deleteRedirect;?>';
        },'json');
    });
}
</script>

