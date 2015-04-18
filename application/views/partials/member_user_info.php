<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
//------get user information for showing data---------// 

if(!empty($userId)){

  //get user showcase details
  $userInfo   =  showCaseUserDetails($userId,'userBackend');
  
  //get user first name
  $userFullName   = (!empty($userInfo['userFullName']))?$userInfo['userFullName']:"";
  $userArea       = (!empty($userInfo['userArea']))?$userInfo['userArea']:"";
  $websiteUrl     = (!empty($userInfo['websiteUrl']))?$userInfo['websiteUrl']:"";
  $showcaseId     = (!empty($userInfo['showcaseId']))?$userInfo['showcaseId']:"0";
  $countryName     = (!empty($userInfo['countryName']))?$userInfo['countryName']:"";
  
  //if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
  if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
    $userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_s'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_s'):$this->config->item('defaultCreativeImg_s'));
  }else{
    $userDefaultImage=$this->config->item('defaultMemberImg_s');
  }
  
  $userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_l','crop_thumb');	
  $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
  
  
    //get user social details
    $socialMediaCondition = array('userId'=>$userId,'showcaseId'=>$showcaseId,'socialLinkArchived'=>'f');
    $userSocialLinks      = getSocialMediaLinks($socialMediaCondition);
   
}

//get class name for memberinfo bg 
$getClassName   =  $this->router->fetch_class(); // get class name
$bgShowList     =  array('mediafrontend','showproject'); // set module name for bg hide

//circul image not come if uesr is enterprise
$userPicsShow = (!empty($userInfo['enterprise']) && $userInfo['enterprise']=='t')?'bussines_profile':'creave_profile';
$entColorShow = (!empty($userInfo['enterprise']) && $userInfo['enterprise']=='t')?'green':'red';
// get wizard edit session value
$isEditMedia = $this->session->userdata('isEditMedia');
// get current class
$currentCls = $this->router->fetch_class();

$packagestageheading = isset($packagestageheading) ? $packagestageheading : '';
?>
<?php 
        
        //check for ornage bar in header
        $headerBgColor  = 'bg_f15a2b';
        $isOrange       = false; // this color for backend
        $isGray         = false; // this color for frontend
        if(sectionShow('orange_bar_show')){
            $isOrange = true;
             $headerBgColor = 'bg_f15a2b';
        }
        
        
        //condition for gray bar
        if(!$isOrange){
            if(sectionShow('gray_bar_show')){
                //$headerBgColor = 'bg_4d4d4d';
                $headerBgColor = 'bg_717171';
                $isGray = true;
            }
        }
        
    ?>
