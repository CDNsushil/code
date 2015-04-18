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
}  ?>
	
<body class="portfolio_wrap">
	<div class="portfolio_container mt30 mb30 ">
	
		<div class="dn" id="popupBoxWp">
			<div class="popup_box" id="popup_box"></div>
		</div>
		
		<!--- header wrapper start --->
		<div class="clearbox port_header">
			
			<h2 class="fs24 fl">
				<?php 
				$profileFName = (isset($workDetail->profileFName)) ? $workDetail->profileFName : ''; // set first name
				$profileLName = (isset($workDetail->profileLName)) ? $workDetail->profileLName : ''; // set last name
				echo $profileFName.' '.$profileLName ?>
			</h2>
			<div class="fr">
				<ul class="port_nav open_sans">	
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
						
						case 'personalDetails':
						$classPD='active';
						break;
						
						case 'employeShowcase':
						$classS='active';
						break;
						
						default:
					   $classdef='active';	
					}
							
					if($uri!='unauthorized') {	
						if( ($uri!='employeImages') && ($uri!='employePortfolio') && ($uri!='employeText') && ($uri!='employeAudio') ) { ?>
							<li class='<?php if(isset($classdef)) echo $classdef ?>'>
								<a href="<? echo base_url()?>workprofilefrontend/index/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('summary');?></a>
							</li>
							<?php
							//Check if history is available 
							if(isset($getSummaryData['getHistory']) && count($getSummaryData['getHistory']) > 0) { ?>
								<li class='<?php  if(isset($classH)) echo $classH ?>'>
									<a href="<? echo base_url()?>workprofilefrontend/employeHistory/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('employmentNeducation');?></a>
								</li>
							<?php } ?>
							<li class='<?php if(isset($classPD)) echo $classPD ?>'>
								<a href="<? echo base_url()?>workprofilefrontend/personalDetails/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('personalDetails');?></a>
							</li>
							<?php
							//Check if history is available 
							if((isset($getSummaryData['getReference']) && count($getSummaryData['getReference']) > 0) || (isset($getSummaryData['getRecommandation']) && count($getSummaryData['getRecommandation']) > 0)) { ?>
								<li class='<?php if(isset($classS))echo $classS ?>'>
									<a  href="<? echo base_url()?>workprofilefrontend/employeShowcase/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('refNrecom');?></a>
								</li> 
							<?php }
						} else { 
					  
							//Check if profiletext is available 
							if(isset($getMediaData['getprofileText']) && count($getMediaData['getprofileText']) > 0) { ?>
								<li class='<?php if(isset($classT)) echo $classT ?>'>
									<a href="<? echo base_url()?>workprofilefrontend/employeText/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('text');?></a>
								</li>
							<?php } 
							//Check if audio is available 
							if(isset($getMediaData['getprofileAudio']) && count($getMediaData['getprofileAudio']) > 0) { ?>
								<li class='<?php if(isset($classA)) echo $classA ?>'>
									<a href="<? echo base_url()?>workprofilefrontend/employeAudio/<?php echo $accessUserProfile ?>"><?php echo $this->lang->line('audio');?></a>
								</li>
							<?php } 
							//Check if image is available 
							if(isset($getMediaData['getprofileImages']) && count($getMediaData['getprofileImages']) > 0) { ?>
								<li class='<?php if(isset($classI)) echo $classI ?>'>
									<a href="<? echo base_url()?>workprofilefrontend/employeImages/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('images');?></a>
								</li>
							<?php } 
							//Check if video is available
							if(isset($getMediaData['getvideo']) && count($getMediaData['getvideo']) > 0) { ?>
								<li class='<?php if(isset($classP)) echo $classP ?>'>
									<a href="<? echo base_url()?>workprofilefrontend/employePortfolio/<?php echo $accessUserProfile ?>" ><?php echo $this->lang->line('audioNvisual');?></a> 
								</li>
							<?php 
							} 
						}      
					} ?>	 
				</ul>
			</div>
		</div>
		<!--- header wrapper end --->
		
		
		<div class="clearbox port_content">
			<div class="sap_15"></div>
			<!--- content wrapper start --->
			 <?php 
			 echo get_global_messages(); 
			 echo $content;?>
			<!--- content wrapper end --->
		
			<div class="sap_60"></div>
		
		<!--- footer wrapper start --->
		<?php if($uri!='unauthorized') {
			if(!empty($wpSocialMedia)) { ?>
				<div class="scoail_icon_port fl pl10 ">
					<ul>
						<?php 
						foreach($wpSocialMedia as $sociallink) { ?>
							<li> 
								<a class="social_btn <?php echo $sociallink->profileSocialMediaName;?>" href="<?php echo $sociallink->socialLink;?>"></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
			<div class="fr">
				<?php				
				//To show social icons of showcase
				$socialMediaCondition = array('userId'=>$userId,'for'=>'workprofile');
				echo Modules::run('showcase/showUserSocialLinks',$socialMediaCondition); 
				$showcaseLink = base_url('showcase/index/'.$profileUserId);?>
					
				<button onclick="gotourl('<?php echo $showcaseLink;?>',1);" type="button" class="mr10 fl toad_btn"><?php echo $this->lang->line('SeeMeOnToadsquare');?></button>
				<?php				
				if( ($uri!='employeImages') && ($uri!='employePortfolio') && ($uri!='employeText') && ($uri!='employeAudio') ) { ?>	
					<a href="<?php echo base_url()?>workprofile/pdf_generate/<?php echo $accessUserProfile ?>" target="_blank">
						<button type="button" class="fl print_btn"><?php echo $this->lang->line('print');?></button>
					</a>
				<?php }?>
			</div>
		<?php 
		}?>
		<!--- footer wrapper end --->
		
	</div>
<!--main-->
</body>
</html>
