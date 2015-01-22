<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo $head;
$uri= $this->router->method;
$userId = isLoginUser();

			   
  if(isset($accessUserProfile) && ($accessUserProfile!='')) {
	      $accessUserProfile ;
	      // get id of viewd profile users
	      $viewedUserProfileId = decode($accessUserProfile);
		  $profileUserId = explode('-',$viewedUserProfileId);
	      $profileUserId = $profileUserId[0];
	      
       } else {				   
		   
	      $accessUserProfile='';
	      $profileUserId = $userId ;
	  }	
	  
	  
    
?>
	

<body class="body_profile "> 

<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>

<div class="main_blog clr_white">
  <!--top_strip-->
  <div class="wrapper_toad">
    <!--header_contanier-->
    <div class="header_wrapper pr">
	   <?php if ($uri!='unauthorized') { 
		   		  if($accessUserProfile=='') { ?>	

		<!--  <div id="previewFlag"></div>-->

		<?php } } ?>  
      <div class="header_bg_profile" >
        <div class="header_toad_profile" > </div>
        <!--header_toad-->
        <div class="nav_toad_profile">
			
			<?php 			  
			
			switch($uri)
			{
				case 'employePortfolio':
				$classP='active';
				break;
				
				case 'employeImages':
				$classI='active';
				break;
				
				case 'employeAudio':
				$classA='active';
				break;
				
				case 'employeText':
				$classT='active';
				break;
				
				case 'employePortfolio':
				$classP='active';
				break;
				
				case 'employeHistory':
				$classH='active';
				break;
				
				case 'employeShowcase':
				$classS='active';
				break;
				
				default:
               $classdef='active';
				
				}
					
		if($uri!='unauthorized') {	
			if( ($uri!='employeImages') && ($uri!='employePortfolio') && ($uri!='employeText') && ($uri!='employeAudio') )
			{
				?>
			
          <div class="nav_left_profile">
				<?php //Check if history is available 
					if((isset($getSummaryData['getReference']) && count($getSummaryData['getReference']) > 0) || (isset($getSummaryData['getRecommandation']) && count($getSummaryData['getRecommandation']) > 0)) { ?>
				<a class='<?php if(isset($classS))echo $classS ?>' href="<? echo base_url()?>workprofilefrontend/employeShowcase/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('refNrecom');?></a>
				<?php } ?>
				<?php //Check if history is available 
				if(isset($getSummaryData['getHistory']) && count($getSummaryData['getHistory']) > 0) { ?>
				<a class='<?php  if(isset($classH)) echo $classH ?>' href="<? echo base_url()?>workprofilefrontend/employeHistory/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('empHistory');?></a>
				<?php } ?>
				
				<a  class='<?php if(isset($classdef)) echo $classdef ?>' href="<? echo base_url()?>workprofilefrontend/index/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('summary');?></a> </div>
				
          <?php } else {
			   ?>
			<div class="nav_left_profile">
				<?php //Check if profiletext is available 
				if(isset($getMediaData['getprofileText']) && count($getMediaData['getprofileText']) > 0) { ?>
				<a class='<?php if(isset($classT)) echo $classT ?>' href="<? echo base_url()?>workprofilefrontend/employeText/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('text');?></a>
				<?php } ?>
				<?php //Check if audio is available 
				if(isset($getMediaData['getprofileAudio']) && count($getMediaData['getprofileAudio']) > 0) { ?>
				<a class='<?php if(isset($classA)) echo $classA ?>' href="<? echo base_url()?>workprofilefrontend/employeAudio/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('audio');?></a>
				<?php } ?>
				<?php //Check if image is available 
				if(isset($getMediaData['getprofileImages']) && count($getMediaData['getprofileImages']) > 0) { ?>
				<a class='<?php if(isset($classI)) echo $classI ?>' href="<? echo base_url()?>workprofilefrontend/employeImages/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('images');?></a>
				<?php } ?>
				<?php //Check if video is available
				if(isset($getMediaData['getvideo']) && count($getMediaData['getvideo']) > 0) { ?>
				<a class='<?php if(isset($classP)) echo $classP ?>' href="<? echo base_url()?>workprofilefrontend/employePortfolio/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('audioNvisual');?></a> 
				<?php } ?>
				</div>  
 <?php  }      } ?>	  
          
        </div>
        <!--nav_toad-->
      </div>
    </div>

	
 <?php echo get_global_messages(); echo $content?> 


 <div class="footer_wrapper">
      <div class="footer_top_strip_front"> <img src="<?php echo base_url()?>templates/frontend/images/footer_top_strip.png"/> </div>
      <div class="footer_content_profile">
        <div class="pt10">
          <div class="cell width189px height25"></div>    
				<?php				
				if($uri!='unauthorized') {
					
				 //To show social icons of showcase
				 $socialMediaCondition = array('userId'=>$userId,'for'=>'workprofile');
				 echo Modules::run('showcase/showUserSocialLinks',$socialMediaCondition); 
				 $showcaseLink = base_url('showcase/index/'.$profileUserId);
				?>
				<div class="fl tsfollowus mt8 ml20"  onclick="gotourl('<?php echo $showcaseLink;?>',1);">
					<div class="fl font_opensansSBold font_size12 lineH_32 pl6 b tac width_152"><a href="javascript:void(0);" class="clr_white"><?php echo $this->lang->line('SeeMeOnToadsquare');?></a></div>
					<div class="fr mt7 mr7"><img src="<?php echo base_url('images/toadsmall_square.png');?>" alt="toadsquare"></div>     
				</div>
				<?php				
				if( ($uri!='employeImages') && ($uri!='employePortfolio') && ($uri!='employeText') && ($uri!='employeAudio') )
				{
				?>																	
				<div class="tds-button fr mr20 pt10">
					<a href="<?php echo base_url()?>workprofile/pdf_generate/<?php echo $accessUserProfile ?>" target="_blank"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="pr5"><div class="Fleft font_size12 ml5"><?php echo $this->lang->line('print');?></div><div class="print_button width_32"></div></span>
					</a>
				</div> 
				<?php } ?>														          
         <!-- 
		  <div class="tds-button-profile Fright mr23 pt10">
            <button onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>
            <div class="Fleft"><?php //echo $this->lang->line('print');?></div>
            <div class="icon-print-btn"></div>
            </span> </button>
          </div>
         -->
          <div class="clear"></div>
          
          <?php  } ?>
          
        </div>
      </div>
      <!--footer_content-->
      <div class="footer_bottom_strip"> <img src="<?php echo base_url()?>templates/frontend/images/footer_bottom_strip02.png"/> </div>
    </div>
    <!--footer-wrapper-->
    <div class="footer_spacer"></div>
		 
				 
</div>
  <!--wrapper_toad-->
</div>
<!--main-->
</body>
</html>
