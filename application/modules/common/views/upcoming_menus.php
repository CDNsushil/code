<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$isLoginUser = isLoginUser();
    
//get user subscription type
$subscriptionType   =   LoginUserDetails('subscriptionType');
$subscriptionType   =   (!empty($subscriptionType))?$subscriptionType:0;
    
$isUserShowcase = false;   
$isUserMediaShowcase = false;   
//check user showcase
if((!empty($showcaseDetails['tagwords']) && strlen($showcaseDetails['tagwords']) > 4) || (!empty($showcaseDetails['promotinalSection']) && strlen($showcaseDetails['promotinalSection']) > 4) ){
    $isUserShowcase = true;                  
}

//check user media showcase
$isUpcomingFilmNvideo          =  false;
$isUpcomingPhotographyNart     =  false;
$isUpcomingMusicNaudio         =  false;
$isUpcomingWritingNpublishing  =  false;
$isUpcomingEducationMaterial   =  false;

if(in_array('1',$completedUpcomingMediaList)){
	$isUpcomingFilmNvideo = true;
}

if(in_array('4',$completedUpcomingMediaList)){
	$isUpcomingPhotographyNart = true;
}

if(in_array('2',$completedUpcomingMediaList)){
	$isUpcomingMusicNaudio = true;
}

if(in_array('3',$completedUpcomingMediaList)){
	$isUpcomingWritingNpublishing = true;
}

if(in_array('10',$completedUpcomingMediaList)){
    $isUpcomingEducationMaterial = true;
}

if($isUpcomingFilmNvideo || $isUpcomingPhotographyNart || $isUpcomingMusicNaudio || $isUpcomingWritingNpublishing || $isUpcomingEducationMaterial ) {
    $isUpcomingMediaShowcase = true; 
}

$fans = LoginUserDetails('fans'); 
?>
    
 <?php 
