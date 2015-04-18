<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//add preview word if preview mode is active
$previewWord =  (previewModeActive())?"/preview":"";

$firstName     =  (!empty($showcaseData->firstName))?$showcaseData->firstName:'';
$lastName      =  (!empty($showcaseData->lastName))?$showcaseData->lastName:'';
$showUserName  =  $firstName.' '.$lastName;


if(!empty($showcaseData->creative) || !empty($showcaseData->associatedProfessional) || !empty($showcaseData->enterprise)){ 
$userDefaultImage=($showcaseData->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($showcaseData->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
}else{
$userDefaultImage=$this->config->item('defaultMemberImg_xxs');
}

if(isset($showcaseData->stockImageId) && is_numeric($showcaseData->stockImageId) && ($showcaseData->stockImageId > 0) )
{
    $userImage=$showcaseData->stockImgPath.DIRECTORY_SEPARATOR.$showcaseData->stockFilename;					
}
elseif(isset($showcaseData->username) && isset($showcaseData->profileImageName) )
{
    $profileImagePath  = 'media/'.$showcaseData->username.'/profile_image/';
    $userImage=$profileImagePath.$showcaseData->profileImageName;	
}else{
    $userImage= '';
}

$userTemplateThumbImage = addThumbFolder($userImage,'_xxs');	
$userImage = getImage($userTemplateThumbImage,$userDefaultImage);


//---------------------check associated button condition------------------
    
    /* To Show/Hide Associated Button  */
    if($showcaseData->enterprise=='t'){
        $where = array('from_showcaseid'=>$showcaseId);
        $profileName= $showcaseData->firstName.' '.$showcaseData->lastName;
    } else {				  				  
        $where = array('to_showcaseid'=>$showcaseId);
        $profileName= $showcaseData->enterpriseName;			   
    }
    $isSlef =false;

    $showAssociateButton= countResult('AssociatedEnterprise',$where);
    
    $target='';


    if(isset($showcaseData->from_showcaseid) && $showcaseData->from_showcaseid > 0 &&  $showcaseData->enterprise !='t'){

        $whereCondi=array(
            'showcaseId'=> $showcaseData->from_showcaseid,
            'isPublished'=> 't'
        );
        $getUserIdByShow=getDataFromTabel('UserShowcase', 'tdsUid',  $whereCondi, '', $orderBy='', '', 1 );
        $getFromShowUserId = "";
        if($getUserIdByShow)
        {
            $getUserIdByShow = $getUserIdByShow[0];
            $getFromShowUserId = $getUserIdByShow->tdsUid;
        }else
        {
            $showAssociateButton = 0;
        }

        $link=base_url(lang().'/showcase/aboutme/'.$getFromShowUserId.$previewWord);
        $target='target="_blanck"';
    }elseif($showcaseData->enterprise !='t'){
        $link='';
        //$link="javascript:customAlert('you are not associated with any enterprise.')";
        
    }else{
        
        
        $whereCondi=array(
            'tdsUid'=> $showcaseData->tdsUid,
            'isPublished'=> 't'
        );
        $getUserIdByShow=getDataFromTabel('UserShowcase', 'showcaseId',  $whereCondi, '', $orderBy='', '', 1 );
        $getFromShowUserId = "";
        
        if($getUserIdByShow)
        {
            $getUserIdByShow = $getUserIdByShow[0];
            $getFromShowcaseId = $getUserIdByShow->showcaseId;
        }
        $getIsAssociatedMembers	= 	 getIsAssociatedMembers($getFromShowcaseId);
        if($getIsAssociatedMembers && count($getIsAssociatedMembers) > 0)
        {
            $isSlef = true;
            $link=base_url(lang().'/showcase/associatedmembers/'.$showcaseData->tdsUid.$previewWord);
        }else
        {
            $showAssociateButton = 0;
        }	
    }
   //echo "<pre>";
	//print_r($showcaseData);


?>

     


<div class="width205  pr15 br_fac8b9 display_cell text_alignR verti_top">
    <ul class="fs24 fr lineH34 creave_side_nav opens_light">
		<?php if(!empty($showcaseData->promotionalsection)){ ?>
			<li <?php if($page=='aboutme') echo 'class="active"';?>><a href=<?php echo base_url(lang().'/showcase/aboutme/'.$showcaseData->tdsUid.$previewWord);?>>ABOUT ME</a></li>
		<?php } ?>
        <?php 
        if(!empty($showcaseData->introductoryFileId) || !empty($showcaseData->interviewFileId)){ ?>
            <li <?php if($page=='videos' ||$page=='introductoryvideo' || $page=='interview') echo 'class="active"';?>><a href="<?php echo base_url(lang().'/showcase/videos/'.$showcaseData->tdsUid.$previewWord);?>">VIDEOS</a></li>
        <?php } ?>
        <?php if(($showcaseData->creativeFocus != "") || ($showcaseData->creativePath != "")) { ?>
        <li <?php  if($page=='developementpath') echo 'class="active"';?> ><a href="<?php echo base_url(lang().'/showcase/developementpath/'.$showcaseData->tdsUid.$previewWord);?>">MY PATH</a></li>
            
        <?php
	}
      
        if($showcaseData->fans != 't'){
            $cravesTitle= $this->lang->line('CRAVES');
        }else{
            $cravesTitle = $this->lang->line('MYCRAVES');
        }?>
        <li <?php if($page=='mycraves' || $page=='cravingme') echo 'class="active"';?>><a href="<?php echo base_url(lang().'/showcase/mycraves/'.$showcaseData->tdsUid.$previewWord);?>"><?php echo $cravesTitle;?></a></li>
        <?php
        if((int)$countPlaylistSongs > 0){?>
			
            <li <?php if($page=='mypaylist') echo 'class="active"';?>><a href="<?php echo base_url_lang('showcase/mypaylist/'.$showcaseData->tdsUid.$previewWord);?>">MY PLAYLIST</a></li>
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
            $craveButtonData= array('buttonDesigntype'=>'2','buttonTitle'=>'Crave this collection','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$showcaseData->tdsUid,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":""}');
            echo Modules::run("craves/creavebutton",$craveButtonData);

            //------------rating button module load view------------//
            $ratingButtonData = array('buttonDesigntype'=>'2','elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
            echo Modules::run("rating/ratingbutton",$ratingButtonData);
            //------------review button view load-------------//
            $this->load->view('media/reviewViewNew',array('reviewdesign'=>'2','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>$industryId,'isPublished'=>$isPublished));
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
                    
                    //check preview mode
                    if(previewModeActive()){
                        $canNotContactme=$this->lang->line('canNotContactmePreivew');
                    }
                    
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
            <li> <a href="javascript:void(0)" onclick="<?php echo $functionContactme;?>">
            <span class="fl">
            Contact Me by Tmail</span> <i class="ab_share contact_me"></i></a></li>
            <?php 
            $loggedUserId=isloginUser();						        
            $beforereqWorkProfile=$this->lang->line('beforereqWorkProfile');
            if($loggedUserId!=$userId) {
                                               
                   $recipientsId=$userId ;								    
            }if($loggedUserId > 0){
                if($loggedUserId==$userId){
                    $canNotReqOwn=$this->lang->line('canNotReqOwn');
                    
                    //check preview mode
                    if(previewModeActive()){
                        $canNotReqOwn=$this->lang->line('canNotReqOwnPreivew');
                    }
                    
                    $functionRequestme="customAlert('".$canNotReqOwn."')";
                }else{
                    $requestMe=$this->load->view('common/request_work_profile_new',array('showUserName'=>$showUserName,'userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage,'recipientsId'=>$recipientsId), true);
                    echo "<script>var requestProfile=".json_encode($requestMe)."</script>";
                    $functionRequestme="if(checkIsUserLogin('".$beforereqWorkProfile."')){loadPopupData('popupBoxWp','popup_box',requestProfile)}";
                }
            }else{
                $functionRequestme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforereqWorkProfile."')";
            }?>
            <li><a href="javascript:void(0)" onclick="<?php echo $functionRequestme;?>"> 
            <span class="fl">Request Work Profile </span><i class="ab_share request_me"></i></a></li>
        </ul>
        <div class="sap_15"></div>
        
            <?php if( $showAssociateButton >0 && $isSlef==false){ ?>
            <div class="opens_light pl23 pt3 clr_666 fl text_alighL"> 
                Connected to 
                <a class="my_site fs16 pr40 open_sans fl mt6" <?php echo $target;?> href="<?php echo $link;?>">
                    <?php echo $memberHeading;?>
                </a>
            </div>
            <?php } ?>
        <?php
    }?>
</div>
