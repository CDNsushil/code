<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$firstName     =  (!empty($showcaseData->firstName))?$showcaseData->firstName:'';
$lastName      =  (!empty($showcaseData->lastName))?$showcaseData->lastName:'';
$showUserName  =  $firstName.' '.$lastName;


if(!empty($showcaseData->creative) || !empty($showcaseData->associatedProfessional) || !empty($showcaseData->enterprise)){ 
$userDefaultImage=($showcaseData->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($showcaseData->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
}else{
$userDefaultImage=$this->config->item('defaultMemberImg_xxs');
}

$userTemplateThumbImage = addThumbFolder($showcaseData->userImage,'_xxs');	
$userImage = getImage($userTemplateThumbImage,$userDefaultImage);

?>
<div class="width205  pr15 br_fac8b9 display_cell text_alignR verti_top">
    <ul class="fs24 fr lineH34 creave_side_nav opens_light">
        <?php
        if($showcaseData->fans != 't'){
            $cravesTitle= $this->lang->line('CRAVES');
            ?>
            <li <?php if($page=='aboutme') echo 'class="active"';?>><a href=<?php echo base_url(lang().'/showcase/aboutme/'.$showcaseData->tdsUid);?>>ABOUT ME</a></li>
            <li <?php if($page=='videos' ||$page=='introductoryvideo' || $page=='interview') echo 'class="active"';?>><a href="<?php echo base_url(lang().'/showcase/videos/'.$showcaseData->tdsUid);?>">VIDEOS</a></li>
            <li <?php if($page=='developementpath') echo 'class="active"';?>><a href="<?php echo base_url(lang().'/showcase/developementpath/'.$showcaseData->tdsUid);?>">MY PATH</a></li>
            <?php
        }else{
            $cravesTitle = $this->lang->line('MYCRAVES');
        }?>
        <li <?php if($page=='mycraves' || $page=='cravingme') echo 'class="active"';?>><a href="<?php echo base_url(lang().'/showcase/mycraves/'.$showcaseData->tdsUid);?>"><?php echo $cravesTitle;?></a></li>
        <?php
        if((int)$countPlaylistSongs > 0){?>
            <li <?php if($page=='mypaylist') echo 'class="active"';?>><a href="<?php echo base_url_lang('showcase/mypaylist/'.$showcaseData->tdsUid);?>">MY PLAYLIST</a></li>
            <?php
        }?>
    </ul> <?php
    if($showcaseData->fans != 't'){?>
        <div class="sap_45"></div>
        <ul class="clearb share_list mr23 opens_light"><?php 
                //------create share link by current url-------//
            $currentShortUrl = uri_string();

            //-----short module link by email module array-----//
            $showSocialData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'2');
            echo Modules::run("share/sharesocialbutton",$showSocialData);
       
            //-----------crave button module load view-----------//
            $craveButtonData= array('buttonDesigntype'=>'2','buttonTitle'=>'Crave this collection','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
            echo Modules::run("craves/creavebutton",$craveButtonData);

            //------------rating button module load view------------//
            $ratingButtonData = array('buttonDesigntype'=>'2','elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
            echo Modules::run("rating/ratingbutton",$ratingButtonData);

            //------------review button view load-------------//
            $this->load->view('media/reviewViewNew_2',array('elementId'=>$projectId,'entityId'=>$entityId,'projName'=>$projName,'section' =>$industryType,'industryId' =>$projectindustryid,'isPublished'=>$isPublished));	
            ?>
        </ul>
        <div class="sap_30"></div>
        <ul class="clearb share_list mt3 mr23 opens_light">
            <?php
            $loggedUserId=isloginUser();
            $beforeContactmeIn=$this->lang->line('beforeContactmeIn');
            if($loggedUserId > 0){
                if($loggedUserId==$userId){
                    $canNotContactme=$this->lang->line('canNotContactme');
                    $functionContactme="customAlert('".$canNotContactme."')";
                }else{
                    $contactMe=$this->load->view('common/contactme_new',array('showUserName'=>$showUserName,'userId'=>$userId,'userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage), true);
                    echo "<script>var contactMe=".json_encode($contactMe)."</script>";
                    $functionContactme="if(checkIsUserLogin('".$beforeContactmeIn."')){loadPopupData('popupBoxWp','popup_box',contactMe)}";
                }

            }else{
                
                $functionContactme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeContactmeIn."')";
            }
            ?>
            <li> <a href="javascript:void(0)" onclick="<?php echo $functionContactme;?>">Contact me <i class="ab_share contact_me"></i></a></li>
            <?php 
            $loggedUserId=isloginUser();						        
            $beforereqWorkProfile=$this->lang->line('beforereqWorkProfile');
            if($loggedUserId!=$userId) {
                                               
                   $recipientsId=$userId ;								    
            }if($loggedUserId > 0){
                if($loggedUserId==$userId){
                    $canNotReqOwn=$this->lang->line('canNotReqOwn');
                    $functionRequestme="customAlert('".$canNotReqOwn."')";
                }else{
                    $requestMe=$this->load->view('common/request_work_profile_new',array('showUserName'=>$showUserName,'userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage,'recipientsId'=>$recipientsId), true);
                    echo "<script>var requestProfile=".json_encode($requestMe)."</script>";
                    $functionRequestme="if(checkIsUserLogin('".$beforereqWorkProfile."')){loadPopupData('popupBoxWp','popup_box',requestProfile)}";
                }
            }else{
                $functionRequestme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforereqWorkProfile."')";
            }?>
            <li><a href="javascript:void(0)" onclick="<?php echo $functionRequestme;?>"> Request Work Profile <i class="ab_share request_me"></i></a></li>
        </ul>
        <div class="sap_15"></div>
        <div class="opens_light pl23 pt3 clr_666 fl text_alighL"> Connected to <a class="my_site fs16 pr40 open_sans fl mt6" href="javascript:void(0);">Ted’s Plumbing</a></div>
        <?php
    }?>
</div>