<div class="creave_header <?php  echo ($isGray)?"":"backhead"; ?> ">
     <div class="creave_detail fl position_absolute">
        <?php if(!empty($userId)){ ?>
            <div class="<?php echo  $userPicsShow; ?> fl "><span class="display_table"><span class="table_cell" > <img src="<?php echo $userImage; ?>" alt=""  /></span> </span></div>
           <!-- <div class="<?php echo  $userPicsShow; ?> fl "> <img src="<?php echo $userImage; ?>" alt=""  /></div>-->
        
        <div class="creave_title width_350 pt22  fl pl55">
           <h2 class="<?php echo $entColorShow; ?> fs28 pb11<?php if($isGray){ echo ' bb_f2f2'; } ?>" ><?php echo (!empty($userFullName))?ucwords($userFullName):''; ?></h2>
          <?php if($isGray){ ?><P class="fs15 pt3 "><?php echo $userArea; ?> </P><?php } ?>
        </div>
        <?php } ?>
     </div>

	  <div class="soical_creave fr open_sans">
		<?php if($isGray)
		{
			$socialData = array(
				'websiteUrl'=> $websiteUrl,
				'userSocialLinks'=> $userSocialLinks,
			);
			$this->load->view('showcase/social_icons_new',$socialData);
			
			/* Buyer Comment check with respect to user */
			$getBuyerComment=getDataFromTabel('BuyerComments','id',array('tdsUid'=>$userId), '','','');
			if(!empty($getBuyerComment)){  ?>
				<a class="my_site fs16 clearb pr30 fr height20 mt12" href="<?php echo  base_url_lang('buyer_comment/index/'.$userId); ?>"><i class="buyer_comnet fl pr15"></i> Buyers’ Comments   </a>
			<?php 	}	
		
		} else {	
			
			if(isset($projectId)) {
				$projId = $projectId;
			}
			if(!empty($isEditMedia) && $currentCls == 'media' && isset($projId)) {
				
				// set edit index url
				$editIndexUrl = base_url(lang().DIRECTORY_SEPARATOR.$currentCls.DIRECTORY_SEPARATOR.$this->router->fetch_method().'/editproject/'.$projId); ?>
				<!-- Show edit management link -->		
				<div class="fr fs16">
					<a class="clearb pr30 red_c_arrow fr mt20" href="<?php echo $editIndexUrl;?>"><?php echo $this->lang->line('backtoEdit');?></a>
				</div>
			<?php }
		}?>
    
     </div>
    
     <div class="creave_head <?php echo $headerBgColor; ?>  clearbox">
        <?php 
             //only gray header will show showcase menu
            if($isGray){
                $this->load->view('partials/showcase_menu'); 
            } 
       
			$getClassName   =  $this->router->fetch_class(); // get class name
					
			if($getClassName == "showcase" &&  $isGray == true)
			{
			?> 
				<h3 class="fs18 fr pt8 pr25 clr_fff"><?php echo $countryName; ?></h3>
			<?php 
			}else { ?>
				<h3 class="fs18 fr pt8 pr25 clr_fff open_sans">
					<?php
					// show edit icon for edit wizard
					if(!empty($isEditMedia) && $currentCls == 'media' && $isGray == false) { ?>
						<i class="editWizardIcon"></i>
					<?php }
					echo $packagestageheading; ?>
				</h3>
			<?php	 
			} 
			?>
     </div>
</div>
  <div class="clear"></div>
    <script type="text/javascript">
        (function($) {
            $(function() {
                $("#scroller").simplyScroll({
                    auto: false,
                    speed: 5000,
                    frameRate: 1000,
                });
            });
         })(jQuery);
        /* $(".main_w").mouseover(function(){
            var social_width = $("#scroller").width();
            $(".simply-scroll").css('width',social_width);
            $(".creave_title").css('opacity',0);
            $(".creave_title").css('transition','linear .3s');
        });
        $(".main_w").mouseout(function(){
            $(".simply-scroll").css('width',148);
            $("#scroller").css('left','0');
            $(".creave_title").css('opacity',1);
            $(".creave_title").css('transition','linear 1.5s');
        });
        */
    </script>
<!--
//--(21-jan-2015 commented by lokendra)-----//
<div class="example navscrollbg" id="example1">
    <div class="scrollmenu_bar">
             <?php if(!empty($userId)){ ?>
             <div class="profile_name position_relative zindex_999  " >
                <div class="fl profile_img">
                    <img src="<?php echo $userImage; ?>" alt=""  class="fl mr8" />
                </div>
                <h3 class="fl fs23 font_helLight"><?php echo (!empty($userFullName))?$userFullName:''; ?> </h3>
             </div>
              <?php } ?>
             <div class="tab_wrap" >
                <div class="fs21 mt4 mr28 letter_Spoint1 fshel_midum  clr_fff"><?php echo $packagestageheading; ?></div>
             </div>
             <div class="style_menu <?php echo (in_array($getClassName,$bgShowList)===true)?'bg_4d4d4d':''; ?>">
                <div class="soical pl115 position_relative zindex_999">
                   <?php if(!empty($userId)){ ?>
                    <a href="<?php echo $this->config->item('facebook_follow_url');?>" target="_blank">
                        <div class="social_headerbg h_facebook"></div>
                    </a>
                    <a href="<?php echo $this->config->item('twitter_follow_url');?>" target="_blank">
                        <div class="social_headerbg h_twiter"></div>
                    </a>
                  
                   <div class="social_headerbg h_rss"></div>
                    <?php } ?>
                </div>
             </div>
          <div class="clear"></div>
    </div>
</div>-->
          
