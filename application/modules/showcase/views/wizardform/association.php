<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
 <div class="showcase_wizard">
    <div id="TabbedPanels1" class="TabbedPanels"> 
        <div class="content display_table  TabbedPanelsContent width635 m_auto">
            <div class="c_1 clearb">
                <h3>Accept or reject a request for an association to your business.</h3>
                <div class="sap_10"></div>
                <?php 
                if(!empty($nonActiveAssociation)) { ?>
                    <div class="fs16 lineH18">
                        A member has said they are associated with your business and want to puta link on
                        their Homepage to yours. Accept or reject them. If you accept them a link to their
                        Homepage will be added to your Showcase.
                    </div>
                    <div class="sap_40"></div>
                    <!--  content box--> 
                    <?php 
                    foreach($nonActiveAssociation as $nonActiveAssociation) {
                        // set rating avg image
                        $ratingAvg = roundRatingValue($nonActiveAssociation->ratingAvg);
                        $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
                         // set user's image
                        if(!empty($nonActiveAssociation->creative) || !empty($nonActiveAssociation->associatedProfessional) || !empty($nonActiveAssociation->enterprise)){ 
                            $userDefaultImage=($nonActiveAssociation->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($nonActiveAssociation->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                        }else{
                            $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                        }

                        $userTemplateThumbImage = addThumbFolder($nonActiveAssociation->profileImageName,'_xxs');	
                        $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                        ?>
                        <div class="clearbox mb15">
                            <div class="wrap_list bdr_aeaeae fs13">
                                <div class="fl"><img src="<?php echo $userImage;?>" alt="" class="max_61X61" /></div>
                                <div class="fl width490">
                                    <div class="pl25 height25 bb_F1592A pb6 lineH15 mb6">
                                        <p class="fl mt3 letter_spP7"> <?php echo nl2br(getSubString($nonActiveAssociation->creativeFocus,50));?> </p>
                                        <span class="fr text_alignR ">
                                            <p class="red font_bold lineH12 letter_spP7"><?php echo $nonActiveAssociation->enterpriseName;?></p>
                                        </span> 
                                    </div>
                                    <div class="head_list fr pr5 ">
                                        <div class="fr pt3 color_666">
                                            <div class="icon_view3_blog icon_so"><?php echo $nonActiveAssociation->viewCount;?></div>
                                            <div class="icon_crave4_blog  icon_so"><?php echo $nonActiveAssociation->craveCount;?></div>
                                            <div class="fl mr3 mt2"> <img src="<?php echo base_url($ratingImg);?>" alt=""  /> </div>
                                            <div class="btn_share_icon icon_so"><?php echo $nonActiveAssociation->reviewCount;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="red fr mt10">
                                <a href="javascript:void(0)" onclick="manageAssociationStatus('<?php echo $nonActiveAssociation->id;?>',1)">Accept</a>
                                <span class="pl5 pr5">/</span>
                                <a href="javascript:void(0)" onclick="manageAssociationStatus('<?php echo $nonActiveAssociation->id;?>',2)">Reject</a>
                            </div>
                        </div>    
                    <?php 
                    } 
                } else {
                    echo "There is no pending requests for association!";
                } ?>
            </div>
            <h3>Members associate with your business</h3>
            <div class="sap_25"></div>
            <!--  content box--> 
            <?php 
            if(!empty($activeAssociation)) {
                foreach($activeAssociation as $activeAssociation) {
                    // set rating avg image
                    $ratingAvg = roundRatingValue($activeAssociation->ratingAvg);
                    $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
                     // set user's image
                    if(!empty($activeAssociation->creative) || !empty($activeAssociation->associatedProfessional) || !empty($activeAssociation->enterprise)){ 
                        $userDefaultImage=($activeAssociation->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($activeAssociation->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                    }else{
                        $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                    }

                    $userTemplateThumbImage = addThumbFolder($activeAssociation->profileImageName,'_xxs');	
                    $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                    ?>
                    <div class="clearbox mb15">
                        <div class="wrap_list bdr_aeaeae fs13">
                            <div class="fl"><img src="<?php echo $userImage;?>" alt="" class="max_61X61" /></div>
                            <div class="fl width490">
                                <div class="pl25 height25 bb_F1592A pb6 lineH15 mb6">
                                    <p class="fl mt3 letter_spP7"> <?php echo nl2br(getSubString($activeAssociation->creativeFocus,50));?> </p>
                                    <span class="fr text_alignR ">
                                        <p class="red font_bold lineH12 letter_spP7"><?php echo $activeAssociation->enterpriseName;?></p>
                                    </span> 
                                </div>
                                <div class="head_list fr pr5 ">
                                    <div class="fr pt3 color_666">
                                        <div class="icon_view3_blog icon_so"><?php echo $activeAssociation->viewCount;?></div>
                                        <div class="icon_crave4_blog  icon_so"><?php echo $activeAssociation->craveCount;?></div>
                                        <div class="fl mr3 mt2"> <img src="<?php echo $ratingImg;?>" alt=""  /> </div>
                                        <div class="btn_share_icon icon_so"><?php echo $activeAssociation->reviewCount;?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="red fr mt10"><a href="javascript:void(0)" onclick="manageAssociationStatus('<?php echo $activeAssociation->id;?>',3)">Remove</a></div>
                    </div>
                <?php
                }
            } else {
                echo "There is no associated members for association!";
            } ?>
            <div class="fr  display_block mt20 mb36">
               <a href="<?php echo $baseUrl.'/editshowcase';?>">
                    <button class="bg_f1592a fr "  type="" >Finish</button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
   /**
    * Manage associated acceptance status
    */
    function manageAssociationStatus(associateId,statusType) {
        alert(associateId+'=='+statusType);
        if(associateId != '' && statusType != '') {
            fromData = 'associateId='+associateId+'&statusType='+statusType;
            $.post(baseUrl+language+'/showcase/setassociatestatus',fromData, function(data) {
                if(data){
                    window.location.href = window.location.href; 
                }
            });
        }
    }
</script>

