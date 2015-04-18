<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$isLoginUser = isLoginUser();
if($isLoginUser){
    $userName=LoginUserDetails('firstName');
    if(LoginUserDetails('enterprise')=='t'){
      $enterpriseName = LoginUserDetails('enterpriseName');
      if(!empty($enterpriseName)){
            $userName=$enterpriseName;
        }
    }
    $dotShow=(strlen($userName)>15)?'...':'';

    
//showcase default variable for your toadsquare navigation
$isUserShowcase                 =  false;   
$isUserShowcasePublished        =  false;   
$isUserShowcaseCompleted        =  false;   
$userShowcaseCurrentStage       =  false;   

//blog default variable for your toadsquare navigation
$isBlog                     =  false;
$isBlogPublished            =  false;   
$isBlogCompleted            =  false;   
$blogCurrentStage           =  false;   

//review default variable for your toadsquare navigation
$isReviews                     =  false;
$isReviewsPublished            =  false;   
$isReviewsCompleted            =  false;   
$reviewsCurrentStage           =  false;  

//news default variable for your toadsquare navigation
$isNews                         =  false;
$isNewsPublished                =  false;   
$isNewsCompleted                =  false;   
$newsCurrentStage               =  false; 

//upcomming default variable for your toadsquare navigation
$isUpcomming                    =  false;
$isUpcommingCompleted           =  false;   


$isUserMediaShowcase            =  false;   
$isFilmNvideo                   =  false;
$isPhotographyNart              =  false;
$isMusicNaudio                  =  false;
$isWritingNpublishing           =  false;
$isEducationMaterial            =  false;
$isReviews                      =  false;
$isNews                         =  false;
$isFailedConversion             =  false;
$workProfile                    =  false;

//get fan type user 
$fans                       =  LoginUserDetails('fans');

//check user showcase data
if(is_array($userNavigations) && in_arrayr('showcase',$userNavigations,'sectionparent')){
	$showcaseData                   =   key_in_arrayr('showcase',$userNavigations);
    $isUserShowcase                 =  true;   
    $isUserShowcasePublished        =  ($showcaseData['isPublished']=="t")?true:false;   
    $isUserShowcaseCompleted        =  ($showcaseData['isCompleted']=="t")?true:false;   
    $userShowcaseCurrentStage       =  (!empty($showcaseData['currentStage']))?$showcaseData['currentStage']:false;  
}

//check usre blog data
if(is_array($userNavigations) && in_arrayr('blog',$userNavigations,'section')){
	$blogData               =  key_in_arrayr('blog',$userNavigations);
    $isBlog                 =  true;
    $isBlogPublished        =  ($blogData['isPublished']=="t")?true:false;   
    $isBlogCompleted        =  ($blogData['isCompleted']=="t")?true:false;   
    $blogCurrentStage       =  (!empty($blogData['currentStage']))?$blogData['currentStage']:false; 
}

//check usre review data
if(is_array($userNavigations) && in_arrayr('reviews',$userNavigations,'section')){
	$reviewsData               =  key_in_arrayr('reviews',$userNavigations);
    $isReviews                 =  true;
    $isReviewsPublished        =  ($reviewsData['isPublished']=="t")?true:false;   
    $isReviewsCompleted        =  ($reviewsData['isCompleted']=="t")?true:false;   
    $reviewsProjectId          =  $reviewsData['projectid']; 
    $reviewsCurrentStage       =  (!empty($reviewsData['currentStage']))?$reviewsData['currentStage']:false; 
}

//check usre news data
if(is_array($userNavigations) && in_arrayr('news',$userNavigations,'section')){
	$newsData               =  key_in_arrayr('news',$userNavigations);
    $isNews                    =  true;
    $isNewsPublished        =  ($newsData['isPublished']=="t")?true:false;   
    $isNewsCompleted        =  ($newsData['isCompleted']=="t")?true:false;   
    $newsProjectId          =  $newsData['projectid'];   
    $newsCurrentStage       =  (!empty($newsData['currentStage']))?$newsData['currentStage']:false; 
}


//check usre news data
if(is_array($userNavigations) && in_arrayr('upcomingprojects',$userNavigations,'upcomingprojects')){
	
    $isUpcomming                =  true;
    $isUpcommingCompleted       = true;
    //check if any one project is not completed
    if(!empty($userNavigations)){
        foreach($userNavigations as $navigations){
            if($navigations['isCompleted']=="f"){
                $isUpcommingCompleted = false;
            }
        }
    }
    
   
}

if(is_array($showcaseMediaList) && in_array('filmNvideo',$showcaseMediaList)){
	$isFilmNvideo = true;
	$addMediaUrl = 'filmvideocollection';
}

if(is_array($showcaseMediaList) && in_array('photographyNart',$showcaseMediaList)){
	$isPhotographyNart = true;
	$addMediaUrl = 'photoartcollection';
}

if(is_array($showcaseMediaList) && in_array('musicNaudio',$showcaseMediaList)){
	$isMusicNaudio = true;
	$addMediaUrl = 'musicaudiocollection';
}

if(is_array($showcaseMediaList) && in_array('writingNpublishing',$showcaseMediaList)){
	$isWritingNpublishing = true;
	$addMediaUrl = 'writingpubcollection';
}

if(is_array($showcaseMediaList) && in_array('educationMaterial',$showcaseMediaList)){
    $isEducationMaterial = true;
    $addMediaUrl = 'educationalcollection';
}


if(is_array($userNavigations) && in_arrayr('workprofile',$userNavigations,'section')){
    $workProfile = true;
}


if($isFilmNvideo || $isPhotographyNart || $isMusicNaudio || $isWritingNpublishing || $isEducationMaterial ){
    $isUserMediaShowcase = true; 
}

if( $failedVideoCount > 0 || $failedAudioCount > 0 || $failedTextCount > 0) {
	$isFailedConversion = true;
}

//check user media showcase
$isUpcomingFilmNvideo          =  false;
$isUpcomingPhotographyNart     =  false;
$isUpcomingMusicNaudio         =  false;
$isUpcomingWritingNpublishing  =  false;
$isUpcomingEducationMaterial   =  false;
$isUpcomingMediaShowcase       =  false;


?>
    
<div class="fixedposition" id="displaynone1"> </div>
<div class="yourtoadsquare" id="toadsquare" >
   <div class="toadsq position_relative">
      <div class="username fs13"><?php echo showString($userName,15).$dotShow; ?></div>
      <a href="javascript:void(0)"  class="ff_arial">Your Toadsquare</a> 
   </div>
   <div class="menu2 ">
      <div class="redarrow_container"><img alt="toprow" src="<?php echo $imgPath; ?>cssmenutoprow.png" /></div>
      <div class="externalpanel shadow">
         <!-- ===============================  menu second ================================== -->
         <div class="your_toad  bg_f1592a clr_fff display_table "> </div>
         <!--================= Menu section first ================-->
         <ul class="menufrist ul_first  brdr  brc2c2c2  dropdown-menu" >
            <?php 
                
              
                //your showcase homepage not menu 
                if($isUserShowcase){
                    $showcaseArray= array('isUserShowcaseCompleted'=>$isUserShowcaseCompleted,'userShowcaseCurrentStage'=>$userShowcaseCurrentStage);
                    $this->load->view('yourtoadsquare/your_showcase_homepage',$showcaseArray);
                }
                    
                //check if user showcase publish the show menu  
                if($isUserShowcasePublished){
                    
                    //add work profile & portfolio not menu 
                    if($workProfile==true){
                        $this->load->view('yourtoadsquare/your_work_profile_n_portfolio');
                    }
                    
                    //your blog menu
                    if($isBlog){
                        $blogArray  = array('isBlogCompleted'=>$isBlogCompleted,'blogCurrentStage'=>$blogCurrentStage);
                        $this->load->view('yourtoadsquare/your_blog',$blogArray);
                    }
                    
                    //your reviews menu
                    if($isReviews){
                        $reviewsData = array('reviewsProjectId'=>$reviewsProjectId,'isLoginUser'=>$isLoginUser,'isReviewsCompleted'=>$isReviewsCompleted,'reviewsCurrentStage'=>$reviewsCurrentStage);
                        $this->load->view('yourtoadsquare/your_reviews',$reviewsData);
                    }
                    
                    //your news menu
                    if($isNews){
                        $newsData = array('newsProjectId'=>$newsProjectId,'isLoginUser'=>$isLoginUser,'isNewsCompleted'=>$isNewsCompleted,'newsCurrentStage'=>$newsCurrentStage);
                        $this->load->view('yourtoadsquare/your_news',$newsData);
                    }
                    
                    //add media showcase not menu
                    if($fans=='f' &&  $isUserMediaShowcase){
                        $mediaShowcase = array(
                            'isFilmNvideo'          =>  $isFilmNvideo,
                            'isMusicNaudio'         =>  $isMusicNaudio,
                            'isPhotographyNart'     =>  $isPhotographyNart,
                            'isWritingNpublishing'  =>  $isWritingNpublishing,
                            'isEducationMaterial'   =>  $isEducationMaterial,
                            'isFailedConversion'    =>  $isFailedConversion,
                        );
                        $this->load->view('yourtoadsquare/your_media_showcases',$mediaShowcase);
                    }
                    
                    
                    //add upcomming media showcase menu
                    if($fans=='f' && $isUpcomming){
                        
                        $upcommingData = array('isUpcommingCompleted'=>$isUpcommingCompleted);
                        $this->load->view('yourtoadsquare/your_upcoming_media_showcase',$upcommingData);
                    }
                    
                }
                
               
                
            ?>
                <?php
                    //check user showcase exist
                    if($isUserShowcase){
                ?>
                    <li class="bd_t pt1  pb20"> </li>
                <?php } ?>
            <?php
            
                //your meeting points menu
                //$this->load->view('yourtoadsquare/your_meeting_points');
            
                //your message center menu
                $messageMenuData = array(
                    'readMsgCount'=>$readMsgCount,
                    'unreadMsgCount'=>$unreadMsgCount,
                    'notificationCount'=>$notificationCount,
                    'contactCount'=>$contactCount,
                );
                $this->load->view('yourtoadsquare/your_message_center',$messageMenuData);
          
                //your crave section menu
                $craveMenuData = array(
                    'myCravesCount'=>$myCravesCount,
                );
                $this->load->view('yourtoadsquare/your_craves',$craveMenuData);
          
                //your playlist menu
                $palylistMenuData = array(
                    'myPlaylistCount'=>$myPlaylistCount,
                );
                $this->load->view('yourtoadsquare/your_playlist',$palylistMenuData);
                
                
                //your shopping card
                $shoppingMenuData = array(
                    'wishlistCount'=>$wishlistCount,
                    'purchaseCount'=>$purchaseCount,
                    'salesCount'=>$salesCount,
                );
                $this->load->view('yourtoadsquare/your_shopping_cart',$shoppingMenuData);
                
                
                //comment on the form menu
                $commentMenuData = array(
                    'isUserShowcase'=>$isUserShowcase,
                );
                $this->load->view('yourtoadsquare/comment_on_the_forum',$commentMenuData);
                
                //your membership menu 
                $membershipMenuData = array(
                    'packageDetails'=>$packageDetails,
                );
                $this->load->view('yourtoadsquare/your_membership',$membershipMenuData);
                
                
                //your global menu 
                $globalMenuData = array(
                    'isUserShowcase'=>$isUserShowcase,
                );
                $this->load->view('yourtoadsquare/your_global_settings',$globalMenuData);
            ?> 
            
            <li class="bd_t bg_f1f1f1 mt15 pt1 addptlogic"> </li>
            
                <?php 
                    
                    //add showcase homepage not menu 
                    if($isUserShowcase==false){
                        $this->load->view('yourtoadsquare/add_showcase_homepage');
                    }
                    
                    //add work profile & portfolio not menu 
                    if($workProfile==false){
                        $this->load->view('yourtoadsquare/add_work_profile_n_portfolio');
                    }
                    
                    //check user showcase should be published
                    if($isUserShowcasePublished){
                    
                            //add blog not menu
                            if($isBlog==false){
                                $this->load->view('yourtoadsquare/add_your_blog');
                            }
                            
                            
                            //add reviews not menu
                            if($isReviews==false){
                                $this->load->view('yourtoadsquare/add_reviews');
                            }
                            
                            //add news not menu
                            if($isNews==false) {
                                $this->load->view('yourtoadsquare/add_news');
                            }
                            
                            
                            //add media showcase not menu
                            if($fans=='f' && $isUserMediaShowcase==false){
                                $addMediaMenu = array("fans"=>$fans);
                                $this->load->view('yourtoadsquare/add_media_showcases',$addMediaMenu);
                            }
                            
                            //add upcomming media showcase not menu
                            if($fans=='f' && $isUpcomming==false){
                                $this->load->view('yourtoadsquare/add_upcoming_media_showcase');
                            }
                            
                             //add an event menu
                            //$this->load->view('yourtoadsquare/add_an_event');
                            
                            //add an upcomming event menu
                            //$this->load->view('yourtoadsquare/add_an_upcoming_event');
                            
                            //put up an event notice menu
                            //$this->load->view('yourtoadsquare/put_up_an_event_notice');
                            
                            
                            //product classified menu
                            //$this->load->view('yourtoadsquare/add_a_product_classified');
                            
                             //work classified menu
                            //$this->load->view('yourtoadsquare/add_a_work_classified');
                            
                            //enter a competition menu
                            //$this->load->view('yourtoadsquare/enter_a_competition');
                            
                            //add a competition menu
                            //$this->load->view('yourtoadsquare/add_a_competition');
                            
                            //add a Collaboration menu
                            // $this->load->view('yourtoadsquare/add_a_collaboration');
                            
                            
                            //add a Ad Campaign menu
                            //$this->load->view('yourtoadsquare/add_a_ad_campaign');
                            
                            //favourite site menu
                            //$this->load->view('yourtoadsquare/share_a_favourite_site');
                    }
                ?>
                                    
            <li class="bd_t pt1 bg_f3f3f3 mb15 "> </li>
            
            <?php 
                //invite friends to join menu
                $this->load->view('yourtoadsquare/invite_friends_to_join');
                
                //Feedback menu
                $this->load->view('yourtoadsquare/feedback');
            ?>
           
         </ul>
      </div>
   </div>
</div>
                        

<?php
}?>


