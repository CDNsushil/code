<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//echo '<pre>';
//print_r($promoMedias);die;
	// set default image 
$defaultImage = $this->config->item('defaultUpcomingImg_m');
if($upcomingProjData['thumbFileId'] > 0) {
	// get image data of media
	$thumbImageData = getMediaDetail($upcomingProjData['thumbFileId']);
	$thumbImgPath = (!empty($thumbImageData)) ? $thumbImageData[0]->filePath : '';
	$thumbImgName = (!empty($thumbImageData)) ? $thumbImageData[0]->fileName : '';
	// set image file path
	$filePath = $thumbImgPath.$thumbImgName;
} else {
	// set image file path
	$filePath = $upcomingProjData['filePath'].$upcomingProjData['fileName'];
}
// get media image
$smallImg = addThumbFolder($filePath,'_xl');										
$projectImage  = getImage($smallImg,$defaultImage);	
// get project counts
$craveCount   =  (!empty($upcomingProjData['craveCount']))?$upcomingProjData['craveCount']:0;
$viewCount    =  (!empty($upcomingProjData['viewCount']))?$upcomingProjData['viewCount']:0;
$ratingAvg    =  (!empty($upcomingProjData['ratingAvg']))?$upcomingProjData['ratingAvg']:0;
$reviewCount  =  (!empty($upcomingProjData['reviewCount']))?$upcomingProjData['reviewCount']:0;
$projectId    =  (!empty($upcomingProjData['projId']))?$upcomingProjData['projId']:0;
$entityId     =  getMasterTableRecord('TDS_UpcomingProject'); // get project entityId
$isPublished  =  $upcomingProjData['isPublished'];
$projectsNumberCount = count($upcomingListing);

//------check project data and convert to single diemential array------//
$projectViewNumber   =   1; //defined default value
$projectPrepareList  =   false;  // defined deafult value in array
$projectDataList = $upcomingListing;

if(!empty($projectDataList)):
	foreach($projectDataList as $key => $getProjectData){
		
		$projectPrepareList[]   =   $getProjectData['projId'];
		if($projectId == $getProjectData['projId']){
			$projectData        =  $getProjectData;
			$currentKeyPosition =  $key;
			$projectViewNumber  =  $currentKeyPosition + 1;
		}
	}
endif;

//defined default variable
$previousProjectId      =   0;
$nextProjectId          =   0;
$nextPageLink           =   '';
$previousPageLink       =   '';

//previous project show page link id get
if($currentKeyPosition > 0):
	$previousProjectId      =     $projectPrepareList[$currentKeyPosition-1];
	$previousPageLink       =     'upcomingfrontend/viewproject/'.$userId.'/'.$previousProjectId.$previewWord;
	$previousPageLink       =      base_url_lang($previousPageLink);
endif;

//previous project show page link id get
if($currentKeyPosition < ($projectsNumberCount-1)):
	$nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
	$nextPageLink       =    'upcomingfrontend/viewproject/'.$userId.'/'.$nextProjectId.$previewWord;
	$nextPageLink       =     base_url_lang($nextPageLink);
endif;

