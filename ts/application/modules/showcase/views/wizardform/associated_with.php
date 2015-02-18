<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="showcase_wizard">
    <div id="TabbedPanels1" class="TabbedPanels"> 
        <div class="content display_table  TabbedPanelsContent width635 m_auto">
            <?php if(!empty($associateShowcaseData)) {
                // set rating avg image
                $ratingAvg = roundRatingValue($associateShowcaseData->ratingAvg);
                $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
                 // set user's image
                if(!empty($associateShowcaseData->creative) || !empty($associateShowcaseData->associatedProfessional) || !empty($associateShowcaseData->enterprise)){ 
                    $userDefaultImage=($associateShowcaseData->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($associateShowcaseData->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                } else {
                    $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                }

                $userTemplateThumbImage = addThumbFolder($associateShowcaseData->profileImageName,'_xxs');	
                $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                ?>
                <div class="c_1 clearb">
                    <h3>You are associated with.</h3>
                    <div class="sap_25"></div>
                    <div class="wrap_list bdr_aeaeae fs13" onclick="gotoUrl('<?php echo base_url(lang().'/showcase/index/'.$associateShowcaseData->showcaseId)?>')"> 
                        <div class="fl"><img src="<?php echo $userImage;?>" alt="" class="max_61X61" /></div>
                        <div class="fl width490">
                            <div class="pl25 height25 bb_F1592A pb6 lineH15 mb6">
                                <p class="fl mt3 letter_spP7"> <?php echo nl2br(getSubString($associateShowcaseData->creativeFocus,50));?> </p>
                                <span class="fr text_alignR ">
                                    <p class="red font_bold lineH12 letter_spP7"><?php echo $associateShowcaseData->enterpriseName;?>
                                    </p>       
                                </span>          
                            </div>
                            <div class="head_list fr pr5 ">
                                <div class="fr pt3 color_666">
                                    <div class="icon_view3_blog icon_so"><?php echo $associateShowcaseData->viewCount;?></div>
                                    <div class="icon_crave4_blog  icon_so"><?php echo $associateShowcaseData->craveCount;?></div>
                                    <div class="fl mr3 mt2"> 
                                         <img  src="<?php echo base_url($ratingImg);?>" />
                                    </div>
                                    <div class="btn_share_icon icon_so"><?php echo $associateShowcaseData->reviewCount;?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fr btn_wrap display_block font_weight">
                    <button class="b_F1592A bdr_F1592A" onclick="deleteEP('<?php echo $associateShowcaseData->showcaseId;?>')">Delete </button>
                </div>
            <?php } else { ?>
                <div class="c_1 clearb">
                   <h3><?php echo $this->lang->line('areYouAssociated');?></h3>
                   <div class="sap_15"></div>
                   <div class="fs16 lineH18">
                       Is a Business you work for or with on Toadsquare? Do you own a business on
                        Toadsquare. If so, associate your Hompage with the business’s and we’ll link the
                        pages together. The business can reject this link.
                    </div>
                </div>
                <div class="sap_25"></div>
                <div class="position_relative ff_arial font_weight fl ml0">
                    <input class="font_wN width278 pl15" type="text" name="searchKeyword" id="searchKeyword" value="" placeholder="Search for an associated Business" placeholder="Search for an associated Business" onclick="placeHoderHideShow(this,'Search for an associated Business','hide')" onblur="placeHoderHideShow(this,'Search for an associated Business','show')">
                    <input class="searchbtbbg search_pop" type="submit" value="Search  Members" name="button">
                    <input id="associateShowcaseId" name="associateShowcaseId" value="" type="hidden">
                </div>
                <!-- Search selected name display here -->
                <div class="fl ml10 mt5" id="searchSelectedDiv"></div>
                <div class="sap_45"></div>
                <ul class="clearb">
                    <li class="icon_2">If a business is not a member of Toadsquare, invite them to join. </li>
                </ul>
                <div class="sap_15"></div>
                <?php
                $shareLink = base_url('home');
                $onclickFunction = "getShortLink('".$shareLink."','email');" ;?>
                <a onclick="<?php echo $onclickFunction ?>" >
                    <button class="white_button red ml34 joinToadBtn">Invite to Join Toadsquare </button>
                </a>
                <div class="fr btn_wrap display_block font_weight">
                    <button class="b_F1592A bdr_F1592A" id="saveAssociation">Finish </button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!--  content wrap  end --> 
<script>
    // manage search popup
    $('.search_pop').click(function() {
        var searchKeyword = $('#searchKeyword').val();
        lightBoxWithAjax('popupBoxWp','popup_box','/showcase/searchenterprises/',searchKeyword,'associatedMember','linkToSoundtrack');
        runTimeCheckBox();
    }); 
    
    function deleteEP(showcaseId){
        confirmBox("Do you really want to delete this associate?", function () {
            var fromData='from_showcaseid='+showcaseId;
            $.post(baseUrl+language+'/showcase/removeassociate',fromData, function(data) {
                window.location.href = window.location.href;
            },'json');
        });
    }
    
    $('#saveAssociation').click(function() {
        var associateShowcaseId = $('#associateShowcaseId').val();
        if(associateShowcaseId != 0 && associateShowcaseId != '') {
            fromData = 'showcaseId='+associateShowcaseId;
            $.post(baseUrl+language+'/showcase/setassociatedenterprise',fromData, function(data) {
                if(data){
                    window.location.href = window.location.href; 
                }
            });
        } else {
            alert('Please select an enterprise');  
        }
    });
    
    // Manage join functionality
    function getShortLink (url,viewType) {
        $.ajax
        ({   
            type: "POST",
            dataType: 'json',
            data:{url:url},
            url: "<?php echo base_url(lang().'/shortlink/addShortLink') ?>",
                success: function(msg){  
                                
                     if(viewType=='share') {
                        openLightBox('popupBoxWp','popup_box','/share/socialShare',msg.shortlink);
                     }
                       else if(viewType=='email') {
                              openLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
                    }      
                }
        });
    }	
    
</script>