<script  type="text/javascript">
    
   
    $(document).ready(function(){
        
        //select media showcase
        var mediatype= "filmvideo"; //set default path
        $(".mediaselctedsubmit").click(function(){
            $(".mediaselect").each(function(){
                if($(this).is(":checked")){
                    mediatype =  $(this).attr('id');
                }
            })
            
            window.location.href = baseUrl+'media/'+mediatype; //redirect on media page
            
            return false;
        });
		
        //feedback form submit code
		$("#feedbackForm").validate({
			  submitHandler: function() {
				var fromData=$("#feedbackForm").serialize();
				fromData = fromData+'&ajaxHit=1';
				$('#feedbackFormDiv').html('<img  src="<?php echo  base_url(); ?><?php echo $imgPath; ?>loading_wbg.gif">');
				$.post(baseUrl+language+'/common/feedbackSave',fromData, function(data) {
				  if(data){
                        refreshPge();
                        //$('#feedbackForm').html('<div class="p10 mr10"><?php echo $this->lang->line('feedbackMsg');?></div>');
                    }
				});
			 }
		});
        
        //invite form submit code
        $("#inviteForm").validate({
			  submitHandler: function() {
				var fromData=$("#inviteForm").serialize();
				fromData = fromData+'&ajaxHit=1';
				$('#inviteFormDiv').html('<img  src="<?php echo  base_url(); ?>images/loading_wbg.gif">');
				$.post(baseUrl+language+'/common/invitefriend',fromData, function(data) {
				  if(data){
                        refreshPge();
                        //$('#feedbackForm').html('<div class="p10 mr10"><?php echo $this->lang->line('feedbackMsg');?></div>');
                    }
				});
			 }
		});
		
	
	});
    
    
    $(".navHeading").mouseover(function(){
        $('.submenuItem').css("display", "none");
    });
    
        // top nAVIGATION DELAY TIMTIG JS START
        var $menu = $(".dropdown-menu");
        // jQuery-menu-aim: <meaningful part of the example>
        // Hook up events to be fired on menu row activation.
        $menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu
        });
        // jQuery-menu-aim: </meaningful part of the example>

        // jQuery-menu-aim: the following JS is used to show and hide the submenu
        // contents. Again, this can be done in any number of ways. jQuery-menu-aim
        // doesn't care how you do this, it just fires the activate and deactivate
        // events at the right times so you know when to show and hide your submenus.
        function activateSubmenu(row) {
            var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId),
            height = $menu.outerHeight(),
            width = $menu.outerWidth();

            $('.submenuItem').css("display", "none");
            $row.find("a").removeClass("maintainHover");
            // Show the submenu
            $submenu.css({
                display: "block",
                top: 1,
            // padding for main dropdown's arrow
            });

            // Keep the currently activated row's highlighted look
            $row.find("a").addClass("maintainHover");
        }

        function deactivateSubmenu(row) {
            var $row = $(row),
            submenuId = $row.data("submenuId"),
            $submenu = $("#" + submenuId);

            // Hide the submenu and remove the row's highlighted look
            $submenu.css("display", "none");
            $row.find("a").removeClass("maintainHover");
        }

        // Bootstrap's dropdown menus immediately close on document click.
        // Don't let this event close the menu if a submenu is being clicked.
        // This event propagation control doesn't belong in the menu-aim plugin
        // itself because the plugin is agnostic to bootstrap.
        $(".dropdown-menu li").click(function(e) {
            e.stopPropagation();
        });


        $("#displaynone").hover(function(){
            $(".popover").css("display", "none");
            $("a.maintainHover").removeClass("maintainHover");
        });

        $("#displaynone1").hover(function(){
            $(".popover").css("display", "none");
            $("a.maintainHover").removeClass("maintainHover");
        });
        
        
        $(".upcomingmediasubmit").click(function(){
			$(".upmediaselect").each(function(){
                if($(this).is(":checked")){
                    mediatype =  $(this).attr('id');
                }
            })
            
            window.location.href = baseUrl+language+'/upcomingprojects/donation/0/'+mediatype; //redirect on media page
            
            return false;
        });

        //link disabled for remove href from disabled div
        $(".linkdisabled a").each(function(){
           $(this).removeAttr("href");
        });
        
        $(".addptlogic").next().addClass("pt10");
        // top nAVIGATION DELAY TIMTIG JS END
    </script>