?>
 <div class="banner_collection pb41 mb15 " > 
	<!--==================  full screen slider  start ============-->
	<div class="width908 display_table m_auto pb38 pt10">
		<h2  class="font_bold lineH19 fl"><?php echo $upcomingProjData['projTitle'];?></h2>    
	</div>
	<!--==================  banner start ============-->
	<div class="width930 m_auto upcoming_wrap">
		<div class="position_relative mr18 fl width560">
			<img src="<?php echo $projectImage; ?>" alt="" />  
			<div class="overlay_blog mt3 fs29 opens_light lineH35 height_auto width445 "><?php echo $upcomingProjData['mediaTitle'];?></div>
		</div>
		<div class="width352 fl">    
            <ul class="upcoming_img">
				<?php
				$isImageExist = 0;
				foreach($promoImages as $promoImage) {
					 $imageRootPath = ROOTPATH.$promoImage['filePath'].'/'.$promoImage['fileName'];
					if(file_exists($imageRootPath)) { ?>
						<li>
							<span class="table_cell"><img src="<?php echo $promoImage['thumbFinalImg_m'];?>" alt="" /></span>
						</li>
						<?php 
						$isImageExist++;
					} 
				} ?>
            </ul>
            <?php if( $isImageExist > 0 ) { ?>
				<div class="width352 bg_e1e1e1 p20 box_siz height64 clearb">
					<i class="commin_big_arrow"></i>
				</div>   
			<?php } ?>         
		</div>
        
		<div class="clearb pt20 pb25 ml10 mr10 bb_d7d7">  
			<p><?php echo $upcomingProjData['proShortDesc'];?> </p>
		</div>
		<!--==================  banner end ============--> 
	</div>  
	<div class="width910 m_auto sc_album mt40"> 
		<!--  left Content start  -->
		<div class="left_w width_302  lineH18 fl mr pr30">
			<div class="head_list fl pt6 pb8 pl10 width288 pr5  bg_fdfdfd bdr_ececec ">
				<p class="fl mr10 fs16">Upcoming</p>
                <div class="fl color_666">
					<div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
					<div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
					<div class="rating fl pt6"><img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" /> </div>
					<div class="btn_share_icon icon_so"><?php echo $reviewCount;?></div>
				</div>
			</div>
			<div class="sap_15"></div>
			<?php
			if(isset($upcomingRecord['askForDonation']) && $upcomingRecord['askForDonation']=='t'){		  
				$donorDetail=array('entityId'=>$entityId,'elementId'=>$upcomingRecord['projId'],'projId'=>$upcomingRecord['projId'],'sectionId'=>$sectionId,'ownerId'=>$upcomingRecord['tdsUid'],'seller_currency'=>$seller_currency);
				$this->load->view("shipping/donate_frontend_view_new",$donorDetail); 
			}?>
			<div class="clearbox pl5 ">
				<div class="sap_25 bb_e9e9e9 mb15 "></div>          
				<b class="red letter_spP7">Upcoming Media Showcase Information </b>
				<ul class="edit_list fs13">
					<li>
						<p class="red lineH15">PLANNED RELEASE DATE </p>
						<p><?php echo date('F Y',strtotime($upcomingProjData['projReleaseDate']));?></p> 
					</li>
					<li>
						<p class="red lineH15">LANGUAGE</p>
						<p><?php echo $upcomingProjData['Language_local'];?></p>
					</li>
					<li>
						<p class="red lineH15">COUNTRY OF ORIGIN</p>
						<p><?php echo $upcomingProjData['countryName'] ?></p>
					</li>
					<li>
						<p class="red lineH15">SELF CLASSIFICATION</p>
						<p><?php echo $upcomingProjData['ratingoption'] ?></p>
					</li>
				</ul>
			</div>
        
			<span class="text_alighC width100_per"	>
				<span class="sap_20"></span>
				<?php 
				//----------- advertisement of 250 X 250----------//
				if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
					//Manage right side forum advert
					$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
					if(!empty($bannerRhsData)) {
						$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
					} else {
						$this->load->view('common/adv_rhs_forum');
					}
				} else {
					$this->load->view('common/adv_rhs_forum');
				}
				//----------- advertisement of 250 X 250----------//
                ?>
			</span> 
			<div class="sap_35"></div>
			<?php 
                //---------associative creatives list start----------//
				echo  Modules::run("creativeinvolved/associativecreativeslist", $entityId,$projectId);
                //---------associative creatives list start----------//
            ?>
		</div> 
		<!-- left content end --> 
            
		<!-- right Content start -->
		<div class="rightbox width560 position_relative fr ">
			<ul class="dis_nav fl pb10 upcomin_nav fs18">
				<li id="mediaDescTab"><a onclick="manageMediaDetails(2)">Upcoming Media Showcase Description</a></li>
				<li id="mediaTab" class="active">
					<a onclick="manageMediaDetails(1)">Introductory Media</a>
				</li> 
			</ul>
			<div class="sap_65"></div>
			<!-- upcoming media description -->
			<div id="mediaDescDiv" class="dn">
				<?php echo $upcomingProjData['projDescription'];?>
				<div class="sap_25"></div>
			</div>
			<!-- Inventory media listing-->
			<div id="inventoryMediaDiv">
				<?php 
				foreach($promoMedias as $promoMedia) {
					// get image data of media
					$thumbImageData = getMediaDetail($promoMedia['thumbFileId']);
				
					$thumbImgPath = (!empty($thumbImageData)) ? $thumbImageData[0]->filePath : '';
					$thumbImgName = (!empty($thumbImageData)) ? $thumbImageData[0]->fileName : '';
												
					// get media image
					$extraSmallImg = addThumbFolder($thumbImgPath.$thumbImgName,'_m');										
					$promoImg = getImage($extraSmallImg,$defaultImage);	
					
					// Audio file shows here
					if($promoMedia['mediaType'] == 3) { ?>
						<?php 
						//$src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
						$getSrc = base_url().'en/player/getPlayerIframe/'.$promoMedia['fileId'].'_full/'.$entityId.'/'.$promoMedia['projId'].'/'.$promoMedia['projId'];
						$isvalidUrl=true; ?>
						<div class="track m_auto display_table">
							<iframe src="<?php echo $getSrc; ?>" width="279" height="128" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no" <?php if(isset($class_player)) { echo $class_player;} ?>></iframe>
						</div>      
						<p>  
							<?php echo $promoMedia['mediaDescription'];?>
						</p>
						<div class="sap_40"></div>
					<?php
					}
					// Text file shows here
					else if($promoMedia['mediaType'] == 4) {
						// set text file url
						$textUrl = base_url().$promoMedia['filePath'].'/'.$promoMedia['fileName'];
						 ?>					
						<div class=" m_auto display_table"> 
							<a href="<?php echo $textUrl;?>" class="red_c_arrow" target="_blank">
								<i class="pdf_big pr30 fl"><img src="<?php echo site_url();?>/images/pdf_big.png" alt="" /></i> <span class="pt45"> Read</span>
							</a>
						</div>
						<div class="sap_40"></div>
						<p>  
							<?php echo $promoMedia['mediaDescription'];?>
						</p>
						<div class="sap_25"></div>
					<?php 
					} 
					// Video file shows here
					else if($promoMedia['mediaType'] == 2) { ?>
						<div class=" m_auto display_table"> 
						<a onclick="openLightBox('popupBoxWp','popup_box','/upcomingfrontend/popupMedia','<?php echo $promoMedia['mediaId'];?>','2','<?php echo $entityId;?>');" href="javascript:void(0);">
							<img src="<?php echo $promoImg;?>" alt=""  />
						</a>
						</div>
						<div class="sap_30"></div>
						<p> <?php echo $promoMedia['mediaDescription'];?> </p>							
						<div class="sap_40"></div>
					<?php } 
					}?>
               </div>
				<div class="fr">
					<?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave this Media','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$userId,'projectType'=>$industryType,'isPublished'=>$isPublished);
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                   // $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));	
                    
                    //------------add news button button view load-------------//
                    $this->load->view('media/newsViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));	
					?>  
				</div>
				
				<div class="box_wrap socail_icon width_542 pb9">
					   <div class="nav open_sans  width513 display_inline_block bt_ebeb  pt20  width100_per  text_alighC   ">
                       <?php if(!empty($previousPageLink)): ?> 
                            <a class=" fl lineH20 text_alighL " href="<?php echo $previousPageLink; ?>">
                            <i class="next_collection collection_nav"></i>
                            Previous Collection </a> 
                       <?php else: ?>
                             <a class=" fl lineH20 text_alighL disable_link" href="javascript:void(0)">
                            <i class="next_collection collection_nav"></i>     
                            Previous Collection </a> 
                       <?php endif; ?> 
                       
                        <span class="counter pt3">
                            <span class="current_slide"><?php echo $projectViewNumber; ?></span>/<span class="total_slide"></span><?php echo $projectsNumberCount; ?>
                        </span> 
                        
                        <?php if(!empty($nextPageLink)): ?> 
                            <a class="  fr text_alignR lineH20" href="<?php echo $nextPageLink; ?>">
                           <span class="fl"> Next Collection</span>
                            <i class="prev_collection fr  collection_nav"></i>
                            </a>
                        <?php else: ?>
                             <a class="  fr text_alignR lineH20 disable_link" href="javascript:void(0)">
                                  <span class="fl">  Next Collection</span>
                             <i class="prev_collection fr  collection_nav"></i>
                             </a>
                        <?php endif; ?>
                    </div>
					<ul class="socail_list">
					<li>  
						<?php 
						//------create share link by current url-------//
						$currentShortUrl = uri_string();
						echo ' <span class="fl">';
							
							//-----short module link by email module array-----//
							$shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
							echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								

							//-----load module shortlink module array-----//
							$shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
							echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								

						echo '</span>';

						//-------load module of social share---------------//
						$shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'7');
						echo Modules::run("share/sharesocialshowview",$shareData);		
						?>
				   </li>
				</ul>
			</div>
			<div class="box_wrap width_542 text_alignC">
				<?php 
				//----------- advertisement of 468 X 60----------//
					if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
						//Manage left side content bottom advert
						$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
						if(!empty($bannerRhsData)) {
							$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
						} else {
							$this->load->view('common/adv_content_bot'); 
						} 
					} else {
						$this->load->view('common/adv_content_bot');  
					}
				//----------- advertisement of 468 X 60----------//
				?>
			</div>
			<?php
			//--------review list start-----------//
			echo Modules::run("mediafrontend/getReviewListNew",$entityId,$projectId);
			//---------review list end-----------//
			?>
			<!--
			<div class="box_wrap width_542 text_alignC mt15"> <a href=""> <img src="images/new_4.jpg" alt="" class="display_inline" /></a> </div>
			-->
		</div>
        <!-- right Content end  --> 
      </div>
      
  </div>




