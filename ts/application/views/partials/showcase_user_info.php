<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//------get user information for showing data---------// 

if(!empty($userId)){

  //get user showcase details
  $userInfo   =  showCaseUserDetails($userId,'userBackend');
  
  //get user first name
  $userFullName   =  $userInfo['userFullName'];
  $countryName    =  $userInfo['countryName'];
  $websiteUrl     =  $userInfo['websiteUrl'];
  
  //if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
  if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
    $userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_s'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_s'):$this->config->item('defaultCreativeImg_s'));
  }else{
    $userDefaultImage=$this->config->item('defaultMemberImg_s');
  }
  
  $userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_s');	
  $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
}

//get class name for memberinfo bg 
$getClassName   =  $this->router->fetch_class(); // get class name
$bgShowList     =  array('mediafrontend','showproject'); // set module name for bg hide

//get user social details
$socialMediaCondition = array('userId'=>$userId,'showcaseId'=>$showcaseId,'socialLinkArchived'=>'f');
$userSocialLinks      = getSocialMediaLinks($socialMediaCondition);


$UNC = (isset($UNC ) && !empty($UNC ))?$UNC:'red';
$PIC = (isset($PIC ) && !empty($PIC ))?$PIC:'creave_profile';
$showcaseType = (isset($showcaseType ) && !empty($showcaseType ))?$showcaseType:'';
//if($showcaseType != 'fan'){?>
    <div class="creave_header">
         <div class="creave_detail fl position_absolute">
            <?php if(!empty($userId)){ ?>
                <div class="<?php echo $PIC;?> fl"> <img src="<?php echo $userImage; ?>" alt="" /> </div>
            <?php } ?>
            <div class="creave_title width_350 pt22  fl pl55">
               <h2 class="<?php echo $UNC;?> fs28 pb11 bb_f2f2"><?php echo (!empty($userFullName))?ucwords($userFullName):''; ?></h2>
               <P class="fs15 pt3">  <?php echo isset($creativeArea)?$creativeArea:'';?></P>
            </div>
         </div>
        <div class="soical_creave fr ">
                <?php 
                    
                    $socialData = array(
                        'websiteUrl'=> $websiteUrl,
                        'userSocialLinks'=> $userSocialLinks,
                    );
                    $this->load->view('showcase/social_icons_new',$socialData);
                
                 ?>
         </div>
         <div class="creave_head bg_717171 clearbox">
            <?php 
                 //showcase menu
                if(sectionNotShow('showcase_menu')){
                    $this->load->view('partials/showcase_menu'); 
                } 
            ?>
            <h3 class="fs18 fr pt8 pr25 clr_fff"><?php echo $countryName; ?></h3>
         </div>
    </div>
      <div class="clear"></div>
    <script type="text/javascript">
        (function($) {
            $(function() {
                $("#scroller").simplyScroll({
                    auto: false,
                    speed: 10
                });
            });
         })(jQuery);
         $(".main_w").mouseover(function(){
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
    </script>
    <?php
/*}else{ ?>
    <div class="fans_header">
     <div class="creave_detail fl ">
        
        <div class="creave_title width_350 pt22 pb28  fl ">
           <h2 class="red fs28 "><?php echo (!empty($userFullName))?ucwords($userFullName):''; ?></h2>
          
        </div>
     </div>
     
     <div class="creave_head bg_717171 clearbox">
        <h3 class="fs18 fr pt8 pr25 clr_fff"><?php echo $countryName; ?></h3>
     </div>
  </div>
  <div class="clear"></div>
<?php
}*/?>