if($isUserShowcase && $fans=='f'){ ?> 
	<li data-submenu-id="sub_t10" class="bg_f1f1f1 main_menu pt15">
		<?php if($isUpcomingMediaShowcase == true || !empty($incompletedUpcomingMediaList)) { ?>
			<a href="javascript:void(0)"><span><?php echo $this->lang->line('Your_Add'); ?></span> <?php echo $this->lang->line('add_upcomingmediaS'); ?></a>
			<ul class="menu_inner popover  menusecond"  id="sub_t10">
			  <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl"><?php echo $this->lang->line('Your_upcomingmediaS'); ?></span></li>
				
			  <li> 
				<span class="content_menu  pl35 pb30 pt30 pr30">
					<?php
					//------not completed media menu list------//
					if(!empty($incompletedUpcomingMediaList)){ ?>
					   
					  <b class="green you_todo_icon "> <?php echo $this->lang->line('Your_mediayouhave'); ?></b> <span class="sap_15"></span>
						<ul class="width100_per pt10 fs14 fl  listpb10 red_arrow_list bbcbcbcb mb20 pb10">
						<?php if(in_array('1',$incompletedUpcomingMediaList)) { ?>     
						
							<li><a href="<?php echo base_url(lang().'/upcomingprojects/completeyourshowcase/1');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaFilmVideo');  ?> </a></li>
							
							<?php if($subscriptionType==1){ ?>
								<li><a href="#"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b><?php echo $this->lang->line('Your_upcomingMediaFilmVideo');  ?></a></li>
							<?php } ?>
					  
						<?php } if(in_array('2',$incompletedUpcomingMediaList)) { ?> 
						
							<li><a href="<?php echo base_url(lang().'/upcomingprojects/completeyourshowcase/2');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaMusicAudio');  ?> </a></li>
						   
							<?php if($subscriptionType==1){ ?>
								<li><a href="#"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaMusicAudio');  ?></a></li>
							<?php } ?>
							
						<?php } if(in_array('4',$incompletedUpcomingMediaList)) { ?> 
							
							<li><a href="<?php echo base_url(lang().'/upcomingprojects/completeyourshowcase/4');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaPhotoArt');  ?> </a></li>
						   
							<?php if($subscriptionType==1){ ?>
								<li><a href="#"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b>  <?php echo $this->lang->line('Your_upcomingMediaPhotoArt');  ?>   </a></li>
							<?php } ?>
						
						<?php } if(in_array('3',$incompletedUpcomingMediaList)) { ?> 
							
							<li><a href="<?php echo base_url(lang().'/upcomingprojects/completeyourshowcase/3');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaWriteColl');  ?> </a></li>
							
							<?php if($subscriptionType==1){ ?>
								<li><a href="#"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaWriteColl');  ?>  </a></li>
							<?php } ?>
							
						<?php } if(in_array('10',$incompletedUpcomingMediaList)) { ?> 
						
							<li><a href="<?php echo base_url(lang().'/upcomingprojects/completeyourshowcase/10');?>"><b><?php echo $this->lang->line('Your_mediaComplete');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaCreativeIndustries');  ?> </a></li>
							
							<?php if($subscriptionType==1){ ?>
								<li><a href="#"><b><?php echo $this->lang->line('Your_mediaRenew');  ?></b> <?php echo $this->lang->line('Your_upcomingMediaCreativeIndustries');  ?></a></li>
							<?php } ?>
							
						<?php } ?>     
					</ul>
					<span class="sap_30"></span>
				<?php
				 } ?>
				
				<!-- Film & Video colletion links--> 
				<?php if($isUpcomingMediaShowcase) { ?> 
					
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"><?php echo $this->lang->line('Your_upcomingmediaS');  ?></h3>
					<span class="sap_20"></span>
					<ul class="width100_per listpb10  fs13  red_arrow_list">
						<li><a href="<?php echo base_url(lang().'/upcomingprojects/publicisemediacollection');?>"> <?php echo $this->lang->line('Your_upcomingmediapublish');  ?> </a></li>
						<li><a href="<?php echo base_url(lang().'/upcomingprojects/upcomingeditmedia');?>"><?php echo $this->lang->line('Your_upcomingmediaedit');  ?>  </a></li>
						<li><a href="<?php echo base_url(lang().'/filmnvideo/upcoming');?>"> <?php echo $this->lang->line('Your_upcomingmediaview');  ?> </a></li>
					</ul>                    
					<span class="sap_30"></span>
				<?php }
				 /*
				 if($isUpcomingMusicNaudio) { ?> 
					<!-- Music & Audio colletion links-->   
					
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"><?php echo $this->lang->line('Your_upcomingMediaManageMA');  ?></h3>
					<span class="sap_20"></span>
					<ul class="width100_per listpb10  fs13  red_arrow_list">
						<li><a href="<?php echo base_url(lang().'/media/musicaudio/publicisemediacollection');?>"> <?php echo $this->lang->line('Your_mediapublishMA');  ?></a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/editmusicaudiocollection');?>"><?php echo $this->lang->line('Your_mediaeditMA');  ?>  </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/musicaudiocollection/'.$isLoginUser);?>"> <?php echo $this->lang->line('Your_mediaviewMA');  ?></a></li>
					</ul>
				<span class="sap_30"></span>
				<?php } if($isUpcomingPhotographyNart) { ?>  
					<!--  Photos & Artworks colletion links-->
					
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"><?php echo $this->lang->line('Your_upcomingMediaManagePA');  ?></h3>
					<span class="sap_20"></span>
					<ul class="width100_per listpb10  fs13  red_arrow_list">
						<li><a href="<?php echo base_url(lang().'/media/photographyart/publicisemediacollection');?>"> <?php echo $this->lang->line('Your_mediapublishPA');  ?> </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/editphotoartcollection');?>"><?php echo $this->lang->line('Your_mediaeditPA');  ?>   </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/photoartcollection/'.$isLoginUser);?>">  <?php echo $this->lang->line('Your_mediaviewPA');  ?>  </a></li>
					</ul>
				<span class="sap_30"></span>
				<?php  } if($isUpcomingWritingNpublishing) { ?>  
					<!-- Writings colletion links-->
					
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"> <?php echo $this->lang->line('Your_upcomingMediaManageWC');  ?> </h3>
					<span class="sap_20"></span>
					<ul class="width100_per listpb10  fs13  red_arrow_list">
						<li><a href="<?php echo base_url(lang().'/media/writingpublishing/publicisemediacollection');?>">  <?php echo $this->lang->line('Your_mediapublishWC');  ?> </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/editwritingpubcollection');?>"><?php echo $this->lang->line('Your_mediaeditWC');  ?>   </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/writingpubcollection/'.$isLoginUser);?>">  <?php echo $this->lang->line('Your_mediaviewWC');  ?></a></li>
				</ul>  
				<span class="sap_30"></span>
				<?php  } if($isUpcomingEducationMaterial) { ?> 
					<!-- Educational Media colletion links-->
					
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"><?php echo $this->lang->line('Your_upcomingMediaManageCIE');  ?></h3>
					<span class="sap_20"></span>
					<ul class="width100_per listpb10  fs13  red_arrow_list">
						<li><a href="<?php echo base_url(lang().'/media/educationmaterials/publicisemediacollection');?>"> <?php echo $this->lang->line('Your_mediapublishCIE');  ?></a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/editeducationalcollection');?>"><?php echo $this->lang->line('Your_mediaeditCIE');  ?>  </a></li>
						<li><a href="<?php echo base_url(lang().'/mediafrontend/educationalcollection/'.$isLoginUser);?>"> <?php echo $this->lang->line('Your_mediaviewCIE');  ?> </a></li>
					</ul>
				<?php } */?>                             
				</span> 
			   <p class="red pl50 pt20 pb20 bg_f8f8f8 pr30"><?php echo $this->lang->line('Your_upcomingmediawhattype'); ?></p>
				<span class="content_menu pl35  pt30 pr30">
					<form action="<?php echo base_url(lang().'/upcomingprojects/setmediaaddtype');?>" method="post" id="upcomingMediaAddForm">
						<ul class="pl100 red_arrow_list menu_radio defaultP  listpb10">
							<li><input type="radio" class="mediaselect" id="1" name="mediaType" checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
							<li><input type="radio" class="mediaselect" id="2" name="mediaType" value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
							<li><input type="radio" class="mediaselect" id="4" name="mediaType" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
							<li><input type="radio" class="mediaselect" id="3" name="mediaType" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
							<li><input type="radio" class="mediaselect" id="10" name="mediaType" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
						</ul>
											
							<span class="sap_20"></span>
							<button class="fr gray_btn upcomingmediasubmit" type="button"> <?php echo $this->lang->line('Your_Next'); ?></button>
							<span class="sap_20"></span>
					   </form>
				</span> </li>
			   </ul>
			  
		<?php }else{ ?>
			<a href="javascript:void(0)"> <span><?php echo $this->lang->line('Your_Add'); ?></span> <?php echo $this->lang->line('add_upcomingmediaS'); ?></a>
			<ul class="menu_inner popover menusecond"  id="sub_t10">
			<li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl"><?php echo $this->lang->line('Your_upcomingmediaAdd'); ?></span></li>
			<li>
				<span class="content_menu  pl35 pb30 pt30 pr30">
					<h3 class=" fs16 bbcbcbcb lineH26 red open_sans"><?php echo $this->lang->line('add_upcomingnote'); ?> </h3>
					<span class="sap_15"></span>
					<p><?php echo $this->lang->line('add_upcomingnoterow'); ?> </p>
					<span class="sap_20"></span> 
					<p><?php echo $this->lang->line('add_upcomingnoterow1'); ?></p>
				</span>
				  
				 <p class="red pl50 pt20 pb20 bg_f8f8f8 pr30"><?php echo $this->lang->line('Your_upcomingmediawhattype'); ?></p>
				 <span class="content_menu pl35  pt30 pr30">
					<form action="<?php echo base_url(lang().'/upcomingprojects/setmediaaddtype');?>" method="post" id="upcomingMediaAddForm">
						<ul class="pl100 red_arrow_list menu_radio defaultP  listpb10">
							<li><input type="radio" name="mediaType" class="mediaselect" id="1"  checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
							<li><input type="radio" name="mediaType" class="mediaselect" id="2"  value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
							<li><input type="radio" name="mediaType" class="mediaselect" id="4" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
							<li><input type="radio" name="mediaType" class="mediaselect" id="3" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
							<li><input type="radio" name="mediaType" class="mediaselect" id="10" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
						</ul>
											
						<span class="sap_20"></span>
						<button class="fr gray_btn upcomingmediasubmit" type="button"> <?php echo $this->lang->line('Your_Next'); ?></button>
					</form>
				 </span>
			  </li>
		   </ul>
		<?php }?>
	</li>
<?php } ?>