<?php/* if(count($upcomingRecord)>0) { ?>
<td class="rc_purple" valign="top">
<div class="cell width800px  sub_col_2">
 <?php 
		if(!isset($userInfo)){
			$userInfo =showCaseUserDetails($upcomingRecord['tdsUid']);
		}
		$seller_currency=$userInfo['seller_currency'];
		$seller_currency=($seller_currency>0)?$seller_currency:0;
		$currencySign=$this->config->item('currency'.$seller_currency);
		
		$sectionId=$this->config->item('upcomingSectionId');
		
		$LogSummarywhere=array(
					'entityId'=>$entityId,
					'elementId'=>$upcomingRecord['projId']
		 );
			
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary){
				$resLogSummary=$resLogSummary[0];
				$craveCount=$resLogSummary->craveCount;
				$ratingAvg=$resLogSummary->ratingAvg;
				$viewCount = $resLogSummary->viewCount;
			}else{
				$craveCount=0;
				$ratingAvg=0;
				$viewCount = 0;
			}
			
			$ratingAvg=roundRatingValue($ratingAvg);
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';		
			
			$cravedALL='';
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$entityId,
								'elementId'=>$upcomingRecord['projId']
							);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
  
     
		  if(!empty($promoImages))
		  {
			echo '<div id="popupImages" class="dn">';
			echo '<div class="popup_box">';
			echo '<div class="popup_close_btn" id="close-popup" onclick="$(this).parent().trigger(\'close\');"></div>';
				echo '<div id="popupImagesContainer" class="" >';
					
				echo '</div>';
			echo '</div>';
			echo '</div>';
		  }//End If Empty 
	  
	  ?>
        <div class="row mt14">
          <div class="upcoming_center_title ml24 "><?php echo $upcomingRecord['projTitle'];?></div>
          <div class="clear"></div>
        </div>
        <div class="seprator_14"></div>
        <!--gallery box-->
        <?php 
        //echo '<pre />';print_r($upcomingRecord);
        
		if(!empty($promoImages))
		{
			
		?>
        <div class="up_grey_box ml12 mr12 pl13 pt5 pb4">
			 <div class="slider" id="slider1"> 
			 <a href="#" class="buttons prev disable"></a>
			<?php echo Modules::run("upcomingfrontend/getPromoImages", $promoImages);?>
			 <a href="#" class="buttons next"></a> 
			</div>
        </div>
        <div class="seprator_16"></div>        
		<?php
		
		}//End If Empty 
		
		?>

<div class="position_relative">
	<div class="cell shadow_wp strip_absolute_right">
            <!-- <img src="images/strip_blog.png"  border="0"/>-->
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                <td height="271"><img src="<?php echo base_url();?>images/shadow-top.png"></td>
              </tr>
              <tr>
                <td class="shadow_mid">&nbsp;</td>
              </tr>
              <tr>
                <td height="271"><img src="<?php echo base_url();?>images/shadow-bottom.png"></td>
              </tr>
            </tbody></table>
            <div class="clear"></div>
          </div>
	
            <div class="cell width_476 mr8 ml12">
			<?php 
			  
			 echo $this->load->view('further_desc',array('ratingAvg'=>@$ratingAvg,'viewCount'=>@$viewCount,'craveCount'=>@$craveCount));              
			 ?>
			 <!-- ADS FOR CONTENT -->			
			<div class="row width470px ma mt14" id="advert468_60"> <?php 
				if(is_dir(APPPATH.'modules/advertising')){
					//Manage left side content bottom advert
					$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$sectionId,'advertType'=>'3'));
					if(!empty($bannerRhsData)) {
						$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$sectionId));
					} else {
						$this->load->view('common/adv_content_bot'); 
					}
				} else {
					$this->load->view('common/adv_content_bot'); 
				}?>
			</div>
			<div class="clear"></div>  
			<div class="seprator_20"></div>
			 <div class="clear"></div>
			 <?php
			 if(!empty($promoMedias)) { echo $this->load->view('promo_media'); }//End If empty           
			 
			 //Detail User Info
			 $userInfo = showCaseUserDetails(@$upcomingRecord['tdsUid']);    
           
           ?>
         
			<div class="clear"></div>
  			</div><!-- End width_476 --> 			
           

<div class="cell width273px pl10 pr10 mb25">            

         <div class="row summery_right_archive_wrapper showcase_link_hover">
			<h1 class="swp_user_name clr_white "><?php echo $userInfo['userFullName'];?></h1>
			<ul class="swp_user_name_link">
			  <li class="mt9">
				  <?php 
					$method = 'upcoming';
					$shocaseUrl=base_url(lang().'/upcomingfrontend/'.$method.'/'.@$upcomingRecord['tdsUid'].'/'.$upcomingRecord['projId']);
					
				  ?>
				  <a class="clr_white" href="<?php echo $shocaseUrl;?>"><?php echo $this->lang->line('viewShowcase');?></a>
			  </li>
			</ul>
		  </div>

<div class="seprator_14"></div>

<div class="row recent_box_wrapper01 mr24 p10">
		
	 <div class="cell pt2 icon_crave4_blog crave craveDiv<?php echo $entityId.''.$upcomingRecord['projId']?> <?php echo $cravedALL;?>">Craves <span class="inline"><?php echo $craveCount;?></span></span></div>
	
	  <div class=" cell padding_left16 pt8 rateDiv<?php echo $entityId.''.$upcomingRecord['projId']?>">			 
			<img  src="<?php echo base_url($ratingImg);?>" />
	 </div>
	<div class="clear"></div>
	<div class="icon_view5_blog mt4"><?php echo $this->lang->line('project_views').'&nbsp;'.$viewCount;?></div>
</div>

<div class="seprator_14"></div>
<?php 
	$tableInfo=array(
	'entityId'=>$entityId,
	'elementId'=>$upcomingRecord['projId'],
	'tableName'=>array('AddInfoNews','AddInfoInterview'),
	'sections'=>array($this->lang->line('NEWS'),$this->lang->line('INTERVIEWS')),
	'orderBy'=>array('news','interv'),
	'sectionBgcolor'=>'rightBoxBG',
	'largeTab'=>1
	);
	echo Modules::run("additionalInfo/additionalInfoList", $tableInfo);
	if(isset($upcomingRecord['askForDonation']) && $upcomingRecord['askForDonation']=='t'){
		?>          
		<div class="ml34 mr39">
		  <div class="line5"></div>
		  <div class="seprator_10"></div>
		  <div class="Fright">
			  <?php			  
				  $donorDetail=array('entityId'=>$entityId,'elementId'=>$upcomingRecord['projId'],'projId'=>$upcomingRecord['projId'],'sectionId'=>$sectionId,'ownerId'=>$upcomingRecord['tdsUid'],'seller_currency'=>$seller_currency);
				  $this->load->view("shipping/donate_frontend_view",$donorDetail); 
			  ?>
		 </div>
		</div>
	<?php
	}?>
	<div class="clear seprator_20"></div>			  
	<div class="ad_box_shadow width250px mb20" id="advert250_250"><?php 	
		if(is_dir(APPPATH.'modules/advertising') && !empty($sectionId) && $sectionId!='3:1' && $sectionId!='3:2'){
			//Manage right side forum advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$sectionId,'advertType'=>'1'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$sectionId));
			} else {
				$this->load->view('common/adv_rhs_forum');
			}
		} else {
			$this->load->view('common/adv_rhs_forum');
		}?>
	</div>
</div>

</div><!-- End position_relative -->
</div>

</td><td  class="advert_column" valign="top">
<div class="cell sub_col_3">
	<div class="ad_box ml11 mt10 mb10" id="advert160_600">
		<?php 
		if(is_dir(APPPATH.'modules/advertising') && !empty($sectionId) && $sectionId!='3:1' && $sectionId!='3:2'){
			//Manage right side advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$sectionId,'advertType'=>'2'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$sectionId)); 
			} else {
				$this->load->view('common/adv_rhs');
			} 
		} else {
			$this->load->view('common/adv_rhs');
		}?> 
	</div>
<div class="clear"></div>
</div>
<div class="clear"></div>  

<?php } else { echo '<div class=" pt13 pl20 pr11 pb20 orange width950px height525px" align="center">'.$this->lang->line('noRecordFound').'</div>';} */?>
<script type="text/javascript">
	$(document).ready(function(){
			$('#slider1').tinycarousel({ axis: 'y', display: 2});	
			$('#slider2').tinycarousel({ axis: 'y', display: 3});
			$('#slider3').tinycarousel({ axis: 'y', display: 3});
	});
	// Manage introductory and description
	function manageMediaDetails(isMediaType) {
		if(isMediaType == 1) {
			$('#mediaDescDiv').hide();
			$('#inventoryMediaDiv').show();
			$('#mediaTab').addClass('active');
			$('#mediaDescTab').removeClass('active');
		} else {
			$('#mediaDescDiv').show();
			$('#inventoryMediaDiv').hide();
			$('#mediaDescTab').addClass('active');
			$('#mediaTab').removeClass('active');
		}
	} 
</script>

<?php
if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
	//manage auto advert params and js methods
	//echo $advertChangeView;
}
?>
