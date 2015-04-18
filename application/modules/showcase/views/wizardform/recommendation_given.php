<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$showcaseId=loginUserDetails('showcaseId');
// set base url
$baseUrl = base_url(lang().'/showcase/');
// get received recommendations listing
$recommendationList= Modules::run("recommendations/index",array('from_userid'=>$userId));
//echo "<pre>";
//print_r($recommendationList);
//echo "asdads";?>

    <div class=" pl45 pr25  bg_f3f3f3 fl title_head ">
        <h1 class="pt10 mb0  fl">Recommendations Given</h1>
        <ul class="dis_nav fs16 mt25 fr mr3">
            <li> <a href="<?php echo $baseUrl.'/managerecommendations'?>">Recieved</a> </li>
            <li class="active"> <a href="javascript:void(0);">Given</a> </li>
        </ul> 
    </div>
    <div class="clearbox wizard_wrap minheight_350" id="TabbedPanels1">
        <div class="c_1 m_auto width635">
            <h3>Recommendation you’ve given on Toadsquare.</h3>
            <div class="sap_30"></div>
            <div class="clearbox">
                <!--   Content box -->
                <?php 
                if(!empty($recommendationList)) {
                    foreach($recommendationList as $recommendation) {   
                        // set user's image
                        if(!empty($recommendation->creative) || !empty($recommendation->associatedProfessional) || !empty($recommendation->enterprise)){ 
                        $userDefaultImage=($recommendation->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($recommendation->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                        }else{
                        $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                        }

                        $userTemplateThumbImage = addThumbFolder($recommendation->profileImageName,'_xxs');	
                        $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                        ?>
                        <div class="recom_box  mb22 clearb height126 bdrc9c9 bg_f7f7f7 light_sh">
                            <div class="profile_img width126 display_table fl height126"> 
                                <div class="table_cell"><img src="<?php echo $userImage;?>" alt="" /></div>
                            </div>
                            <div class="fl width367 pl15 pr10">
                                <div class="pt10 font_bold red">
                                    <?php echo $recommendation->firstName.' '.$recommendation->lastName;?> 
                                    <span class="fr clr_444"><?php echo get_timestamp('F Y',$recommendation->created_date);?> </span>
                                </div>
                                <div class="cont_recom fs13 pl7 pr7 pt5 pb10 bdr_cbcbcb mb22 light_sh  bg_fff">
                                    <?php echo nl2br(getSubString($recommendation->recommendations,250));?>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }
                } else {
                    echo "There is no given recommendations in result!";
                }?> 
             </div>
            <div class="sap_25"></div>
            <a href="<?php echo $baseUrl.'/editshowcase';?>">
                <button class="bg_f1592a fr "  type="" >Finish</button>
            </a>
            <div class="sap_25"></div>
        </div>
    </div>
    <!-- End Content wrap  --> 

